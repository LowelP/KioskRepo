<?php
// Enable errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get posted JSON
$data = json_decode(file_get_contents("php://input"), true);
$toSign = $data['data'] ?? null;

if (!$toSign) {
    http_response_code(400);
    exit("Missing data");
}

// Load private key
$keyPath ="cert/qz-trays-private-key.pem";
if (!file_exists($keyPath)) {
    http_response_code(500);
    exit("Private key file not found.");
}

$privateKey = openssl_pkey_get_private(file_get_contents($keyPath));
if (!$privateKey) {
    http_response_code(500);
    exit("Unable to load private key.");
}

// Sign the data
openssl_sign($toSign, $signature, $privateKey, OPENSSL_ALGO_SHA512);

// Output signature
echo base64_encode($signature);
?>
