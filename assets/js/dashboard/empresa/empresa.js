$(document).ready(function () {
    //---NAV---
    // Botões de navegação
    const btnNavMenu = $('#btnNavEmpresaMenu');
    const btnNavBancoTalentos = $('#btnNavEmpresaBancoTalentos');
    const btnNavVagas = $('#btnNavEmpresaVagas');
    const btnNavSeusEstagiarios = $('#btnNavEmpresaSeusEstagiarios');
    const btnNavNotificacoes = $('#btnNavEmpresaNotificacoes');
    const btnNavMensagens = $('#btnNavEmpresaMensagens');
    const linksNav = $('.linkNavEmpresa');

    //---MAIN---
    // Seção principal onde as páginas serão carregadas
    const sectionPrincipal = $('#sectionPrincipal');


    // Função para verificar os parâmetros da URL
    function parametroExistente() {
        const parametros = new URLSearchParams(window.location.search);
        if (parametros.has('talentos')) return 'talentos';
        if (parametros.has('vagas')) return 'vagas';
        if (parametros.has('estagiarios')) return 'estagiarios';
        if (parametros.has('notificacoes')) return 'notificacoes';
        if (parametros.has('mensagens')) return 'mensagens';
        return 'nenhum';
    }


    // Função para trocar a página exibida
    function trocaPage(btnNav, page) {
        linksNav.removeClass('active');
        btnNav.addClass('active');
        sectionPrincipal.empty();
        sectionPrincipal.load(`pages/empresa/${page}.php`);
    }


    // Função para adicionar evento de clique aos botões de navegação
    function adicionarEventoClique(btnNav, page) {
        btnNav.on('click', () => {
            if (!btnNav.hasClass('active')) {
                trocaPage(btnNav, page);
            }
        });
    }


    // Verifica o parâmetro existente na URL e carrega a página correspondente
    switch (parametroExistente()) {
        case 'curriculo':
            trocaPage(btnNavBancoTalentos, 'talentos');
            break;
        case 'vagas':
            trocaPage(btnNavVagas, 'vagas');
            break;
        case 'estagiarios':
            trocaPage(btnNavSeusEstagiarios, 'estagiarios');
            break;
        case 'notificacoes':
            trocaPage(btnNavNotificacoes, 'notificacoes');
            break;
        case 'mensagens':
            trocaPage(btnNavMensagens, 'mensagens');
            break;
        default:
            trocaPage(btnNavMenu, 'menu');
            break;
    }


    // Adiciona eventos de clique a todos os botões de navegação
    adicionarEventoClique(btnNavMenu, 'menu');
    adicionarEventoClique(btnNavBancoTalentos, 'talentos');
    adicionarEventoClique(btnNavVagas, 'vagas');
    adicionarEventoClique(btnNavSeusEstagiarios, 'estagiarios');
    adicionarEventoClique(btnNavNotificacoes, 'notificacoes');
    adicionarEventoClique(btnNavMensagens, 'mensagens');
});