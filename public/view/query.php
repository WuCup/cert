<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>证书查询</title>
    <link rel="stylesheet" href="../assets/css/main.css?t=<?= time()?>">
    <link rel="stylesheet" href="../assets/css/info.css?t=<?= time()?>">
    <script src="../assets/js/query.js?t=<?= time()?>"></script>
</head>
<body>

<div class="root-container">
    <h2>查询</h2>
    <form class="form-group">
        <label>
            <input type="text" class="name" name="name" placeholder="姓名" maxlength="4" required>
        </label>
        <label>
            <input type="text" class="cert" name="cert" placeholder="证书编号" maxlength="14" required>
        </label>
        <label class="captcha-container">
            <input class="captcha" type="text" name="captcha" placeholder="验证码" maxlength="8" required>
            <img id="captcha-img" src="captcha" alt="验证码" onclick="refreshCaptcha()">
        </label>
        <button type="button" onclick="query()">查询</button>
    </form>
    <table class="table-group" hidden>
        <tbody>
        <tr>
            <th>获奖成员</th>
            <td class="name2"></td>
        </tr>
        <tr>
            <th>证书编号</th>
            <td class="cert2"></td>
        </tr>
        <tr>
            <th>获奖名次</th>
            <td class="type"></td>
        </tr>
        <tr>
            <th>获奖单位</th>
            <td class="affiliation"></td>
        </tr>
        <tr>
            <th>指导老师</th>
            <td class="teacher"></td>
        </tr>
        </tbody>
    </table>
    <div class="forgot-footer">
        <a href="/">返回首页</a>
    </div>
</div>

</body>
</html>