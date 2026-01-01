<?php

use Illuminate\Support\Facades\Http;

/**
 * Translate text to a target language
 * 
 * @param string $text The text to translate
 * @param string $targetLanguage Target language code (default: 'tl' for Tagalog)
 * @return string|null Translated text or null if translation fails
 */
function translate($text, $targetLanguage = 'tl')
{
    if (empty($text)) {
        return $text;
    }

    // Normalize language code
    $targetLanguage = strtolower($targetLanguage);
    if ($targetLanguage === 'tagalog') {
        $targetLanguage = 'tl';
    } elseif ($targetLanguage === 'english') {
        $targetLanguage = 'en';
    }

    try {
        $response = Http::get('https://api.mymemory.translated.net/get', [
            'q' => $text,
            'langpair' => 'en|' . $targetLanguage,
        ])->json();

        $data = $response;

        if ($data['responseStatus'] == 200) {
            return $data['responseData']['translatedText'];
        }

        return null;
    } catch (\Exception $e) {
        \Log::error('Translation error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Translate multiple texts to a target language
 * 
 * @param array $texts Array of texts to translate
 * @param string $targetLanguage Target language code (default: 'tl' for Tagalog)
 * @return array Array of translated texts
 */
function translateArray($texts, $targetLanguage = 'tl')
{
    if (!is_array($texts)) {
        return [];
    }

    $targetLanguage = strtolower($targetLanguage);
    if ($targetLanguage === 'tagalog') {
        $targetLanguage = 'tl';
    } elseif ($targetLanguage === 'english') {
        $targetLanguage = 'en';
    }

    $results = [];

    foreach ($texts as $text) {
        $results[] = translate($text, $targetLanguage);
    }

    return $results;
}

/**
 * Get translated text or fallback to original if translation fails
 * 
 * @param string $text The text to translate
 * @param string $targetLanguage Target language code (default: 'tl' for Tagalog)
 * @return string Translated text or original text if translation fails
 */
function translateOrFallback($text, $targetLanguage = 'tl')
{
    $translated = translate($text, $targetLanguage);
    return $translated ?? $text;
}
