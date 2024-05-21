<?php
// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// URL to fetch data from Service 1
$service1Url = 'http://localhost/three_crypto_APIs/service1/index.php';

// Function to perform GET request 
function fetchData($url) {
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return false;
    }
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return false;
    }
    return $data;
}

// Fetch data from Service 1 to Service 2
$data = fetchData($service1Url);
if ($data === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to fetch data from Service 1']);
    exit();
}

// Output fetched data for debugging
echo json_encode(['success' => true, 'data' => $data]);

// Section to send data to Service 3
$service3Url = 'http://localhost/three_crypto_APIs/service3/receive.php';

function sendData($url, $data) {
    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ],
    ];
    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    if ($response === FALSE) {
        return false;
    }
    return json_decode($response, true);
}

$response = sendData($service3Url, $data);
if ($response === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to send data to Service 3']);
    exit();
}

echo json_encode(['success' => true, 'response' => $response]);
?>