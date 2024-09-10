$(document).ready(function () {

    const divArquivo = $('.arquivo');
    const iframeArquivo = $('#iframeArquivo');
    const btnExcluir = $('#btnExcluir');
    const curriculo = $('#curriculo');
    const observacoes = $('#observacoes');

    const btnModalExcluir = $('#btnModalExcluir');


    const divInformacoes = $('#divInformacoes');
    const resNomeArquivo = $('#resNomeArquivo');
    const resSubmissao = $('#resSubmissao');
    const resObservacoes = $('#resObservacoes');

    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    function converterData(data) {
        var partes = data.split('-');
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }


    function puxarArquivo() {
        
        $.ajax({
            url: '../server/api/curriculos/downloadCurriculo.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    divArquivo.removeClass('visually-hidden');
                    divInformacoes.removeClass('visually-hidden');
                    divInformacoes.addClass('w-100');

                    let caminho = '../server/curriculos/' + response.file;
                    iframeArquivo.attr('src', caminho);
                    btnExcluir.removeClass('disabled');


                    resNomeArquivo.text(response.nome);
                    resSubmissao.text(converterData(response.data_submissao));
                    resObservacoes.text(response.observacoes);

                } else if (response.status === 'notFound') {
                    if (!divArquivo.hasClass('visually-hidden')) {
                        divArquivo.addClass('visually-hidden');

                        divInformacoes.removeClass('w-100');    
                        divInformacoes.addClass('visually-hidden');
                    }
                    btnExcluir.addClass('disabled');

                } else {
                    corpoToastInformacao.text(`Erro ao gerar o PDF.`);
                    toastInformacao.show();
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição:', error);
            }
        });
    }

    puxarArquivo();

    $('#formUploadArquivo').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/curriculos/uploadCurriculo.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // Mostra o indicador de carregamento
                $("#overlay").show();
            },
            success: function (response) {
                puxarArquivo();
                curriculo.val('');
                observacoes.val('');
                corpoToastInformacao.text(response);
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text(`Erro ao enviar arquivo.`);
                toastInformacao.show();
            },
            complete: function() {
                // Esconde o indicador de carregamento
                $("#overlay").hide();
            }
        });

        return false;
    });

    btnModalExcluir.on('click', ()=>{
        $.ajax({
            url: '../server/api/curriculos/excluirCurriculo.php',
            type: 'POST',
            success: function (response) {
                puxarArquivo();
                corpoToastInformacao.text('Excluido com sucesso.');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text(`Erro ao excluir arquivo`);
                toastInformacao.show();
            }
        });

    });
});