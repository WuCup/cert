function requestCaptcha() {
    const xhr = new XMLHttpRequest();
    const captchaButton = document.querySelector(".captcha-button");
    let timeLeft = 60;

    xhr.open("POST", "/captcha", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    const username = document.querySelector(".username").value;
    xhr.send("username=" + username);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            alert(response["msg"]);
            captchaButton.disabled = true;
            captchaButton.innerText = `${timeLeft}秒后重试`;
            const countdownInterval = setInterval(() => {
                timeLeft -= 1;
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    captchaButton.disabled = false;
                    captchaButton.innerText = "获取验证码";
                } else {
                    captchaButton.innerText = `${timeLeft}秒后重试`;
                }
            }, 1000);
        } else if (xhr.readyState === 4) {
            const response = JSON.parse(xhr.responseText);
            alert(response["msg"]);
        }
    };
}

function resetPassword() {
    const username = document.querySelector(".username").value;
    const password = document.querySelector(".password").value;
    const password2 = document.querySelector(".password2").value;
    const captcha = document.querySelector(".captcha").value;
    if (password !== password2) {
        alert("两次密码不一致");
        return;
    } else if (captcha.length < 8) {
        alert("验证码格式错误");
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/reset", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("username=" + username + "&password=" + password + "&password2=" + password2 + "&captcha=" + captcha);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            location.href = "/home";
        } else if (xhr.readyState === 4) {
            refreshCaptcha();
            const response = JSON.parse(xhr.responseText);
            alert(response["msg"]);
        }
    };
}