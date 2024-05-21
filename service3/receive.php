<?php
//CONNECTION to Database
$conn = mysqli_connect("localhost","root","password", "cryptodb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}else{
    // Get data from POST request
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON data']);
        exit();
    }

    // Insert data to db
    foreach ($data as $crypto => $details) {
        $name = mysqli_real_escape_string($conn, $crypto);
        $price = mysqli_real_escape_string($conn, $details['usd']);

        $sql = "INSERT INTO crypto_prices (name, price) VALUES ('$name', '$price')";
        if (!mysqli_query($conn, $sql)) {
            http_response_code(500);
            echo json_encode(['error' => 'Database insert failed: ' . mysqli_error($conn)]);
            exit();
        }
    }
    echo json_encode(['success' => true]);
}
$conn->close();
?>