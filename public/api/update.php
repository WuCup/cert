<?php

use Lib\Account;
use Lib\Crypt;
use Lib\Utils;

if (new DateTime() >= new DateTime('2024-12-21 00:00:00')) {
    Utils::custom('401 Unauthorized', [
        'Content-Type' => 'application/json'
    ], ['code' => 401, 'msg' => 'Submission time has passed.'], true);
}

$postData = json_decode(json_encode($_POST));
$token = $_COOKIE['token'];
$email = Crypt::decrypt(substr($token, 2));

$name = Utils::escapeHtml($postData->name);
$qq = Utils::escapeHtml($postData->qq);
$affiliation = Utils::escapeHtml($postData->affiliation) ?? null;
$teacher = Utils::escapeHtml($postData->teacher) ?? null;
$phone = Utils::escapeHtml($postData->phone) ?? null;
$address = Utils::escapeHtml($postData->address) ?? null;

$result = Account::setUserInfo($email, $name, $qq, $affiliation, $teacher, $phone, $address);
if ($result) {
    Utils::custom('200 OK', [
        'Content-Type' => 'application/json'
    ], ['code' => 200, 'msg' => 'Update user info success'], false);
} else {
    Utils::error();
}