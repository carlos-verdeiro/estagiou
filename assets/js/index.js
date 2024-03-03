$(document).ready(function () {
    const toastLoginBtn = $('#toastLoginBtn');
    const toastLogin = $('#liveToast');

    const main = $('#main');
    const btnEntrar = $('#toastLoginBtn')
    const banner = $('')



    let mouseDentroToast = false;

    if (toastLoginBtn.length && toastLogin.length) {
        toastLoginBtn.on("mouseenter", function () {
            toastLogin.toast('show');
            mouseDentroToast = true;
        }).on("mouseleave", function () {
            setTimeout(function () {
                if (!mouseDentroToast) {
                    toastLogin.toast('hide');
                }
            }, 500);
            mouseDentroToast = false;
        });

        toastLogin.on("mouseenter", function () {
            mouseDentroToast = true;
        }).on("mouseleave", function () {
            if (!mouseDentroToast) {
                toastLogin.toast('hide');
            }
            mouseDentroToast = false;
        });
    }

    //caso clique fora ele desaparece
    $(document).on("click", function (event) {
        const toastLoginBtn = $('#toastLoginBtn');
        const toastLogin = $('#liveToast');
        //verifica se foi clicado fora do toast
        if (!toastLogin.is(event.target) && toastLogin.has(event.target).length === 0 && !toastLoginBtn.is(event.target) && toastLoginBtn.has(event.target).length === 0) {
            toastLogin.toast('hide');
        }
    });



    btnEntrar.on("click", function () {
        banner.animate({ width: 'toggle' }); // Adicione uma transição de deslizamento lateral para o banner (se desejado)
        main.animate({ width: 'toggle' }, function () { // Adicione uma transição de deslizamento lateral suave para main
            main.empty(); // Limpe o conteúdo de main
            main.load("public/entrar/entrar.php", function () { // Carregue o conteúdo do arquivo PHP em main
                main.animate({ width: 'toggle' }); // Adicione uma transição de deslizamento lateral para exibir o novo conteúdo de main
            });
        });
        banner.remove();
    });



});