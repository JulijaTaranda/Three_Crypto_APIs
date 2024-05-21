<?php
// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// URL to fetch data from Service 1
$service1Url = 'http://localhost/three_crypto_APIs/service1/index.php';

// Function to perform GET request using file_get_contents
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

// Fetch data from Service 1
$data = fetchData($service1Url);
if ($data === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Unable to fetch data from Service 1']);
    exit();
}

// Output fetched data for debugging
echo json_encode(['success' => true, 'data' => $data]);