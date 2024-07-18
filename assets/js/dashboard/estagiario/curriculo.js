$(document).ready(function() {
    $('#formArquivo').submit(function(event) {
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
            success: function(response) {
                alert(response);
            },
            error: function() {
                alert('Erro ao enviar arquivo.');
            }
        });

        return false;
    });
});