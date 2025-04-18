<?php

function load_documents(string $path): string {
    $texts = [];
    foreach (glob($path . '/*.txt') as $filename) {
        $texts[] = file_get_contents($filename);
    }
    return implode("\n\n---\n\n", $texts);
}

function send_to_gemini(string $input): string {
    $apiKey = getenv('GOOGLE_API_KEY');
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

    $postData = [
        "contents" => [[
            "parts" => [["text" => $input]]
        ]]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'CURL Error: ' . curl_error($ch);
    }

    curl_close($ch);

    $decoded = json_decode($response, true);
    return $decoded['candidates'][0]['content']['parts'][0]['text'] ?? 'Brak odpowiedzi.';
}
