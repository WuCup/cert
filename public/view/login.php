<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>账号登录</title>
    <link rel="stylesheet" href="../assets/css/main.css?t=<?= time()?>">
    <script src="../assets/js/login.js?t=<?= time()?>"></script>
</head>
<body>

<div class="root-container">
    <h2>吾杯证书发放系统</h2>
    <form>
        <label>
            <input type="email" class="username" name="username" placeholder="邮箱" required>
        </label>
        <label>
            <input type="password" class="password" name="password" placeholder="密码" required>
        </label>
        <label class="captcha-container">
            <input class="captcha" type="text" name="captcha" placeholder="验证码" required>
            <img id="captcha-img" src="captcha" alt="验证码" onclick="refreshCaptcha()">
        </label>
        <button type="button" onclick="login()">登录</button>
    </form>
    <div class="forgot-footer">
        首次登录请先 <a href="reset">重置密码</a> or <a href="query">证书查询</a>
    </div>
</div>

</body>
</html>