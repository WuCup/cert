<?php

use Lib\Account;
use Lib\Crypt;
use Lib\Email;
use Lib\Utils;

$postData = json_decode(json_encode($_POST));
$username = $postData->username;
$password = $postData->password;
$password2 = $postData->password2;
$captcha = $postData->captcha;

if (
    empty($username) ||
    empty($password) ||
    empty($password2) ||
    empty($captcha)
) Utils::param();

if ($password !== $password2) {
    Utils::custom('400 Bad Request', [
        'Content-Type' => 'application/json'
    ], ['code' => 400, 'msg' => 'Password not match'], true);
};

if (Email::verifyCode($username, $captcha)) {
    if (Account::reset($username, Crypt::encrypt(md5($password)))) {
        Utils::custom('200 OK', [
            'Content-Type' => 'application/json'
        ], ['code' => 200, 'msg' => 'Reset success'], false);
    } else {
        Utils::custom('400 Bad Request', [
            'Content-Type' => 'application/json'
        ], ['code' => 400, 'msg' => 'Reset failed'], false);
    }
} else {
    Utils::custom('400 Bad Request', [
        'Content-Type' => 'application/json'
    ], ['code' => 400, 'msg' => 'Invalid captcha'], true);
}