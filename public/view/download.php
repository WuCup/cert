<?php

use Lib\Account;
use Lib\Token;
use Lib\Utils;

$username = $_COOKIE['username'] ?? "";
$token = $_COOKIE['token'] ?? "";

if (!Token::verifyToken($token, $username)) {
    Utils::custom('401 Unauthorized', [
        'Content-Type' => 'application/json'
    ], ['code' => 401, 'msg' => 'Invalid token'], true);
}

$cert = CERT_PATH . '/' . Account::getUserInfo($_COOKIE['username'])['cert'] . '.pdf';
if (file_exists($cert)) {
    header('Content-Type: application/pdf');
    header('Content-Length: ' . filesize($cert));
    header('Content-Disposition: attachment; filename="' . basename($cert) . '"');
    $result = readfile($cert);
    if ($result === false) {
        Utils::custom('500 Internal Server Error', [
            'Content-Type' => 'application/json'
        ], ['code' => 500, 'msg' => 'Read file error'], true);
    } else {
        echo $result;
    }
} else {
    Utils::custom('404 Not Found', [
        'Content-Type' => 'application/json'
    ], ['code' => 404, 'msg' => 'Certificate not found'], true);
}