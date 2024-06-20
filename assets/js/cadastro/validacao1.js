$(document).ready(function () {
    //etapa 1
    const cpf = $("#cpf");
    const feedbackCPF = $("#feedback-cpf");
    const nome = $("#nome");
    const feedbackNome = $("#feedback-nome");
    const email = $("#email");
    const feedbackEmail = $("#feedback-email");
    //etapa 2
    const rg = $("#rg");
    const feedbackRG = $("#feedback-rg");

    // Máscara para o CPF
    cpf.mask('000.000.000-00', { reverse: false });

    // Máscara para o CPF
    rg.mask('00.000.000-0', {reverse: true});

    function calculoCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
      if (strCPF == "00000000000") return false;
    
      for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
      Resto = (Soma * 10) % 11;
    
        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
    
      Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
    
        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
        return true;
    }

    function validacaoCPF() {

        let cpfVal = cpf.val().replace(/[.-]/g, '');

        if (!$.isNumeric(cpfVal) || cpfVal.length != 11) {
            $(feedbackCPF).text('Campo obrigatório *');
            $(cpf).removeClass('is-valid');
            $(cpf).addClass('is-invalid');
        }else if (!calculoCPF(cpfVal)) {

            $(feedbackCPF).text('CPF inválido *');
            $(cpf).removeClass('is-valid');
            $(cpf).addClass('is-invalid');

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

    function validacaoRG() {

        let rgVal = rg.val().replace(/\D/g, '');

        if (!$.isNumeric(rgVal) ||rgVal.length !== 9) {
            $(feedbackRG).text('Deve ter 9 dígitos *');
            $(rg).removeClass('is-valid');
            $(rg).addClass('is-invalid');
        }else{
            // Enviar o RG ao servidor
            $.ajax({
                type: "POST",
                url: '/estagiou/api/validacao.php',
                data: {
                    rg: rgVal,
                },
                dataType: "json",
                success: function (data) {
                    // Exibir feedback ao usuário
                    if (data.mensagem) {
                        $(rg).removeClass('is-invalid');
                        $(rg).addClass('is-valid');//RG Disponível
                    } else {
                        $(feedbackRG).text('RG já utilizado');
                        $(rg).removeClass('is-valid');
                        $(rg).addClass('is-invalid');//RG indisponível
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
                        $(feedbackRG).text('Preencha corretamente');
                        $(rg).removeClass('is-valid');
                        $(rg).addClass('is-invalid'); // RG indisponível
                    } else if (response.code == 2) { // erro de banco de dados
                        $(rg).removeClass('is-valid');
                        $(rg).removeClass('is-invalid');
                        alert('Ocorreu um erro, por favor tente novamente mais tarde.');
                        console.log('Erro de conexão com o banco de dados');
                    } else {
                        // Tratamento para outros códigos de erro não especificados
                        $(rg).removeClass('is-valid');
                        $(rg).removeClass('is-invalid');
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
    

    // Chamar as funções ao clicar fora dos campos
    cpf.on("blur", validacaoCPF);
    nome.on("blur", validacaoNome);
    email.on("blur", validacaoEmail);
    rg.on("blur", validacaoRG);

});
