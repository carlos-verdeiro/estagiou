$(document).ready(function () {
    const toastLoginBtn = $('#toastLoginBtn');
    const toastLogin = $('#liveToast');

    let mouseDentroToast = false;



    toastLogin.on("mouseenter", function () {
        mouseDentroToast = true;
    }).on("mouseleave", function () {
        setTimeout(function () {
            if (!mouseDentroToast) {
                toastLogin.toast('hide');
            }
        }, 3000)
        mouseDentroToast = false;
    })

    if (toastLoginBtn.length && toastLogin.length) {

        toastLoginBtn.on("mouseenter", function () {
            toastLogin.toast('show');
            mouseDentroToast = true;

        }).on("mouseleave", function () {
            setTimeout(function () {
                if (!mouseDentroToast) {
                    toastLogin.toast('hide');
                }
            }, 3000)
            mouseDentroToast = false;
            
        });
    }
});