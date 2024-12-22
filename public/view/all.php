<?php

use Lib\Account;

if (!Account::isAdmin()) {
    header("Location: /home");
    exit;
}

$result = Account::getAllUserInfo();
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=all_user_info.csv");
header("Pragma: no-cache");
header("Expires: 0");
if (preg_match('/Windows/i', $_SERVER['HTTP_USER_AGENT'])) $result = iconv('UTF-8', 'GBK', $result);
echo $result;