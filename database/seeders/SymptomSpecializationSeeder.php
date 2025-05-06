<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SymptomSpecialization;

class SymptomSpecializationSeeder extends Seeder
{
    public function run()
    {
        $mappings = [
            // Cardiology
            ['symptom' => 'chest', 'specialization' => 'Cardiology', 'weight' => 3],
            ['symptom' => 'heart', 'specialization' => 'Cardiology', 'weight' => 3],
            ['symptom' => 'blood pressure', 'specialization' => 'Cardiology', 'weight' => 2],
            
            // Dermatology
            ['symptom' => 'skin', 'specialization' => 'Dermatology', 'weight' => 3],
            ['symptom' => 'rash', 'specialization' => 'Dermatology', 'weight' => 3],
            ['symptom' => 'acne', 'specialization' => 'Dermatology', 'weight' => 2],
            
            // Neurology
            ['symptom' => 'headache', 'specialization' => 'Neurology', 'weight' => 3],
            ['symptom' => 'dizziness', 'specialization' => 'Neurology', 'weight' => 2],
            ['symptom' => 'seizure', 'specialization' => 'Neurology', 'weight' => 3],
            
            // Pediatrics
            ['symptom' => 'child', 'specialization' => 'Pediatrics', 'weight' => 3],
            ['symptom' => 'baby', 'specialization' => 'Pediatrics', 'weight' => 3],
            ['symptom' => 'infant', 'specialization' => 'Pediatrics', 'weight' => 3],
            
            // Orthopedics
            ['symptom' => 'bone', 'specialization' => 'Orthopedics', 'weight' => 3],
            ['symptom' => 'joint', 'specialization' => 'Orthopedics', 'weight' => 3],
            ['symptom' => 'fracture', 'specialization' => 'Orthopedics', 'weight' => 3],
            
            // Add more mappings as needed
        ];

        foreach ($mappings as $mapping) {
            SymptomSpecialization::create($mapping);
        }
    }
} 