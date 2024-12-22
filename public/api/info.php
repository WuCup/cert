<?php

use Lib\Account;
use Lib\Token;
use Lib\Utils;

$postData = json_decode(json_encode($_POST));
$username = $postData->username;
$token = $postData->token;

if (empty($username) || empty($token)) Utils::param();
if (!Token::verifyToken($token, $username)) {
    Utils::custom('401 Unauthorized', [
        'Content-Type' => 'application/json'
    ], ['code' => 401, 'msg' => 'Invalid token'], true);
}

$userInfo = Account::getUserInfo($username);
Utils::custom('200 OK', [
    'Content-Type' => 'application/json'
], ['code' => 200, 'msg' => 'Get user info success', 'data' => $userInfo], false);