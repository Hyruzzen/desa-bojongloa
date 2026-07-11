<?php
$key = 'AQ.Ab8RN6IcXL-FMGvzEkwmV3Pa6hSJil_SQxLjwrJ2ZrdZLBFFIg';
$models = ['gemini-2.5-flash', 'gemini-3.5-flash', 'gemini-flash-latest'];
foreach ($models as $model) {
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $key;
    $payload = json_encode(['contents' => [['parts' => [['text' => 'Hello']]]]]);
    $context = stream_context_create(['http' => ['method' => 'POST', 'header' => 'Content-Type: application/json', 'content' => $payload, 'ignore_errors' => true], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
    $resp = @file_get_contents($url, false, $context);
    $code = isset($http_response_header[0]) ? (int)filter_var($http_response_header[0], FILTER_SANITIZE_NUMBER_INT) : 0;
    $data = json_decode($resp, true);
    $msg = $data['error']['message'] ?? 'OK';
    echo $model . ': ' . $code . ' - ' . substr($msg, 0, 80) . PHP_EOL;
}
