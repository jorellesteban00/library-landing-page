<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationController
{
    /**
     * Translate text to Tagalog using Google Translate API (unofficial)
     * This method provides more accurate translations with support for longer text
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:5000', // Increased from 1000 to 5000
            'target_language' => 'nullable|string|in:tl,tagalog,en,english,fil,filipino',
        ]);

        $text = $validated['text'];
        $targetLang = $this->normalizeLanguageCode($validated['target_language'] ?? 'tl');
        $sourceLang = $this->detectSourceLanguage($targetLang);

        try {
            // Try Google Translate (unofficial) first for better accuracy
            $translated = $this->translateWithGoogle($text, $sourceLang, $targetLang);

            if ($translated) {
                return response()->json([
                    'original' => $text,
                    'translated' => $translated,
                    'target_language' => $targetLang,
                    'source_language' => $sourceLang,
                    'status' => 'success'
                ]);
            }

            // Fallback to MyMemory if Google fails
            $translated = $this->translateWithMyMemory($text, $sourceLang, $targetLang);

            if ($translated) {
                return response()->json([
                    'original' => $text,
                    'translated' => $translated,
                    'target_language' => $targetLang,
                    'source_language' => $sourceLang,
                    'status' => 'success'
                ]);
            }

            return response()->json([
                'error' => 'Translation failed - no valid response from translation services',
                'status' => 'error'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Translation error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Service unavailable',
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Translate using Google Translate (unofficial free API)
     * More accurate for Tagalog/Filipino translations
     */
    private function translateWithGoogle(string $text, string $sourceLang, string $targetLang): ?string
    {
        try {
            // Use Google Translate's unofficial API endpoint
            $url = 'https://translate.googleapis.com/translate_a/single';

            $response = Http::timeout(10)->get($url, [
                'client' => 'gtx',
                'sl' => $sourceLang,
                'tl' => $targetLang,
                'dt' => 't',
                'q' => $text,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Google returns nested arrays, extract all translated sentences
                if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                    $translatedParts = [];
                    foreach ($data[0] as $part) {
                        if (is_array($part) && isset($part[0])) {
                            $translatedParts[] = $part[0];
                        }
                    }

                    $result = implode('', $translatedParts);

                    // Return if we got a valid translation (not just the same text)
                    if (!empty($result) && $result !== $text) {
                        return $result;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('Google Translate failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Translate using MyMemory API (fallback)
     * Supports longer phrases and sentences
     */
    private function translateWithMyMemory(string $text, string $sourceLang, string $targetLang): ?string
    {
        try {
            // For longer texts, split into sentences and translate each
            $sentences = $this->splitIntoSentences($text);
            $translatedSentences = [];

            foreach ($sentences as $sentence) {
                if (empty(trim($sentence))) {
                    $translatedSentences[] = $sentence;
                    continue;
                }

                $response = Http::timeout(10)->get('https://api.mymemory.translated.net/get', [
                    'q' => $sentence,
                    'langpair' => $sourceLang . '|' . $targetLang,
                    'de' => 'library@example.com', // Optional email for higher limits
                ]);

                $data = $response->json();

                if (isset($data['responseStatus']) && $data['responseStatus'] == 200) {
                    $translated = $data['responseData']['translatedText'];

                    // Check quality score - if too low, try alternative matches
                    $quality = floatval($data['responseData']['match'] ?? 0);

                    if ($quality < 0.5 && isset($data['matches']) && is_array($data['matches'])) {
                        // Look for better quality match
                        foreach ($data['matches'] as $match) {
                            if (isset($match['match']) && floatval($match['match']) > $quality) {
                                $translated = $match['translation'];
                                break;
                            }
                        }
                    }

                    $translatedSentences[] = $translated;
                } else {
                    // Keep original if translation fails
                    $translatedSentences[] = $sentence;
                }
            }

            $result = implode(' ', array_filter($translatedSentences));
            return !empty($result) ? $result : null;

        } catch (\Exception $e) {
            Log::warning('MyMemory translation failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Split text into sentences for better translation of long content
     */
    private function splitIntoSentences(string $text): array
    {
        // Split on sentence-ending punctuation while preserving the punctuation
        $sentences = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        return $sentences ?: [$text];
    }

    /**
     * Normalize language code to standard format
     */
    private function normalizeLanguageCode(string $lang): string
    {
        $lang = strtolower(trim($lang));

        $mapping = [
            'tagalog' => 'tl',
            'filipino' => 'tl',
            'fil' => 'tl',
            'english' => 'en',
        ];

        return $mapping[$lang] ?? $lang;
    }

    /**
     * Detect source language based on target
     * If translating to Tagalog, assume source is English and vice versa
     */
    private function detectSourceLanguage(string $targetLang): string
    {
        return $targetLang === 'tl' ? 'en' : 'tl';
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
            'texts' => 'required|array|max:20', // Increased from 10 to 20
            'texts.*' => 'string|max:2000', // Increased from 1000 to 2000
            'target_language' => 'nullable|string|in:tl,tagalog,en,english,fil,filipino',
        ]);

        $texts = $validated['texts'];
        $targetLang = $this->normalizeLanguageCode($validated['target_language'] ?? 'tl');
        $sourceLang = $this->detectSourceLanguage($targetLang);

        $results = [];

        foreach ($texts as $text) {
            try {
                // Try Google first, then fallback to MyMemory
                $translated = $this->translateWithGoogle($text, $sourceLang, $targetLang)
                    ?? $this->translateWithMyMemory($text, $sourceLang, $targetLang);

                if ($translated) {
                    $results[] = [
                        'original' => $text,
                        'translated' => $translated,
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
            'source_language' => $sourceLang,
            'total' => count($texts),
            'successful' => collect($results)->where('status', 'success')->count(),
        ]);
    }
}
