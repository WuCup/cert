<?php

use Lib\Account;

$user = Account::getUserInfo($_COOKIE['username']);

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>获奖信息</title>
    <link rel="stylesheet" href="../assets/css/main.css?t=<?= time()?>">
    <link rel="stylesheet" href="../assets/css/info.css?t=<?= time()?>">
</head>
<body>

<div class="root-container root-info">
    <h2>概览</h2>
    <table class="table">
        <tbody>
        <tr>
            <th>证书编号</th>
            <td><?= $user['cert'] ?></td>
        </tr>
        <tr>
            <th>证书类型</th>
            <td><?= $user['cert_type'] ?></td>
        </tr>
        <tr>
            <th>纸质证书申领资格</th>
            <td>
                <?php
                if ($user['cert_type'] === '一等奖' || $user['cert_type'] === '组委会') {
                    echo 'True';
                } else {
                    echo $user['cert_qualify'] ? 'True' : 'False  <a href="https://domain/pay">点击申领</a>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>赛事勋章申领资格</th>
            <td>
                <?php
                if ($user['cert_type'] === '一等奖' || $user['cert_type'] === '组委会') {
                    echo 'True';
                } else {
                    echo $user['medal'] ? 'True' : 'False  <a href="https://domain/pay">点击申领</a>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>姓名</th>
            <td><?= $user['name'] ?? '未填写' ?></td>
        </tr>
        <tr>
            <th>QQ</th>
            <td><?= $user['qq'] ?? '未填写' ?></td>
        </tr>
        <tr>
            <th>单位名称</th>
            <td><?= $user['affiliation'] ?? '' ?></td>
        </tr>
        <tr>
            <th>指导老师</th>
            <td><?= $user['teacher'] ?? '' ?></td>
        </tr>
        <tr>
            <th>手机号码</th>
            <td><?= $user['phone'] ?? '' ?></td>
        </tr>
        <tr>
            <th>收货地址</th>
            <td><?= $user['address'] ?? '' ?></td>
        </tr>
        <tr>
            <th>物流信息</th>
            <td><?= $user['logistics'] ?? '' ?></td>
        </tr>
        </tbody>
    </table>
    <div class="forgot-footer">
        <a href="download">下载证书</a> or <a href="home">账号信息</a> or <a href="query">证书查询</a>
    </div>
</div>

</body>
</html>