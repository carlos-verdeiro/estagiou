$(document).ready(function () {
    const main = $('.divInputs');
    const progress = $('.progress-bar');

    let tipoPessoa = null;
    let etapaAtual = 0;

    function aumentarBarraStatus(porc) {
        progress.width(porc);
        progress.text(porc);
    }

    // Função para carregar o conteúdo de um arquivo PHP
    function carregarConteudo(arquivo) {
        main.empty();
        main.load(arquivo);
    }

    // Delegação de eventos para botões de avanço e voltar
    main.on('click', '.btnProximo', function (e) {
        e.preventDefault();
        carregarProximaEtapa();
    });

    main.on('click', '.btnVoltar', function (e) {
        e.preventDefault();

        if (etapaAtual <= 1) {
            let etapaAnteriorArquivo = 'public/pages/cadastro/tipoPessoa.php';
            carregarConteudo(etapaAnteriorArquivo);
            let progressoAnterior = '0%';
            aumentarBarraStatus(progressoAnterior);
            etapaAtual--;
        } else {
            let etapaAnteriorArquivo = `public/pages/cadastro/${tipoPessoa}/etapa${etapaAtual - 1}.php`;
            carregarConteudo(etapaAnteriorArquivo);
            let progressoAnterior = '0%';
            aumentarBarraStatus(progressoAnterior);
            etapaAtual--;
        }
    });

    // Delegação de eventos para seleção do tipo de cadastro
    main.on('click', '#cadastroEstagiario', function (e) {
        e.preventDefault();
        carregarConteudo('public/pages/cadastro/estagiario/etapa1.php');
        tipoPessoa = 'estagiario';
        aumentarBarraStatus('20%');
        etapaAtual = 1;
    });

    main.on('click', '#cadastroIE', function (e) {
        e.preventDefault();
        carregarConteudo('public/pages/cadastro/ie/etapa1.php');
        tipoPessoa = 'ensino';
        aumentarBarraStatus('20%');
        etapaAtual = 1;
    });

    main.on('click', '#cadastroEmpresa', function (e) {
        e.preventDefault();
        carregarConteudo('public/pages/cadastro/empresa/etapa1.php');
        tipoPessoa = 'empresa';
        aumentarBarraStatus('20%');
        etapaAtual = 1;
    });

    // Função para carregar a próxima etapa do formulário
    function carregarProximaEtapa() {
        let proximaEtapaArquivo = `public/pages/cadastro/${tipoPessoa}/etapa${etapaAtual + 1}.php`;
        carregarConteudo(proximaEtapaArquivo);
        aumentarBarraStatus((etapaAtual + 1) * 20 + '%');
        etapaAtual++;
    }
});
