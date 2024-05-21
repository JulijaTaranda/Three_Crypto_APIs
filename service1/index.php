<?php
header('Content-Type: application/json');

$url = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum&vs_currencies=usd';
$response = file_get_contents($url);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to fetch data from CoinGecko API']);
    exit();
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(['error' => 'Error decoding JSON data']);
    exit();
}

echo json_encode($data);
?>