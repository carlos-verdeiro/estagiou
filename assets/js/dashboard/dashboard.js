$(document).ready(function () {
    const sidebar = $('.sidebar');
    const btnLogo = $('#divLogoNav');
    const textLinkNav = $('.textLinkNav');
    const iconLinkNav = $('.iconLinkNav');
    var sidebarStatus = true;

    // Função para fechar o offcanvas
    function closeOffcanvas() {
        const offcanvasElement = bootstrap.Offcanvas.getInstance(sidebar[0]);
        if (offcanvasElement) {
            offcanvasElement.hide();
        }
        sidebarStatus = false;
    }

    btnLogo.on('click', () => {
        // Verifica se a largura da janela é menor que 576px (sm)
        if ($(window).width() < 576) {
            closeOffcanvas();
        } else {
            // Altere o layout do sidebar como de costume
            if (sidebarStatus) {
                sidebar.width('100px');
                textLinkNav.fadeOut(100);
                iconLinkNav.css('width', '100%');
                sidebarStatus = false;
            } else {
                sidebar.width('300px');
                textLinkNav.fadeIn(400);
                iconLinkNav.css('width', '10%');
                sidebarStatus = true;
            }
        }
    });

    // Adiciona a classe 'show' novamente ao redimensionar a janela para maior que 576px
    $(window).resize(function () {
        if ($(window).width() >= 576 && !sidebarStatus) {
            const offcanvasElement = bootstrap.Offcanvas.getInstance(sidebar[0]);
            if (offcanvasElement) {
                offcanvasElement.show(); // Chama o método para abrir o offcanvas
            }
            sidebar.width('300px'); // Define o tamanho padrão ao reabrir
            textLinkNav.show();
            iconLinkNav.css('width', '10%');
            sidebarStatus = true;
        }
    });

    // Fecha o offcanvas ao clicar em qualquer link com a classe .linkNav
    $('.linkNav').on('click', () => {
        closeOffcanvas();
    });
});
