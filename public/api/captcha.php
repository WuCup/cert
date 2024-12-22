<?php

use Lib\Email;
use Lib\Utils;

$postData = json_decode(json_encode($_POST));
$username = $postData->username;

$send = Email::generateAndSendCode($username);

if ($send) {
    Utils::custom('200 OK', [
        'Content-Type' => 'application/json'
    ], ['code' => 200, 'msg' => 'Send success'], false);
} else {
    Utils::error();
}