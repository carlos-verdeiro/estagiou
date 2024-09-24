$(document).ready(function () {
    //---NAV---
    // Botões de navegação
    const btnNavCurriculos = $('#btnNavEscolaCurriculo');
    const btnNavVagas = $('#btnNavEscolaVagas');
    const btnNavEmpresas = $('#btnNavEscolaEmpresas');
    const btnNavNotificacoes = $('#btnNavEscolaNotificacoes');
    const btnNavMensagens = $('#btnNavEscolaMensagens');
    const linksNav = $('.linkNavEscola');

    //---MAIN---
    // Seção principal onde as páginas serão carregadas
    const sectionPrincipal = $('#sectionPrincipal');


    // Função para trocar a página exibida
    function trocaPage(btnNav, page) {
        linksNav.removeClass('active');
        btnNav.addClass('active');
        sectionPrincipal.empty();
        sectionPrincipal.load(`pages/escola/${page}.php`);
    }

    const btnMenus = $('.btnMenus');

    btnMenus.on('click', function () {
        switch ($(this).val()) {
            case 'curriculos':
                trocaPage(btnNavCurriculos, 'curriculos');
                break;
            case 'vagas':
                trocaPage(btnNavVagas, 'vagas');
                break;
            case 'empresas':
                trocaPage(btnNavEmpresas, 'empresas');
                break;
            case 'notificacoes':
                trocaPage(btnNavNotificacoes, 'notificacoes');
                break;
            case 'mensagens':
                trocaPage(btnNavMensagens, 'mensagens');
                break;
        }
    });
});