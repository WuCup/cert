<?php
require_once '../init.php';
use Lib\Account;

if (!Account::isLogin()) {
    header('Location: /login');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申领资格</title>
    <link rel="stylesheet" href="../assets/css/main.css?t=<?= time()?>">
    <link rel="stylesheet" href="../assets/css/pay.css?t=<?= time()?>">
</head>
<body>

<div class="root-container">
    <h2>申领</h2>
    <form action="epayapi.php" method="POST">
        <div class="form-group">
            <h3>选择申领类型</h3>
            <div class="radio-label" onclick="document.getElementById('certificate1').checked = true;">
                <input type="radio" name="certificate_type" value="单纸质证书" id="certificate1" required>
                <div class="custom-radio checked"></div>
                单纸质证书 20元 (工本费+快递费)
            </div>
            <div class="radio-label" onclick="document.getElementById('certificate2').checked = true;">
                <input type="radio" name="certificate_type" value="单赛事勋章" id="certificate2" required>
                <div class="custom-radio"></div>
                单赛事勋章 20元 (工本费+快递费)
            </div>
            <div class="radio-label" onclick="document.getElementById('certificate3').checked = true;">
                <input type="radio" name="certificate_type" value="证书加勋章" id="certificate3" required>
                <div class="custom-radio"></div>
                证书加勋章 30元 (工本费+快递费)
            </div>
        </div>
        <div class="form-group">
            <h3>选择支付方式</h3>
            <div class="payment-methods">
                <div class="radio-label" onclick="document.getElementById('payment1').checked = true;">
                    <input type="radio" name="payment_method" value="alipay" id="payment1" required checked>
                    <div class="custom-radio checked"></div>
                    支付宝
                </div>
                <div class="radio-label" onclick="document.getElementById('payment2').checked = true;">
                    <input type="radio" name="payment_method" value="wxpay" id="payment2" required>
                    <div class="custom-radio"></div>
                    微信支付
                </div>
            </div>
        </div>
        <button type="submit">确定</button>
    </form>
</div>
<script src="../assets/js/pay.js?t=<?= time()?>"></script>
</body>
</html>