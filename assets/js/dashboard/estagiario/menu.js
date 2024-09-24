$(document).ready(function () {
    //---NAV---
    // Botões de navegação
    const btnNavCurriculo = $('#btnNavEstagiarioCurriculo');
    const btnNavVagas = $('#btnNavEstagiarioVagas');
    const btnNavNotificacoes = $('#btnNavEstagiarioNotificacoes');
    const btnNavMensagens = $('#btnNavEstagiarioMensagens');
    const linksNav = $('.linkNavEstagiario');

    //---MAIN---
    // Seção principal onde as páginas serão carregadas
    const sectionPrincipal = $('#sectionPrincipal');


    // Função para trocar a página exibida
    function trocaPage(btnNav, page) {
        linksNav.removeClass('active');
        btnNav.addClass('active');
        sectionPrincipal.empty();
        sectionPrincipal.load(`pages/estagiario/${page}.php`);
    }

    const btnMenus = $('.btnMenus');

    btnMenus.on('click', function() {
        switch ($(this).val()) {
            case 'curriculo':
                trocaPage(btnNavCurriculo, 'curriculo');
                break;
            case 'vagas':
                trocaPage(btnNavVagas, 'vagas');
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