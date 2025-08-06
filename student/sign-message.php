<?php
$privateKey = file_get_contents("private-key.pem"); // Match your filename
$pkeyid = openssl_get_privatekey($privateKey);

$data = file_get_contents("php://input");
openssl_sign($data, $signature, $pkeyid, OPENSSL_ALGO_SHA1);
openssl_free_key($pkeyid);

echo base64_encode($signature);
?>
