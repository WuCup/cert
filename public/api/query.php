<?php

use Lib\Account;
use Lib\Utils;

$postData = json_decode(json_encode($_POST));
$name = $postData->name;
$cert = $postData->cert;
$captcha = strtolower(trim($postData->captcha));

if (empty($name) || empty($cert) || empty($captcha)) Utils::param();
session_start();
if ($captcha !== $_SESSION['captcha']) {
    Utils::custom('400 Bad Request', [
        'Content-Type' => 'application/json'
    ], ['code' => 400, 'msg' => 'Invalid captcha'], true);
}

Account::query($name, $cert);