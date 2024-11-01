$(document).ready(function () {
    $('#formulario').on('submit', function (e) {
        e.preventDefault(); // Previne o comportamento padrão do formulário

        $('#loading').show(); // Exibe o loader

        $.ajax({
            url: 'server/api/redefinicao_senha.php', // URL do seu script PHP
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#loading').hide(); // Oculta o loader

                if (response.includes("Email já foi utilizado para redefinição de senha")) {
                    $('#errorMessage').text(response);
                    $('#errorMessage').show();

                } else {
                    $('#successMessage').text(response); // Exibe a mensagem de sucesso
                    $('#successMessage').show();

                }
            },
            error: function () {
                $('#loading').hide(); // Oculta o loader
                alert('Erro ao enviar a solicitação.'); // Exibe mensagem de erro
            }
        });
    });
});