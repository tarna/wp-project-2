<?php
header('Content-Type: application/json');
$url = "http://localhost:3000/api.php";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPGET, true);
$response = curl_exec($ch);
curl_close($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => "cURL Error: " . curl_error($ch)]);
} else {
    $obj = json_decode($response, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        if (isset($data['status']) && $data['status'] === 'success' && isset($data['data'])) {
            echo $obj['status'];
        } else {
            echo json_encode(['error'=> 'Invalid data']);
        }
    } else {
        echo json_encode(['error'=> 'Invalid JSON']);
    }
}