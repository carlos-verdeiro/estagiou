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
    //etapa 3
    const nacionalidade = $("#nacionalidade");
    const feedbackNacionalidade = $("#feedback-nacionalidade");
    const celular = $("#celular");
    const feedbackCelular = $("#feedback-celular");
    const telefone = $("#telefone");
    const feedbackTelefone = $("#feedback-telefone");
    const dataNascimento = $("#dataNascimento");
    const feedbackDataNascimento = $("#feedback-dataNascimento");
    const dependentes = $("#dependentes");
    const feedbackDependentes = $("#feedback-dependentes");
    //etapa 4
    const cep = $("#cep");
    const feedbackCep = $("#feedback-cep");
    const pais = $("#pais");
    const feedbackPais = $("#feedback-pais");
    const cidade = $("#cidade");
    const feedbackCidade = $("#feedback-cidade");
    const estado = $("#estado");
    const feedbackEstado = $("#feedback-estado");
    const endereco = $("#endereco");
    const feedbackEndereco = $("#feedback-endereco");
    const bairro = $("#bairro");
    const feedbackBairro = $("#feedback-bairro");
    const numero = $("#numero");
    const feedbackNumero = $("#feedback-numero");
    //etapa 5
    const senha = $("#senha");
    const feedbackSenha = $("#feedback-senha");
    const confirmacaoSenha = $("#confirmacaoSenha");
    const feedbackConfirmacaoSenha = $("#feedback-confirmacaoSenha");

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

    // Máscara para o Celular
    celular.mask('(00) 00000-0000', { reverse: false });

    // Máscara para o telefone
    telefone.mask('(00) 0000-0000', { reverse: false });

    // Máscara para o CEP
    cep.mask('00000-000', { reverse: false });

    // Máscara para o Número
    numero.mask('0000000000', { reverse: false });

    //Bloqueia colagem na senha
    senha.bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    //Bloqueia colagem na confirmação de senha
    confirmacaoSenha.bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    function calculoCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000" ||strCPF == "11111111111" ||strCPF == "22222222222" ||strCPF == "33333333333" ||strCPF == "44444444444" ||strCPF == "55555555555" ||strCPF == "66666666666" ||strCPF == "77777777777" ||strCPF == "88888888888" ||strCPF == "99999999999") return false;

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
                    url: '/server/api/validacao.php',
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
                        let response;
                        try {
                            response = JSON.parse(xhr.responseText);
                        } catch (e) {
                            console.error('Erro ao parsear a resposta JSON:', e);
                            alert('Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.1');
                            reject('Erro inesperado');
                        }

                        if (response && response.code == 1) {
                            $(feedbackCPF).text('Preencha corretamente');
                            $(cpf).removeClass('is-valid');
                            $(cpf).addClass('is-invalid');
                            reject('Preencha corretamente');
                        } else if (response && response.code == 2) {
                            alert('Ocorreu um erro, por favor tente novamente mais tarde.2');
                            console.log('Erro de conexão com o banco de dados');
                            reject('Erro de conexão com o banco de dados');
                        } else {
                            alert('Ocorreu um erro não identificado. Por favor, tente novamente mais tarde.3');
                            console.log('Erro desconhecido:', response);
                            reject('Erro desconhecido');
                        }
                    }
                });
            }
        });
    }

    function validacaoEmail() {
        return new Promise(function (resolve, reject) {
            let valEmail = email.val();

            // Expressão regular para validar o formato do e-mail
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (valEmail.length === 0) {
                feedbackEmail.text('Campo obrigatório *');
                email.removeClass('is-valid').addClass('is-invalid');
                return false;
            }

            if (valEmail.length > 100) {
                feedbackEmail.text('Limite de 100 caracteres *');
                email.removeClass('is-valid').addClass('is-invalid');
                return false;
            }

            if (!emailRegex.test(valEmail)) {
                feedbackEmail.text('Formato de e-mail inválido');
                email.removeClass('is-valid').addClass('is-invalid');
                return false;
            }

            // Enviar o Email  ao servidor
            $.ajax({
                type: "POST",
                url: '/server/api/validacao.php',
                data: {
                    email: valEmail,
                },
                dataType: "json",
                success: function (data) {
                    // Exibir feedback ao usuário
                    if (data.mensagem) {
                        email.removeClass('is-invalid');
                        email.addClass('is-valid');
                        resolve(true); // CPF disponível
                    } else {
                        feedbackEmail.text('E-mail já utilizado');
                        email.removeClass('is-valid');
                        email.addClass('is-invalid');
                        reject('E-mail já utilizado');
                    }
                },
                error: function (xhr) {
                    // Trate o erro de acordo com a resposta do servidor

                    console.error('Erro resposta JSON:', xhr.mensagem);

                    alert('Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.');
                    reject('Erro inesperado');


                    if (response && response.code == 1) {
                        feedbackEmail.text('Preencha corretamente');
                        email.removeClass('is-valid');
                        email.addClass('is-invalid');
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
        });
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
                    url: '/server/api/validacao.php',
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

        if (element.val() == 'NA' || element.val() == '' || element.val() == null) {
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

    function validacaoTamanho(element, feedbackElement, tipo, caracteres) {
        let valor = $(element).val().trim();

        switch (tipo) {
            case 'igual':
                if (valor.length != caracteres) {
                    $(feedbackElement).text('Campo obrigatório *');
                    $(element).removeClass('is-valid');
                    $(element).addClass('is-invalid');
                    return false;
                } else {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                    return true;
                }
            case 'maximo':
                if (valor.length >= caracteres) {
                    $(feedbackElement).text('Campo Excedido *');
                    $(element).removeClass('is-valid');
                    $(element).addClass('is-invalid');
                    return false;
                } else {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                    return true;
                }
            case 'minimo':
                if (valor.length <= caracteres) {
                    $(feedbackElement).text('Campo obrigatório *');
                    $(element).removeClass('is-valid');
                    $(element).addClass('is-invalid');
                    return false;
                } else {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                    return true;
                }

            default:
                break;
        }


    }

    function validacaoSenha() {
        let valor = senha.val();
        if (valor.length < 8) {
            feedbackSenha.text('Deve conter no mínimo 8 caracteres *');
            senha.removeClass('is-valid');
            senha.addClass('is-invalid');
            return false;
        }

        if (!/[A-Z]/.test(valor)) {
            feedbackSenha.text('A senha deve conter pelo menos uma letra maiúscula *');
            senha.removeClass('is-valid');
            senha.addClass('is-invalid');
            return false;
        }

        if (!/[a-z]/.test(valor)) {
            feedbackSenha.text('A senha deve conter pelo menos uma letra minúscula *');
            senha.removeClass('is-valid');
            senha.addClass('is-invalid');
            return false;
        }

        if (!/[0-9]/.test(valor)) {
            feedbackSenha.text('A senha deve conter pelo menos um número *');
            senha.removeClass('is-valid');
            senha.addClass('is-invalid');
            return false;
        }

        if (!/[!@#$%^&*(),.?":{}|<>]/.test(valor)) {
            feedbackSenha.text('A senha deve conter pelo menos um caractere especial *');
            senha.removeClass('is-valid');
            senha.addClass('is-invalid');
            return false;
        }

        senha.removeClass('is-invalid');
        senha.addClass('is-valid');
        return true;

    }

    function validacaoConfirmacaoSenha() {
        if (!validacaoSenha()) {
            feedbackConfirmacaoSenha.text('A senha não atende os requisitos *');
            confirmacaoSenha.removeClass('is-valid');
            confirmacaoSenha.addClass('is-invalid');
            return false;
        }

        if (senha.val() === confirmacaoSenha.val()) {
            confirmacaoSenha.addClass('is-valid');
            confirmacaoSenha.removeClass('is-invalid');
            return true;
        } else {
            feedbackConfirmacaoSenha.text('As senhas são divergentes *');
            confirmacaoSenha.removeClass('is-valid');
            confirmacaoSenha.addClass('is-invalid');
            return false;
        }
    }

    async function buscaCEP(valor) {

        $.getJSON(`https://brasilapi.com.br/api/cep/v1/${valor}`,
            function (data, textStatus, jqXHR) {
                console.log(textStatus);
                cidade.val(data.city);
                estado.val(data.state);
                endereco.val(data.street);
                bairro.val(data.neighborhood);
                pais.val('Brasil');

                validacaoTamanho(cidade, feedbackCidade, 'minimo', 0);
                validacaoSelect(estado, feedbackEstado);
                validacaoTamanho(endereco, feedbackEndereco, 'minimo', 0);
                validacaoTamanho(bairro, feedbackBairro, 'minimo', 0);
                validacaoTamanho(pais, feedbackPais, 'minimo', 0);

            }
        );


    }



    // Chamar as funções ao clicar fora dos campos
    cpf.on("blur", validacaoCPF);

    nome.on("blur", function () {
        validacaoTamanho(nome, feedbackNome, 'minimo', 0);
    });

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

    dataNascimento.on("blur", function () {
        validacaoTamanho(dataNascimento, feedbackDataNascimento, 'igual', 10);
    });

    nacionalidade.on("blur", function () {
        validacaoTamanho(nacionalidade, feedbackNacionalidade, 'minimo', 0);
    });

    celular.on("blur", function () {
        validacaoTamanho(celular, feedbackCelular, 'igual', 15);
    });

    dependentes.on("blur", function () {
        if (dependentes.val() == 0) {
            dependentes.val(0);
            return true;
        }

    });

    cep.on("blur", function () {
        if (validacaoTamanho(cep, feedbackCep, 'igual', 9) && !endereco.val() && !bairro.val() && !cidade.val()) {
            buscaCEP(cep.val().replace(/[^0-9]/g, ''));
        }
    });

    pais.on("blur", function () {
        validacaoTamanho(pais, feedbackPais, 'minimo', 0);


    });

    cidade.on("blur", function () {

        validacaoTamanho(cidade, feedbackCidade, 'minimo', 0);

    });

    estado.on("change", function () {

        validacaoSelect(estado, feedbackEstado);

    });

    endereco.on("blur", function () {

        validacaoTamanho(endereco, feedbackEndereco, 'minimo', 0);

    });

    bairro.on("blur", function () {

        validacaoTamanho(bairro, feedbackBairro, 'minimo', 0);

    });

    numero.on("blur", function () {

        validacaoTamanho(numero, feedbackNumero, 'minimo', 0);

    });

    senha.on("input", function () {
        validacaoSenha();
    });

    confirmacaoSenha.on("blur change input", function () {
        validacaoConfirmacaoSenha();
    });

    const params = new URLSearchParams(window.location.search);

    if (params.has('erroMC')) {
        // O parâmetro "id" existe
        alert("E-mail ou CPF preenchidos incorretamente.");
    }


    $('#formEtapa1').submit(async function (event) {
        event.preventDefault();

        try {

            let cpaF = await validacaoCPF();
            let emailF = await validacaoEmail()


            if (cpaF && validacaoTamanho(nome, feedbackNome, 'minimo', 0) && emailF) {
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

    $('#formEtapa3').submit(function (event) {
        // Evita o envio padrão do formulário
        event.preventDefault();

        // Realiza a validação do campo antes do envio
        if (validacaoTamanho(dataNascimento, feedbackDataNascimento, 'igual', 10) && validacaoTamanho(nacionalidade, feedbackNacionalidade, 'minimo', 0) && validacaoTamanho(celular, feedbackCelular, 'igual', 15)) {
            // Se a validação for bem-sucedida, prossegue com o envio do formulário
            this.submit();
        } else {
            // Se a validação falhar, exibe mensagem ou realiza ação necessária
            console.log('Campos não preenchidos corretamente');
        }
    });

    $('#formEtapa4').submit(function (event) {
        // Evita o envio padrão do formulário
        event.preventDefault();

        // Realiza a validação do campo antes do envio
        if (validacaoTamanho(cep, feedbackCep, 'igual', 9) && validacaoTamanho(pais, feedbackPais, 'minimo', 0) && validacaoTamanho(cidade, feedbackCidade, 'minimo', 0) && validacaoSelect(estado, feedbackEstado) && validacaoTamanho(endereco, feedbackEndereco, 'minimo', 0) && validacaoTamanho(bairro, feedbackBairro, 'minimo', 0) && validacaoTamanho(numero, feedbackNumero, 'minimo', 0)) {
            // Se a validação for bem-sucedida, prossegue com o envio do formulário
            this.submit();
        } else {
            // Se a validação falhar, exibe mensagem ou realiza ação necessária
            console.log('Campos não preenchidos corretamente');
        }
    });

    $('#formEtapa5').submit(function (event) {
        // Evita o envio padrão do formulário
        event.preventDefault();

        // Realiza a validação do campo antes do envio
        if (validacaoSenha() && validacaoConfirmacaoSenha()) {
            // Se a validação for bem-sucedida, prossegue com o envio do formulário
            this.submit();
        } else {
            // Se a validação falhar, exibe mensagem ou realiza ação necessária
            console.log('Campos não preenchidos corretamente');
        }
    });

});
