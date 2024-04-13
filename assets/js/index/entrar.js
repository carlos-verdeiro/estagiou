$(document).ready(function () {
    const checkPass = $("#btn-check-outlined");
    const checkPassLabelImg = $("#checkPassLabelImg");
    const inputPass = $("#validationCustomPass")

    checkPass.on('click', function () {
        if (checkPassLabelImg.attr('src') === 'assets/img/eyeSlash.svg') {
            checkPassLabelImg.attr('src', 'assets/img/eyeFill.svg');
            inputPass.attr('type', 'text');
            inputPass.focus();
        } else {
            checkPassLabelImg.attr('src', 'assets/img/eyeSlash.svg');
            inputPass.attr('type', 'password');
            inputPass.focus();
        }
    });
});