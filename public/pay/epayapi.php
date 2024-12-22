<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>正在为您跳转到支付页面，请稍候...</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0
        }

        p {
            position: absolute;
            left: 50%;
            top: 50%;
            height: 35px;
            margin: -35px 0 0 -160px;
            padding: 20px;
            font: bold 16px/30px "宋体", Arial;
            text-indent: 40px;
            border: 1px solid #c5d0dc
        }
    </style>
</head>
<body>
<?php

require_once '../init.php';

use Lib\Account;
use Lib\Utils;

if (!Account::isLogin()) {
    header('Location: /login');
}

require_once("lib/epay.config.php");
require_once("lib/EpayCore.class.php");
$notify_url = "https://domain/pay/notify_url.php";
$return_url = "https://domain/home";
$out_trade_no = date("YmdHis") . rand(1000, 9999);
$type = $_POST['payment_method'];
$name = $_POST['certificate_type'] . '-' . $_COOKIE['username'];
$money = Utils::getMoney();
$parameter = array(
    "type" => $type,
    "notify_url" => $notify_url,
    "return_url" => $return_url,
    "out_trade_no" => $out_trade_no,
    "name" => $name,
    "money" => $money
);

global $epay_config;
$epay = new EpayCore($epay_config);
$html_text = $epay->pagePay($parameter);
echo $html_text;
?>
<p>正在为您跳转到支付页面，请稍候...</p>
</body>
</html>