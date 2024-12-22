document.querySelectorAll('.radio-label').forEach((label) => {
    label.addEventListener('click', () => {
        const input = label.querySelector('input[type="radio"]');
        input.checked = true;
        document.querySelectorAll(`input[name="${input.name}"]`).forEach((radio) => {
            const customRadio = radio.nextElementSibling;
            customRadio.classList.remove('checked');
        });
        const customRadio = input.nextElementSibling;
        customRadio.classList.add('checked');
    });
});

window.onload = function () {
    document.getElementById('certificate1').checked = true;
    document.getElementById('payment1').checked = true;
}