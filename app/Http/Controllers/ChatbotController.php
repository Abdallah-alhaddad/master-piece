<?php

namespace App\Http\Controllers;

use App\Services\InfermedicaService;
use App\Services\OpenFDAService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $infermedicaService;
    protected $openFDAService;

    public function __construct(InfermedicaService $infermedicaService, OpenFDAService $openFDAService)
    {
        $this->infermedicaService = $infermedicaService;
        $this->openFDAService = $openFDAService;
    }

    public function recommend(Request $request)
    {
        try {
            $symptoms = strtolower($request->input('symptoms'));
            
            if (empty($symptoms)) {
                return response()->json([
                    'specializations' => [],
                    'message' => 'Please describe your symptoms.'
                ]);
            }

            // Check if the message contains drug-related queries
            if ($this->isDrugQuery($symptoms)) {
                $drugInfo = $this->handleDrugQuery($symptoms);
                return response()->json([
                    'specializations' => ['Pharmacist'],
                    'message' => $drugInfo,
                    'isDrugInfo' => true
                ]);
            }

            // Split symptoms into words and clean them
            $symptomWords = array_filter(explode(' ', $symptoms), function($word) {
                return strlen($word) > 2;
            });

            // Get specializations based on symptoms
            $specializations = $this->getSpecializations($symptomWords);
            Log::info('Recommended specializations: ' . implode(', ', $specializations));

            // Get specialization IDs from the database
            $specializationIds = [];
            foreach ($specializations as $specialization) {
                $spec = \App\Models\Specialization::where('name', $specialization)->first();
                if ($spec) {
                    $specializationIds[$specialization] = $spec->id;
                } else {
                    Log::warning("Specialization not found in database: " . $specialization);
                    // Use a default ID or handle missing specialization
                    $specializationIds[$specialization] = 1; // Assuming 1 is General Practitioner
                }
            }

            // Create message with clickable links
            $message = 'Based on your symptoms, I recommend consulting with ';
            if (count($specializations) === 1) {
                $specialization = $specializations[0];
                $specializationId = $specializationIds[$specialization] ?? 1;
                $message .= "<a href='/doctors?specializations[]={$specializationId}' class='text-blue-600 hover:text-blue-800 underline' target='_blank'>{$specialization}</a>";
            } else {
                $lastSpecialization = array_pop($specializations);
                foreach ($specializations as $specialization) {
                    $specializationId = $specializationIds[$specialization] ?? 1;
                    $message .= "<a href='/doctors?specializations[]={$specializationId}' class='text-blue-600 hover:text-blue-800 underline' target='_blank'>{$specialization}</a>, ";
                }
                $lastSpecializationId = $specializationIds[$lastSpecialization] ?? 1;
                $message .= "or <a href='/doctors?specializations[]={$lastSpecializationId}' class='text-blue-600 hover:text-blue-800 underline' target='_blank'>{$lastSpecialization}</a>";
            }
            $message .= " specialist.";

            return response()->json([
                'specializations' => $specializations,
                'specializationIds' => $specializationIds,
                'message' => $message,
                'hasLinks' => true
            ]);
            
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'specializations' => ['General Practitioner'],
                'message' => 'An error occurred while processing your request. Please consult with a General Practitioner.'
            ], 500);
        }
    }

    private function isDrugQuery($symptoms)
    {
        $drugKeywords = [
            'medication', 'drug', 'pill', 'medicine', 'prescription',
            'paracetamol', 'ibuprofen', 'aspirin', 'acetaminophen',
            'taking', 'using', 'about', 'side effects', 'effects',
            'dosage', 'dose', 'how to take', 'information'
        ];
        
        $symptoms = strtolower($symptoms);
        foreach ($drugKeywords as $keyword) {
            if (strpos($symptoms, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function handleDrugQuery($symptoms)
    {
        // Extract drug name from the query
        $drugName = $this->extractDrugName($symptoms);
        if (!$drugName) {
            return 'I couldn\'t identify the medication you\'re asking about. Please specify the name of the medication.';
        }

        $drugInfo = $this->openFDAService->getDrugInfo($drugName);
        if (!$drugInfo) {
            return "I couldn't find information about {$drugName}. Please consult with a pharmacist for more information.";
        }

        // If we have detailed info from our fallback data
        if (isset($drugInfo['info'])) {
            return $drugInfo['info'];
        }

        // Otherwise format the FDA API response
        $message = "Here's what I found about {$drugInfo['name']}:\n\n";
        $message .= "Manufacturer: {$drugInfo['manufacturer']}\n";
        $message .= "Route: {$drugInfo['route']}\n";
        $message .= "Indication: {$drugInfo['indication']}\n";
        
        if (!empty($drugInfo['reactions'])) {
            $message .= "\nCommon reactions: " . implode(', ', $drugInfo['reactions']) . "\n";
        }

        $message .= "\nImportant: This information is for educational purposes only. Always consult with a healthcare professional before taking any medication.";

        return $message;
    }

    private function extractDrugName($symptoms)
    {
        $commonDrugs = [
            'paracetamol' => 'paracetamol',
            'acetaminophen' => 'paracetamol',
            'ibuprofen' => 'ibuprofen',
            'aspirin' => 'aspirin',
            'panadol' => 'paracetamol',
            'tylenol' => 'paracetamol'
        ];

        $symptoms = strtolower($symptoms);
        foreach ($commonDrugs as $alias => $drug) {
            if (strpos($symptoms, $alias) !== false) {
                return $drug;
            }
        }

        // If no common drug found, try to extract the word after "taking" or "about"
        if (preg_match('/\b(taking|about)\s+(\w+)/i', $symptoms, $matches)) {
            return $matches[2];
        }

        return null;
    }

    private function getSpecializations($symptoms)
    {
        try {
            // Symptom to specialization mapping
            $symptomSpecializations = [
                'headache' => ['Neurology', 'General Practitioner'],
                'fever' => ['General Practitioner'],
                'rash' => ['Dermatology'],
                'skin' => ['Dermatology'],
                'stomach' => ['Gastroenterology'],
                'pain' => ['General Practitioner'],
                'chest' => ['Cardiology'],
                'heart' => ['Cardiology'],
                'eye' => ['Ophthalmology'],
                'vision' => ['Ophthalmology'],
                'ear' => ['ENT Specialist'],
                'nose' => ['ENT Specialist'],
                'throat' => ['ENT Specialist'],
                'bone' => ['Orthopedics'],
                'joint' => ['Orthopedics'],
                'mental' => ['Psychiatry'],
                'anxiety' => ['Psychiatry'],
                'depression' => ['Psychiatry'],
                'child' => ['Pediatrics'],
                'pregnancy' => ['Gynecology'],
                'women' => ['Gynecology'],
                'men' => ['Urology'],
                'urinary' => ['Urology'],
                'kidney' => ['Nephrology'],
                'lung' => ['Pulmonology'],
                'breathing' => ['Pulmonology'],
                'cough' => ['Pulmonology'],
                'allergy' => ['Allergy and Immunology'],
                'immune' => ['Allergy and Immunology'],
                'cancer' => ['Oncology'],
                'tumor' => ['Oncology'],
                'diabetes' => ['Endocrinology'],
                'hormone' => ['Endocrinology'],
                'thyroid' => ['Endocrinology']
            ];

            $matchedSpecializations = [];

            foreach ($symptoms as $symptom) {
                foreach ($symptomSpecializations as $key => $specializations) {
                    if (strpos($symptom, $key) !== false) {
                        $matchedSpecializations = array_merge($matchedSpecializations, $specializations);
                    }
                }
            }

            // Remove duplicates and limit to top 3 specializations
            $matchedSpecializations = array_unique($matchedSpecializations);
            $matchedSpecializations = array_slice($matchedSpecializations, 0, 3);

            // If no specific specializations found, recommend General Practitioner
            if (empty($matchedSpecializations)) {
                return ['General Practitioner'];
            }

            return $matchedSpecializations;
        } catch (\Exception $e) {
            Log::error('Error in getSpecializations: ' . $e->getMessage());
            return ['General Practitioner'];
        }
    }
} 