function refreshCaptcha() {
    document.getElementById('captcha-img').src = 'captcha?' + Math.random(); // 添加随机参数以刷新验证码
}

function login() {
    const username = document.querySelector(".username").value;
    const password = document.querySelector(".password").value;
    const captcha = document.querySelector(".captcha").value;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/login", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("username=" + username + "&password=" + password + "&captcha=" + captcha);
    if (username === "" || password === "" || captcha === "") {
        alert("请填写完整信息");
        return;
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (new Date(2024, 11, 21) > new Date()) location.href = "/home";
            else location.href = "/info";
        } else if (xhr.readyState === 4) {
            refreshCaptcha();
            const response = JSON.parse(xhr.responseText);
            alert(response["msg"]);
        }
    }
}