$(document).ready(function () {
    const $cpf = $("#cpf");

    // Máscara para o CPF
    $cpf.mask('000.000.000-00', { reverse: false });

    function validacaoCPF() {

        const cpfVal = $cpf.val().replace(/[.-]/g, '');
        
        // Enviar o CPF ao servidor
        $.ajax({
            type: "POST",
            url: '/estagiou/api/validacao.php',
            data: {
                cpf: cpfVal,
            },
            dataType: "json",
            success: function (data) {
                // Exibir feedback ao usuário
                alert(data.mensagem);
            },
            error: function (xhr, status, error) {
                // Exibir mensagem de erro retornada pelo servidor
                alert("Erro: " + xhr.responseText);
            }
        });
    }

    // Chamar a função valCPF ao clicar fora do campo CPF
    $cpf.on("blur", validacaoCPF);
});
