$(document).ready(function () {
    // Elementos do DOM
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

    // Função para converter data
    function converterData(data) {
        var partes = data.split('-');
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }

    // Função para puxar arquivo
    function puxarArquivo() {
        $.ajax({
            url: '../server/api/curriculos/downloadCurriculo.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    divArquivo.removeClass('visually-hidden');
                    divInformacoes.removeClass('visually-hidden').addClass('w-100');
                    iframeArquivo.attr('src', '../server/curriculos/' + response.file);
                    btnExcluir.removeClass('disabled');
                    resNomeArquivo.text(response.nome);
                    resSubmissao.text(converterData(response.data_submissao));
                    resObservacoes.text(response.observacoes);
                } else if (response.status === 'notFound') {
                    divArquivo.addClass('visually-hidden');
                    divInformacoes.removeClass('w-100').addClass('visually-hidden');
                    btnExcluir.addClass('disabled');
                } else {
                    corpoToastInformacao.text('Erro ao gerar o PDF.');
                    toastInformacao.show();
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição:', error);
            }
        });
    }

    // Função de upload de arquivo
    $('#formUploadArquivo').submit(function (event) {
        event.preventDefault();
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
                corpoToastInformacao.text('Erro ao enviar arquivo.');
                toastInformacao.show();
            },
            complete: function() {
                $("#overlay").hide();
            }
        });

        return false;
    });

    // Função de exclusão de arquivo
    btnModalExcluir.on('click', function () {
        $.ajax({
            url: '../server/api/curriculos/excluirCurriculo.php',
            type: 'POST',
            success: function (response) {
                puxarArquivo();
                corpoToastInformacao.text('Excluído com sucesso.');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Erro ao excluir arquivo');
                toastInformacao.show();
            }
        });
    });

    // Inicializar
    puxarArquivo();
});