$(document).ready(function () {

    const divArquivo = $('.arquivo');
    const iframeArquivo = $('#iframeArquivo');

    function puxarArquivo() {
        $.ajax({
            url: '../server/api/downloadCurriculo.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {

                    divArquivo.removeClass('visually-hidden');
                    let caminho = '../server/curriculos/' + response.file;
                    iframeArquivo.attr('src', caminho);
                } else if (response.status === 'notFound') {
                    if (!divArquivo.hasClass('visually-hidden')) {
                        divArquivo.addClass('visually-hidden');                    }
                } else {
                    alert('Erro ao gerar o PDF.');
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
            url: '../server/api/uploadCurriculo.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                puxarArquivo();
            },
            error: function () {
                alert('Erro ao enviar arquivo.');
            }
        });

        return false;
    });
});