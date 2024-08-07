$(document).ready(function () {

    const checkEncerra = $('#encerraCheckVaga');
    const dataEncerramentoVaga = $('#dataEncerramentoVaga');

    const btnModalExcluir = $('#btnModalExcluir');

    checkEncerra.on('click', () => {

        if (dataEncerramentoVaga.prop('disabled')) {
            dataEncerramentoVaga.prop('disabled', false);
        } else {
            dataEncerramentoVaga.prop('disabled', true);
            dataEncerramentoVaga.val('');
        }
    });

    $('#formCadastroVaga').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/criarVaga.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Mostra o indicador de carregamento
                $("#overlay").show();
            },
            success: function (response) {
                alert(`foi: ${response}`);
            },
            error: function () {
                alert('Erro ao enviar arquivo.');
            },
            complete: function () {
                // Esconde o indicador de carregamento
                $("#overlay").hide();
            }
        });

        return false;
    });

});