<?php

use Lib\Account;

$username = $_COOKIE['username'] ?? "";
$userInfo = Account::getUserInfo($username);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>账号信息</title>
    <link rel="stylesheet" href="../assets/css/main.css?t=<?= time()?>">
    <script src="../assets/js/home.js?t=<?= time()?>"></script>
</head>
<body>

<div class="root-container root-home">
    <h2>信息</h2>
    <form>
        <label>
            <input type="text" minlength="2" class="name" name="name" placeholder="真实姓名" value="<?= $userInfo['name'] ?? '' ?>" required>
        </label>
        <label>
            <input type="number" minlength="6" maxlength="10" class="qq" name="qq" placeholder="QQ账号" value="<?= $userInfo['qq'] ?? ''  ?>" required>
        </label>
        <label>
            <input type="text" minlength="2" class="affiliation" name="affiliation" placeholder="单位名称（非必填）" value="<?= $userInfo['affiliation'] ?? '' ?>">
        </label>
        <label>
            <input type="text" minlength="2" class="teacher" name="teacher" placeholder="指导老师（非必填）" value="<?= $userInfo['teacher'] ?? '' ?>">
        </label>
        <label>
            <input type="number" minlength="11" maxlength="11" class="phone" name="phone" placeholder="手机号码（非必填）" value="<?= $userInfo['phone'] ?? '' ?>">
        </label>
        <label>
            <input type="text" minlength="2" class="address" name="address" placeholder="收货地址（非必填）" value="<?= $userInfo['address'] ?? '' ?>">
        </label>
        <button type="button" onclick="update()">提交</button>
    </form>
    <div class="forgot-footer">
        <?= (!Account::isAdmin()) ? '<a href="logout">退出登录</a> or <a href="query">证书查询</a> or <a href="info">获奖信息</a>' : '<a href="query">证书查询</a> or <a href="all">全员数据</a> or <a href="info">获奖信息</a>'; ?>
    </div>
</div>

<div id="tip_modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>公告</h3>
        1. 获奖选手应填写<b>真实姓名</b>，高校/单位全称，<b>一名</b>指导教师姓名(可选填)。无高校和单位的社会身份获奖选手应填写真实姓名。<br><br>
        2. 一等奖获奖选手有免费纸质证书和礼品，其他名次的获奖选手如果需要纸质证书和礼品可自行申领并承担相关费用，并由主办方统一发放。<br><br>
        3. 获奖信息收集时间：2024年12月13日—2024年12月20日，电子证书发放时间：2024年12月31日前，纸质证书与礼品发放时间：2025年3月30日前。<br><br>
        4. 相关信息填写错误、不完整或超过信息填报的规定时间视为放弃！请各位获奖选手在规定时间内仔细检查自己的相关信息是否正确，<b>如有错误请在规定的信息收集时间内进行更改。</b><br><br>
        5.<b>请各位参赛选手在信息收集结束后（2024.12.20以后）自行前往获奖信息下载证书。</b>
    </div>
</div>
</body>
</html>