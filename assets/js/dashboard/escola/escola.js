$(document).ready(function () {
    //---NAV---
    // Botões de navegação
    const btnNavMenu = $('#btnNavEscolaMenu');
    const btnNavCurriculos = $('#btnNavEscolaCurriculo');
    const btnNavVagas = $('#btnNavEscolaVagas');
    const btnNavEmpresas = $('#btnNavEscolaEmpresas');
    const btnNavNotificacoes = $('#btnNavEscolaNotificacoes');
    const btnNavMensagens = $('#btnNavEscolaMensagens');
    const linksNav = $('.linkNavEscola');

    const btnPerfil = $('#btnPerfil');

    //---MAIN---
    // Seção principal onde as páginas serão carregadas
    const sectionPrincipal = $('#sectionPrincipal');


    // Função para verificar os parâmetros da URL
    function parametroExistente() {
        const parametros = new URLSearchParams(window.location.search);
        if (parametros.has('curriculos')) return 'curriculos';
        if (parametros.has('vagas')) return 'vagas';
        if (parametros.has('empresas')) return 'empresas';
        if (parametros.has('notificacoes')) return 'notificacoes';
        if (parametros.has('mensagens')) return 'mensagens';
        if (parametros.has('perfil')) return 'perfil';

        return 'nenhum';
    }


    // Função para trocar a página exibida
    function trocaPage(btnNav, page) {
        linksNav.removeClass('active');
        btnNav.addClass('active');
        sectionPrincipal.empty();
        sectionPrincipal.load(`pages/escola/${page}.php`);
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
        case 'perfil':
            trocaPage(btnPerfil, 'perfil');
            break;
        default:
            trocaPage(btnNavMenu, 'menu');
            break;
    }


    // Adiciona eventos de clique a todos os botões de navegação
    adicionarEventoClique(btnNavMenu, 'menu');
    adicionarEventoClique(btnNavCurriculos, 'curriculos');
    adicionarEventoClique(btnNavVagas, 'vagas');
    adicionarEventoClique(btnNavEmpresas, 'empresas');
    adicionarEventoClique(btnNavNotificacoes, 'notificacoes');
    adicionarEventoClique(btnNavMensagens, 'mensagens');
    adicionarEventoClique(btnPerfil, 'perfil');
});