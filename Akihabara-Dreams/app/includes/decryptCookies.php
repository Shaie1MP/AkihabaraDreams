<?php

function decrypt($encryptedData) {
    $key = hash('sha256', 'macarrones', binary: true);
    $decodedData = base64_decode(string: $encryptedData);
    $iv = substr($decodedData, 0, 16);
    $ciphertext = substr($decodedData, 16);
    $decryptedData = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    
    return $decryptedData;
}



