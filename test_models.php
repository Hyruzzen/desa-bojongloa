<?php
$key = 'AQ.Ab8RN6IcXL-FMGvzEkwmV3Pa6hSJil_SQxLjwrJ2ZrdZLBFFIg';
$url = "https://generativelanguage.googleapis.com/v1beta/models?key={$key}";

$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'ignore_errors' => true,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

$response = @file_get_contents($url, false, $context);
$data = json_decode($response, true);
if (isset($data['models'])) {
    foreach ($data['models'] as $m) {
        if (strpos($m['name'], 'gemini') !== false) {
            echo $m['name'] . "\n";
        }
    }
} else {
    echo "Error: \n" . $response;
}
