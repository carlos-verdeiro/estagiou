$(document).ready(function () {

    const toastLoginBtn = $('#toastLoginBtn');
    const toastLogin = $('#liveToast');

    const main = $('#main');
    const btnEntrar = $('#toastLoginBtn');
    const btnSobre = $('#btnSobre');
    const btnIndex = $('#btnIndex');
    const btnObjetivos = $('#btnObjetivos');
    const btnSuporte = $('#btnSuporte');
    const btnCadastro = $('#btnCadastro');

    const banner = $('#sectionBanner');

    let mouseDentroToast = false;

    var larguraPg = window.innerWidth;

    if (toastLoginBtn.length && toastLogin.length && larguraPg > 1000) {
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

    // Caso clique fora, ele desaparece
    $(document).on("click", function (event) {
        // Reatribuindo as constantes toastLoginBtn e toastLogin aqui para evitar repetição de código
        const toastLoginBtn = $('#toastLoginBtn');
        const toastLogin = $('#liveToast');
        // Verifica se foi clicado fora do toast
        if (!toastLogin.is(event.target) && toastLogin.has(event.target).length === 0 && !toastLoginBtn.is(event.target) && toastLoginBtn.has(event.target).length === 0) {
            toastLogin.toast('hide');
        }
    });

    btnIndex.on("click", function () {
        if (!$(this).hasClass('active')) {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            banner.animate({ width: 'toggle' }); // Adicione uma transição de deslizamento lateral para o banner (se desejado)
            main.animate({ width: 'toggle' }, function () { // Adicione uma transição de deslizamento lateral suave para main
                main.empty(); // Limpe o conteúdo de main
                main.load("public/templates/index/initial.php", function () { // Carregue o conteúdo do arquivo PHP em main
                    main.animate({ width: 'toggle' }); // Adicione uma transição de deslizamento lateral para exibir o novo conteúdo de main
                });
            });
        }
    });

    btnSobre.on("click", function () {
        if (!$(this).hasClass('active')) {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            banner.animate({ width: 'toggle' });
            main.animate({ width: 'toggle' }, function () {
                main.empty();
                main.load("public/pages/sobre.php", function () {
                    main.animate({ width: 'toggle' });
                });
            });
        }
    });

    btnObjetivos.on("click", function () {
        if (!$(this).hasClass('active')) {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            banner.animate({ width: 'toggle' });
            main.animate({ width: 'toggle' }, function () {
                main.empty();
                main.load("public/pages/objetivos.php", function () {
                    main.animate({ width: 'toggle' });
                });
            });
        }
    });

    btnSuporte.on("click", function () {
        if (!$(this).hasClass('active')) {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            banner.animate({ width: 'toggle' });
            main.animate({ width: 'toggle' }, function () {
                main.empty();
                main.load("public/pages/suporte.php", function () {
                    main.animate({ width: 'toggle' });
                });
            });
        }
    });

    btnEntrar.on("click", function () {
        if (!$(this).hasClass('active')) {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            banner.animate({ width: 'toggle' });
            main.animate({ width: 'toggle' }, function () {
                main.empty();
                main.load("public/pages/entrar.php", function () {
                    main.animate({ width: 'toggle' });
                });
            });
        }
    });
});
