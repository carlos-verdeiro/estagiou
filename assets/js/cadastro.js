$(document).ready(function () {

    const main = $('.divInputs');
    const btnEstagiario = $('#cadastroEstagiario');
    const btnIE = $('#cadastroIE');
    const btnEmpresa = $('#cadastroEmpresa');
    const progress = $('.progress-bar');

    let tipoPessoa = null;
    let etapaAtual = 1;

    function aumetarBarraStatus(porc) {
        $(progress).width(porc);
        $(progress).text(porc);
    }

    $(btnEstagiario).click(function (e) {
        $(main).empty();
        $(main).load('public/pages/cadastro/estagiario/nomePessoa.php');
        tipoPessoa = 'estagiario';
        aumetarBarraStatus('20%');
        etapaAtual = 2;
    });

    $(btnIE).click(function (e) {
        tipoPessoa = 'ensino';
        $(main).empty();
        $(main).load('public/pages/cadastro/ie/nomeIe.php');
        aumetarBarraStatus('20%');
        etapaAtual = 2;
    });

    $(btnEmpresa).click(function (e) {
        tipoPessoa = 'empresa';
        $(main).empty();
        $(main).load('public/pages/cadastro/empresa/nomeEmpresa.php');
        aumetarBarraStatus('20%');
        etapaAtual = 2;
    });

});
