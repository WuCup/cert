<?php

require_once '../init.php';

use Lib\Account;

require_once("lib/epay.config.php");
require_once("lib/EpayCore.class.php");
global $epay_config;
$epay = new EpayCore($epay_config);
$verify_result = $epay->verify($_GET);

if ($verify_result) {
    $out_trade_no = $_GET['out_trade_no'];
    $trade_no = $_GET['trade_no'];
    $trade_status = $_GET['trade_status'];
    $type = $_GET['type'];
    $money = $_GET['money'];

    if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
        $names = $epay->queryOrder($trade_no)['name'];
        $name = explode('-', $names)[0];
        $email = explode('-', $names)[1];
        switch ($name) {
            case '单纸质证书':
                Account::setUserCert($email, 1);
                break;
            case '单赛事勋章':
                Account::setUserMedal($email, 1);
                break;
            case '证书加勋章':
                Account::setUserCert($email, 1);
                Account::setUserMedal($email, 1);
                break;
            default:
                break;
        }
    }

    echo "success";
} else {
    echo "fail";
}