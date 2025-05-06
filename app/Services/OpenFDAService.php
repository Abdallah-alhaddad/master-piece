<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OpenFDAService
{
    private $baseUrl = 'https://api.fda.gov/drug/event.json';
    private $commonDrugs = [
        'ibuprofen' => [
            'name' => 'Ibuprofen',
            'manufacturer' => 'Various manufacturers',
            'route' => 'Oral',
            'indication' => 'Pain relief, fever reduction, inflammation',
            'reactions' => ['Stomach pain', 'Heartburn', 'Nausea', 'Dizziness'],
            'info' => "Ibuprofen is a nonsteroidal anti-inflammatory drug (NSAID) used to treat mild to moderate pain, and helps to relieve symptoms of arthritis, menstrual cramps, and other conditions.\n\n" .
                     "Common uses:\n" .
                     "- Headache\n" .
                     "- Muscle aches\n" .
                     "- Arthritis\n" .
                     "- Menstrual cramps\n" .
                     "- Fever\n\n" .
                     "Important safety information:\n" .
                     "- Take with food or milk to prevent stomach upset\n" .
                     "- Do not take if you have stomach ulcers or bleeding\n" .
                     "- Avoid alcohol while taking ibuprofen\n" .
                     "- Check with your doctor if you have heart or kidney problems\n" .
                     "- Keep out of reach of children"
        ],
        'paracetamol' => [
            'name' => 'Paracetamol',
            'manufacturer' => 'Various manufacturers',
            'route' => 'Oral',
            'indication' => 'Pain relief, fever reduction',
            'reactions' => ['Liver damage (with overdose)', 'Allergic reactions'],
            'info' => "Paracetamol (also known as acetaminophen) is a common pain reliever and fever reducer.\n\n" .
                     "Common uses:\n" .
                     "- Headache\n" .
                     "- Fever\n" .
                     "- Mild to moderate pain\n\n" .
                     "Important safety information:\n" .
                     "- Do not exceed the recommended dose\n" .
                     "- Avoid alcohol while taking paracetamol\n" .
                     "- Check with your doctor if you have liver problems\n" .
                     "- Keep out of reach of children"
        ],
        'aspirin' => [
            'name' => 'Aspirin',
            'manufacturer' => 'Various manufacturers',
            'route' => 'Oral',
            'indication' => 'Pain relief, fever reduction, blood thinning',
            'reactions' => ['Stomach irritation', 'Bleeding', 'Allergic reactions'],
            'info' => "Aspirin is a salicylate used to treat pain, fever, and inflammation.\n\n" .
                     "Common uses:\n" .
                     "- Headache\n" .
                     "- Fever\n" .
                     "- Pain and inflammation\n" .
                     "- Heart attack prevention (low dose)\n\n" .
                     "Important safety information:\n" .
                     "- Do not give to children under 16\n" .
                     "- Take with food to prevent stomach upset\n" .
                     "- Avoid alcohol while taking aspirin\n" .
                     "- Check with your doctor if you have bleeding disorders\n" .
                     "- Keep out of reach of children"
        ]
    ];

    public function searchDrugEvents($searchTerm)
    {
        return Cache::remember('fda_drug_events_' . md5($searchTerm), 3600, function () use ($searchTerm) {
            $response = Http::get($this->baseUrl, [
                'search' => "patient.drug.medicinalproduct:\"{$searchTerm}\"",
                'limit' => 5
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    public function getDrugInfo($drugName)
    {
        // First check if we have fallback information for this drug
        $drugName = strtolower($drugName);
        if (isset($this->commonDrugs[$drugName])) {
            return $this->commonDrugs[$drugName];
        }

        // If not, try the FDA API
        return Cache::remember('fda_drug_info_' . md5($drugName), 3600, function () use ($drugName) {
            $response = Http::get($this->baseUrl, [
                'search' => "patient.drug.medicinalproduct:\"{$drugName}\"",
                'limit' => 1
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['results'][0])) {
                    return $this->formatDrugInfo($data['results'][0]);
                }
            }

            return null;
        });
    }

    private function formatDrugInfo($drugData)
    {
        $info = [
            'name' => $drugData['patient']['drug'][0]['medicinalproduct'] ?? 'Unknown',
            'manufacturer' => $drugData['patient']['drug'][0]['openfda']['manufacturer_name'][0] ?? 'Unknown',
            'route' => $drugData['patient']['drug'][0]['drugadministrationroute'] ?? 'Unknown',
            'indication' => $drugData['patient']['drug'][0]['drugindication'] ?? 'Unknown',
            'reactions' => $drugData['patient']['reaction'] ?? []
        ];

        return $info;
    }
} 