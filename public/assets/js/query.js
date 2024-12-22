function refreshCaptcha() {
    document.getElementById('captcha-img').src = 'captcha?' + Math.random(); // 添加随机参数以刷新验证码
}

function query() {
    const table = document.querySelector(".table-group");
    table.hidden = true;
    const name = document.querySelector(".name").value;
    const cert = document.querySelector(".cert").value;
    const captcha = document.querySelector(".captcha").value;
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/query", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("name=" + name + "&cert=" + cert + "&captcha=" + captcha);
    if (name === "" || cert === "" || captcha === "") {
        alert("请填写完整信息");
        return;
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            const name = document.querySelector(".name2");
            const cert = document.querySelector(".cert2");
            const type = document.querySelector(".type");
            const affiliation = document.querySelector(".affiliation");
            const teacher = document.querySelector(".teacher");
            table.hidden = false;
            name.innerHTML = response["name"];
            cert.innerHTML = response["cert"];
            type.innerHTML = response["type"];
            affiliation.innerHTML = response["affiliation"];
            teacher.innerHTML = response["teacher"];
        } else if (xhr.readyState === 4) {
            refreshCaptcha();
            const response = JSON.parse(xhr.responseText);
            alert(response["msg"]);
        }
    }
}