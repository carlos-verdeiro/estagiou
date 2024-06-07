$(document).ready(function () {
    const cpf = $("#cpf");
    const feedbackCPF = $("#feedback-cpf");
    const nome = $("#nome");
    const feedbackNome = $("#feedback-nome");
    const email = $("#email");
    const feedbackEmail = $("#feedback-email");


    // Máscara para o CPF
    cpf.mask('000.000.000-00', { reverse: false });

    function validacaoCPF() {

        let cpfVal = cpf.val().replace(/[.-]/g, '');

        if (!$.isNumeric(cpfVal) || cpfVal.length != 11) {
            $(feedbackCPF).text('Campo obrigatório *');
            $(cpf).removeClass('is-valid');
            $(cpf).addClass('is-invalid'); // CPF indisponível
        } else {
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
                    if (data.mensagem) {
                        $(cpf).removeClass('is-invalid');
                        $(cpf).addClass('is-valid');//CPF Disponível
                    } else {
                        $(feedbackCPF).text('Usuário já existente');
                        $(cpf).removeClass('is-valid');
                        $(cpf).addClass('is-invalid');//CPF indisponível
                    }
                },
                error: function (xhr) {
                    // Tente fazer o parse da resposta JSON
                    let response;
                    try {
                        response = JSON.parse(xhr.responseText);
                    } catch (e) {
                        console.error('Erro ao parsear a resposta JSON:', e);
                        alert('Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.');
                        return;
                    }

                    // Verifique o código de erro e tome as ações apropriadas
                    if (response.code == 1) { // erro de caractere insuficiente
                        $(feedbackCPF).text('Preencha corretamente');
                        $(cpf).removeClass('is-valid');
                        $(cpf).addClass('is-invalid'); // CPF indisponível
                    } else if (response.code == 2) { // erro de banco de dados
                        $(cpf).removeClass('is-valid');
                        $(cpf).removeClass('is-invalid');
                        alert('Ocorreu um erro, por favor tente novamente mais tarde.');
                        console.log('Erro de conexão com o banco de dados');
                    } else {
                        // Tratamento para outros códigos de erro não especificados
                        $(cpf).removeClass('is-valid');
                        $(cpf).removeClass('is-invalid');
                        alert('Ocorreu um erro não identificado. Por favor, tente novamente mais tarde.');
                        console.log('Erro desconhecido:', response);
                    }
                }



            })
                .always(function () {
                    // Sempre executado após done ou fail
                    console.log('AJAX requisição completa.');
                });
        }

    }

    function validacaoNome() {
        let valNome = $(nome).val();

        if (valNome.length == 0) {
            $(feedbackNome).text('Campo obrigatório *');
            $(nome).removeClass('is-valid');
            $(nome).addClass('is-invalid'); // CPF indisponível
        }else{
            $(nome).removeClass('is-invalid');
            $(nome).addClass('is-valid'); // CPF indisponível
        }
    }

    function validacaoEmail() {

        let valEmail = email.val();
    
        // Expressão regular para validar o formato do e-mail
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
        if (valEmail.length === 0) {
            feedbackEmail.text('Campo obrigatório *');
            email.removeClass('is-valid').addClass('is-invalid');
        } else if (!emailRegex.test(valEmail)) {
            feedbackEmail.text('Formato de e-mail inválido');
            email.removeClass('is-valid').addClass('is-invalid');
        } else {
            feedbackEmail.text('');
            email.removeClass('is-invalid').addClass('is-valid');
        }
    }
    

    // Chamar as funções ao clicar fora dos campos
    cpf.on("blur", validacaoCPF);
    nome.on("blur", validacaoNome);
    email.on("blur", validacaoEmail);

});
