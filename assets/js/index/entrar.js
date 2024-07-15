$(document).ready(function () {
    const checkPass = $("#btn-check-outlined");
    const checkPassLabelImg = $("#checkPassLabelImg");
    const inputPass = $("#senha")

    checkPass.on('click', function () {
        if (checkPassLabelImg.attr('src') === 'assets/img/icons/eyeSlash.svg') {
            checkPassLabelImg.attr('src', 'assets/img/icons/eyeFill.svg');
            inputPass.attr('type', 'text');
            inputPass.focus();
        } else {
            checkPassLabelImg.attr('src', 'assets/img/icons/eyeSlash.svg');
            inputPass.attr('type', 'password');
            inputPass.focus();
        }
    });
});