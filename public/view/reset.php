<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>重置密码</title>
    <link rel="stylesheet" href="../assets/css/main.css?t=<?= time()?>">
    <script src="../assets/js/reset.js?t=<?= time()?>"></script>
</head>
<body>

<div class="root-container">
    <h2>重置</h2>
    <form>
        <label>
            <input class="username" type="email" name="username" placeholder="邮箱" required>
        </label>
        <label>
            <input class="password" type="password" name="password" placeholder="密码" required>
        </label>
        <label>
            <input class="password2" type="password" name="password2" placeholder="再次输入密码" required>
        </label>
        <label class="captcha-container">
            <input class="captcha" type="text" name="captcha" placeholder="验证码（区分大小写）" required>
            <button class="captcha-button" type="button" onclick="requestCaptcha()">获取验证码</button>
        </label>
        <button type="button" onclick="resetPassword()">重置</button>
    </form>
    <div class="forgot-footer">
        <a href="login">登录账号</a>
    </div>
</div>

</body>
</html>