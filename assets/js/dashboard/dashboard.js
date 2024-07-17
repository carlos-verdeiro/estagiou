$(document).ready(function () {
    /*
    ---SIDEBAR INICIO---
    */
    const sidebar = $('.sidebar');
    const btnLogo = $('#divLogoNav');
    const textLinkNav = $('.textLinkNav');
    const iconLinkNav = $('.iconLinkNav');
    var sidebarStatus = true;

    btnLogo.on('click', () => {
        if (sidebarStatus) {
            sidebar.width('100px');
            textLinkNav.fadeOut(100);
            iconLinkNav.css('width', '100%');
            sidebarStatus = false;
        }else{
            sidebar.width('300px');
            textLinkNav.fadeIn(400);
            iconLinkNav.css('width', '10%');
            sidebarStatus = true;
        }
        
    })


    /*
    ---SIDEBAR FIM---
    */
});