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
    const orgaoEmissor = $("#orgaoEmissor");
    const feedbackOrgaoEmissor = $("#feedback-orgaoEmissor");
    const estadoEmissor = $("#estadoEmissor");
    const feedbackEstadoEmissor = $("#feedback-estadoEmissor");
    const genero = $("#genero");
    const feedbackGenero = $("#feedback-genero");
    const estadoCivil = $("#estadoCivil");
    const feedbackEstadoCivil = $("#feedback-estadoCivil");


    // Máscara para o CPF
    cpf.mask('000.000.000-00', { reverse: false });

    // Máscara para o RG
    rg.mask('00.000.000-0', { reverse: true });

    // Máscara para o Orgão Emissor
    orgaoEmissor.on("input", () => {
        let valor = orgaoEmissor.val();
        let regex = /^[a-zA-Z]+$/;

        if (!regex.test(valor)) {
            orgaoEmissor.val(valor.replace(/[^a-zA-Z]/g, ''));
        }
    });


    function calculoCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000") return false;

        for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10))) return false;

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11)) Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11))) return false;
        return true;
    }

    function validacaoCPF() {
        return new Promise(function (resolve, reject) {
            let cpfVal = cpf.val().replace(/[.-]/g, '');

            if (!$.isNumeric(cpfVal) || cpfVal.length != 11) {
                $(feedbackCPF).text('Campo obrigatório *');
                $(cpf).removeClass('is-valid');
                $(cpf).addClass('is-invalid');
                reject('CPF inválido');
            } else if (!calculoCPF(cpfVal)) {
                $(feedbackCPF).text('CPF inválido *');
                $(cpf).removeClass('is-valid');
                $(cpf).addClass('is-invalid');
                reject('CPF inválido');
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
                            $(cpf).addClass('is-valid');
                            resolve(true); // CPF disponível
                        } else {
                            $(feedbackCPF).text('Usuário já existente');
                            $(cpf).removeClass('is-valid');
                            $(cpf).addClass('is-invalid');
                            reject('Usuário já existente');
                        }
                    },
                    error: function (xhr) {
                        // Trate o erro de acordo com a resposta do servidor
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            console.error('Erro ao parsear a resposta JSON:', e);
                            alert('Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.');
                            reject('Erro inesperado');
                        }

                        if (response && response.code == 1) {
                            $(feedbackCPF).text('Preencha corretamente');
                            $(cpf).removeClass('is-valid');
                            $(cpf).addClass('is-invalid');
                            reject('Preencha corretamente');
                        } else if (response && response.code == 2) {
                            alert('Ocorreu um erro, por favor tente novamente mais tarde.');
                            console.log('Erro de conexão com o banco de dados');
                            reject('Erro de conexão com o banco de dados');
                        } else {
                            alert('Ocorreu um erro não identificado. Por favor, tente novamente mais tarde.');
                            console.log('Erro desconhecido:', response);
                            reject('Erro desconhecido');
                        }
                    }
                });
            }
        });
    }

    function validacaoNome() {
        let valNome = $(nome).val();

        if (valNome.length == 0) {
            $(feedbackNome).text('Campo obrigatório *');
            $(nome).removeClass('is-valid');
            $(nome).addClass('is-invalid');
            return false;
        } else {
            $(nome).removeClass('is-invalid');
            $(nome).addClass('is-valid');
            return true;
        }
    }

    function validacaoEmail() {

        let valEmail = email.val();

        // Expressão regular para validar o formato do e-mail
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (valEmail.length === 0) {
            feedbackEmail.text('Campo obrigatório *');
            email.removeClass('is-valid').addClass('is-invalid');
            return false;
        } else if (!emailRegex.test(valEmail)) {
            feedbackEmail.text('Formato de e-mail inválido');
            email.removeClass('is-valid').addClass('is-invalid');
            return false;
        } else {
            feedbackEmail.text('');
            email.removeClass('is-invalid').addClass('is-valid');
            return true;
        }
    }

    function validacaoRG() {
        return new Promise(function (resolve, reject) {
            let rgVal = rg.val().replace(/\D/g, '');

            if (!$.isNumeric(rgVal) || rgVal.length !== 9) {
                $(feedbackRG).text('Deve ter 9 dígitos *');
                $(rg).removeClass('is-valid');
                $(rg).addClass('is-invalid');
                reject('RG inválido');
            } else {
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
                            $(rg).addClass('is-valid');
                            resolve(true); // RG disponível
                        } else {
                            $(feedbackRG).text('RG já utilizado');
                            $(rg).removeClass('is-valid');
                            $(rg).addClass('is-invalid');
                            reject('RG já utilizado');
                        }
                    },
                    error: function (xhr) {
                        // Trate o erro de acordo com a resposta do servidor
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            console.error('Erro ao parsear a resposta JSON:', e);
                            alert('Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.');
                            reject('Erro inesperado');
                        }

                        if (response && response.code == 1) {
                            $(feedbackRG).text('Preencha corretamente');
                            $(rg).removeClass('is-valid');
                            $(rg).addClass('is-invalid');
                            reject('Preencha corretamente');
                        } else if (response && response.code == 2) {
                            alert('Ocorreu um erro, por favor tente novamente mais tarde.');
                            console.log('Erro de conexão com o banco de dados');
                            reject('Erro de conexão com o banco de dados');
                        } else {
                            alert('Ocorreu um erro não identificado. Por favor, tente novamente mais tarde.');
                            console.log('Erro desconhecido:', response);
                            reject('Erro desconhecido');
                        }
                    }
                });
            }
        });
    }

    function validacaoOrgaoEmissor() {
        let valOE = orgaoEmissor.val();
        let regex = /^[a-zA-Z]+$/;

        if (valOE.length == 0 || !regex.test(valOE)) {
            feedbackOrgaoEmissor.text('Campo obrigatório *');
            orgaoEmissor.removeClass('is-valid');
            orgaoEmissor.addClass('is-invalid');
            return false;

        } else {
            orgaoEmissor.removeClass('is-invalid');
            orgaoEmissor.addClass('is-valid');
            return true;
        }
    }

    function validacaoSelect(element, feedbackElement) {

        if (element.val == 'NA') {
            feedbackElement.text('Selecione um valor válido *');
            element.removeClass('is-valid');
            element.addClass('is-invalid');
            return false;

        } else {
            element.removeClass('is-invalid');
            element.addClass('is-valid');
            return true;
        }
    }


    // Chamar as funções ao clicar fora dos campos
    cpf.on("blur", validacaoCPF);
    nome.on("blur", validacaoNome);
    email.on("blur", validacaoEmail);

    rg.on("blur", validacaoRG);
    orgaoEmissor.on("blur", validacaoOrgaoEmissor);
    estadoEmissor.on("blur change", function () {
        validacaoSelect(estadoEmissor, feedbackEstadoEmissor);
    });
    genero.on("blur change", function () {
        validacaoSelect(genero, feedbackGenero);
    });
    estadoCivil.on("blur change", function () {
        validacaoSelect(estadoCivil, feedbackEstadoCivil);
    });

    $('#formEtapa1').submit(async function (event) {
        event.preventDefault();

        try {
            let cpfValido = await validacaoCPF();

            if (cpfValido && validacaoNome() && validacaoEmail()) {
                this.submit(); // Envio do formulário
            } else {
                console.log('Campos não preenchidos corretamente');
            }
        } catch (error) {
            console.log('Erro na validação do CPF:', error);
        }
    });


    $('#formEtapa2').submit(function (event) {
        // Evita o envio padrão do formulário
        event.preventDefault();

        // Realiza a validação do campo antes do envio
        if (validacaoRG() && validacaoOrgaoEmissor() && validacaoSelect(estadoEmissor, feedbackEstadoEmissor) && validacaoSelect(genero, feedbackGenero) && validacaoSelect(estadoCivil, feedbackEstadoCivil)) {
            // Se a validação for bem-sucedida, prossegue com o envio do formulário
            this.submit();
        } else {
            // Se a validação falhar, exibe mensagem ou realiza ação necessária
            console.log('Campos não preenchidos corretamente');
        }
    });

});