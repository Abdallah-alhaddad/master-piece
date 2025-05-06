<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class InfermedicaService
{
    private $apiUrl = 'https://api.infermedica.com/v3';
    private $appId;
    private $appKey;

    public function __construct()
    {
        $this->appId = config('services.infermedica.app_id');
        $this->appKey = config('services.infermedica.app_key');
    }

    public function getSymptoms()
    {
        return Cache::remember('infermedica_symptoms', 3600, function () {
            $response = Http::withHeaders([
                'App-Id' => $this->appId,
                'App-Key' => $this->appKey,
                'Content-Type' => 'application/json'
            ])->get($this->apiUrl . '/symptoms');

            return $response->json();
        });
    }

    public function getSpecializations()
    {
        return Cache::remember('infermedica_specializations', 3600, function () {
            $response = Http::withHeaders([
                'App-Id' => $this->appId,
                'App-Key' => $this->appKey,
                'Content-Type' => 'application/json'
            ])->get($this->apiUrl . '/specializations');

            return $response->json();
        });
    }

    public function diagnose($symptoms)
    {
        $response = Http::withHeaders([
            'App-Id' => $this->appId,
            'App-Key' => $this->appKey,
            'Content-Type' => 'application/json'
        ])->post($this->apiUrl . '/diagnosis', [
            'sex' => 'male', // Default to male, you can make this dynamic
            'age' => 30, // Default age, you can make this dynamic
            'evidence' => $this->prepareSymptoms($symptoms)
        ]);

        return $response->json();
    }

    private function prepareSymptoms($symptoms)
    {
        $allSymptoms = $this->getSymptoms();
        $evidence = [];

        foreach ($symptoms as $symptom) {
            $matchedSymptom = $this->findMatchingSymptom($symptom, $allSymptoms);
            if ($matchedSymptom) {
                $evidence[] = [
                    'id' => $matchedSymptom['id'],
                    'choice_id' => 'present',
                    'source' => 'initial'
                ];
            }
        }

        return $evidence;
    }

    private function findMatchingSymptom($symptom, $allSymptoms)
    {
        $symptom = strtolower($symptom);
        foreach ($allSymptoms as $s) {
            if (strpos(strtolower($s['name']), $symptom) !== false) {
                return $s;
            }
        }
        return null;
    }
} 