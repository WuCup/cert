<?php

use Lib\Account;
use Lib\Token;
use Lib\Utils;

$postData = json_decode(json_encode($_POST));
$username = $postData->username;
$password = $postData->password;
$captcha = strtolower(trim($postData->captcha));

if (empty($username) || empty($password) || empty($captcha)) Utils::param();
session_start();
if ($captcha !== $_SESSION['captcha']) {
    Utils::custom('400 Bad Request', [
        'Content-Type' => 'application/json'
    ], ['code' => 400, 'msg' => 'Invalid captcha'], true);
}

$login = Account::login($username, $password);
if (!$login)
{
    $header = [
        'Content-Type' => 'application/json'
    ];
    $data = [
        'code' => 400,
        'msg' => 'Invalid username or password'
    ];
    Utils::custom('400 Bad Request', $header, $data, true);
}
else
{
    $token = Token::generateToken($username);
    Utils::custom('200 OK', [
        'Content-Type' => 'application/json'
    ], ['code' => 200, 'msg' => 'Login success'], false);
}