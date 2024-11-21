$(document).ready(function () {

    const toastLoginBtn = $('#toastLoginBtn');
    const toastLogin = $('#liveToast');

    const main = $('#main');
    const btnEntrar = $('#toastLoginBtn');
    const btnSobre = $('#btnSobre');
    const btnIndex = $('#btnIndex');
    const btnObjetivos = $('#btnObjetivos');
    const btnSuporte = $('#btnSuporte');

    const banner = $('#sectionBanner');

    let mouseDentroToast = false;

    var larguraPg = window.innerWidth;

    //função para verificar se parâmetro existe
    function parametroExiste(nomeParametro) {
        let parametros = new URLSearchParams(window.location.search);
        return parametros.has(nomeParametro);
    }

    if (parametroExiste('entrar')) {
        $('.nav-link').removeClass('active');
        btnEntrar.addClass('active');
        main.empty();
        main.load("public/pages/entrar.php");

    }
    if (parametroExiste('sobre')) {
        $('.nav-link').removeClass('active');
        btnSobre.addClass('active');
        main.empty();
        main.load("public/pages/sobre.php");

    }
    if (parametroExiste('objetivos')) {
        $('.nav-link').removeClass('active');
        btnObjetivos.addClass('active');
        main.empty();
        main.load("public/pages/objetivos.php");

    }
    if (parametroExiste('suporte')) {
        $('.nav-link').removeClass('active');
        btnSuporte.addClass('active');
        main.empty();
        main.load("public/pages/suporte.php");

    }
    if (parametroExiste('acessoNegado')) {
        alert("Acesso negado!")

    }

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

    function trocaPage(button, url) {
        var self = $(button);

        if (!self.hasClass('active')) {
            $('.nav-link').removeClass('active');
            self.addClass('active');
            banner.animate({ width: 'toggle' });
            main.animate({ width: 'toggle' }, function () {
                main.empty();
                main.load(url, function () {
                    main.animate({ width: 'toggle' });
                });
            });
        }
    }

    btnIndex.on('click', function () {
        trocaPage(this, "assets/templates/index/initial.php");
    });

    btnSobre.on('click', function () {
        trocaPage(this, "public/pages/sobre.php");
    });

    btnObjetivos.on('click', function () {
        trocaPage(this, "public/pages/objetivos.php");
    });

    btnSuporte.on('click', function () {
        trocaPage(this, "public/pages/suporte.php");
    });

    btnEntrar.on('click', function () {
        trocaPage(this, "public/pages/entrar.php");
    });



});
