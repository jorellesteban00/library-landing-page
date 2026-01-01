<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslationController
{
    /**
     * Translate text to Tagalog using Google Translate API
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:1000',
            'target_language' => 'nullable|string|in:tl,tagalog,en,english',
        ]);

        $text = $validated['text'];
        $targetLang = $validated['target_language'] ?? 'tl'; // Default to Tagalog
        
        // Normalize language code
        if ($targetLang === 'tagalog') {
            $targetLang = 'tl';
        } elseif ($targetLang === 'english') {
            $targetLang = 'en';
        }

        try {
            // Using Google Translate API (free alternative - MyMemory)
            $response = Http::get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => 'en|' . $targetLang,
            ])->throw();

            $data = $response->json();

            if ($data['responseStatus'] == 200) {
                return response()->json([
                    'original' => $text,
                    'translated' => $data['responseData']['translatedText'],
                    'target_language' => $targetLang,
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'error' => 'Translation failed',
                    'status' => 'error'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Service unavailable',
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Batch translate multiple texts to Tagalog
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchTranslate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'texts' => 'required|array|max:10',
            'texts.*' => 'string|max:1000',
            'target_language' => 'nullable|string|in:tl,tagalog,en,english',
        ]);

        $texts = $validated['texts'];
        $targetLang = $validated['target_language'] ?? 'tl';
        
        if ($targetLang === 'tagalog') {
            $targetLang = 'tl';
        } elseif ($targetLang === 'english') {
            $targetLang = 'en';
        }

        $results = [];

        foreach ($texts as $text) {
            try {
                $response = Http::get('https://api.mymemory.translated.net/get', [
                    'q' => $text,
                    'langpair' => 'en|' . $targetLang,
                ])->throw();

                $data = $response->json();

                if ($data['responseStatus'] == 200) {
                    $results[] = [
                        'original' => $text,
                        'translated' => $data['responseData']['translatedText'],
                        'status' => 'success'
                    ];
                } else {
                    $results[] = [
                        'original' => $text,
                        'translated' => null,
                        'status' => 'failed'
                    ];
                }
            } catch (\Exception $e) {
                $results[] = [
                    'original' => $text,
                    'translated' => null,
                    'status' => 'error',
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'results' => $results,
            'target_language' => $targetLang,
            'total' => count($texts),
            'successful' => collect($results)->where('status', 'success')->count(),
        ]);
    }
}
