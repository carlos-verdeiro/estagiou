$(document).ready(function () {

    const main = $('.divInputs');
    const btnEstagiario = $('#cadastroEstagiario');
    const btnIE = $('#cadastroIE');
    const btnEmpresa = $('#cadastroEmpresa');
    
    $(btnEstagiario).click(function (e) { 
        alert("Eu sou um estagiário!");
    });

    $(btnIE).click(function (e) { 
        alert("Eu sou uma instituição de ensino!");
    });

    $(btnEmpresa).click(function (e) { 
        alert("Eu sou uma empresa!");
    });
    
});
