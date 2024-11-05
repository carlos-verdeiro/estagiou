$(document).ready(function () {
    //---NAV---
    // Botões de navegação
    const btnNavCandidatos = $('#btnNavEmpresaCandidatos');
    const btnNavVagas = $('#btnNavEmpresaVagas');
    const btnNavEstagiarios = $('#btnNavEmpresaSeusEstagiarios');
    const btnNavNotificacoes = $('#btnNavEmpresaNotificacoes');
    const btnNavMensagens = $('#btnNavEmpresaMensagens');
    const linksNav = $('.linkNavEmpresa');

    //---MAIN---
    // Seção principal onde as páginas serão carregadas
    const sectionPrincipal = $('#sectionPrincipal');


    // Função para trocar a página exibida
    function trocaPage(btnNav, page) {
        linksNav.removeClass('active');
        btnNav.addClass('active');
        sectionPrincipal.empty();
        sectionPrincipal.load(`pages/empresa/${page}.php`);
    }



    const btnMenus = $('.btnMenus');

    btnMenus.on('click', function () {
        switch ($(this).val()) {
            case 'candidatos':
                trocaPage(btnNavCandidatos, 'candidatos');
                break;
            case 'vagas':
                trocaPage(btnNavVagas, 'vagas');
                break;
            case 'estagiarios':
                trocaPage(btnNavEstagiarios, 'estagiarios');
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