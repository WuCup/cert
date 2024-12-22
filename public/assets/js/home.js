function update() {
    const name = document.querySelector(".name").value;
    const qq = document.querySelector(".qq").value;
    const affiliation = document.querySelector(".affiliation").value;
    const teacher = document.querySelector(".teacher").value;
    const phone = document.querySelector(".phone").value;
    const address = document.querySelector(".address").value;

    if (name.length < 2) {
        alert("姓名至少2个汉字");
        return;
    } else if (name.match(/[^\u4e00-\u9fa5]/)) {
        alert("姓名只允许中文");
        return;
    }
    if (affiliation !== "") {
        if (affiliation.length < 2) {
            alert("单位名称至少2个汉字");
            return;
        } else if (affiliation.match(/[^\u4e00-\u9fa5()（）]/)) {
            alert("单位名称只允许中文和括号");
            return;
        }
    }
    if (address !== "") {
        if (address.length < 2) {
            alert("收货地址至少2个字");
            return;
        }
    }
    if (qq !== "") {
        if (qq.length < 6) {
            alert("QQ号至少6位");
            return;
        } else if (phone.match(/\D/)) {
            alert("QQ号只允许数字");
            return;
        }
    }
    if (phone !== "") {
        if (phone.length !== 11) {
            alert("手机号必须为11位");
            return;
        } else if (phone.match(/\D/)) {
            alert("手机号只允许数字");
            return;
        }
    }
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/update", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    if (name === "" || qq === "") {
        alert("请填写姓名和QQ");
        return;
    }
    xhr.send("name=" + name + "&qq=" + qq + "&affiliation=" + affiliation + "&teacher=" + teacher + "&phone=" + phone + "&address=" + address);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const response = JSON.parse(xhr.responseText);
            alert(response["msg"]);
        }
    };
}

window.onload = function () {
    const modal = document.getElementById('tip_modal');
    const span = document.querySelector('.close');

    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
}