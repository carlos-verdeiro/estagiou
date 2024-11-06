$(document).ready(function () {
    //etapa 1
    const cnpj = $("#cnpj");
    const feedbackCNPJ = $("#feedback-cnpj");
    const nomeEscola = $("#nomeEscola");
    const feedbackNomeEscola = $("#feedback-nomeEscola");
    const telefone = $("#telefone");
    const feedbackTelefone = $("#feedback-telefone");
    const email = $("#email");
    const feedbackEmail = $("#feedback-email");
    //etapa 2
    const nomeResponsavel = $("#nomeResponsavel");
    const feedbackNomeResponsavel = $("#feedback-nomeResponsavel");
    const cargoResponsavel = $("#cargoResponsavel");
    const feedbackCargoResponsavel = $("#feedback-cargoResponsavel");
    const telefoneResponsavel = $("#telefoneResponsavel");
    const feedbackTelefoneResponsavel = $("#feedback-telefoneResponsavel");
    const emailResponsavel = $("#emailResponsavel");
    const feedbackEmailResponsavel = $("#feedback-emailResponsavel");
    //etapa 3
    const niveisEnsino = $("#niveisEnsino");
    const feedbackniveisEnsino = $("#feedback-niveisEnsino");
    const descricao = $("#descricao");
    const feedbackDescricao = $("#feedback-descricao");
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

    // Máscara para o CNPJ
    cnpj.mask('00.000.000/0000-00', { reverse: false });

    // Máscara para o telefone
    telefone.mask('(00) 0000-0000', { reverse: false });

    // Máscara para o telefone do responsavel
    telefoneResponsavel.mask('(00) 0000-0000', { reverse: false });

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

    function calculoCNPJ(strCNPJ) {
        if (strCNPJ.length !== 14) return false;

        // Elimina CNPJs inválidos conhecidos
        if (/^(\d)\1+$/.test(strCNPJ)) return false;

        let tamanho = strCNPJ.length - 2;
        let numeros = strCNPJ.substring(0, tamanho);
        let digitos = strCNPJ.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;

        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }

        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) return false;

        tamanho = tamanho + 1;
        numeros = strCNPJ.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;

        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }

        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) return false;

        return true;
    }

    function validacaoCNPJ() {
        return new Promise(function (resolve, reject) {
            let cnpjVal = cnpj.val().replace(/[./-]/g, '');

            if (!$.isNumeric(cnpjVal) || cnpjVal.length != 14) {
                $(feedbackCNPJ).text('Campo obrigatório *');
                $(cnpj).removeClass('is-valid');
                $(cnpj).addClass('is-invalid');
                reject('CNPJ inválido');
            } else if (!calculoCNPJ(cnpjVal)) {
                $(feedbackCNPJ).text('CNPJ inválido *');
                $(cnpj).removeClass('is-valid');
                $(cnpj).addClass('is-invalid');
                reject('CNPJ inválido');
            } else {
                // Enviar o CNPJ ao servidor
                $.ajax({
                    type: "POST",
                    url: '/server/api/validacao.php',
                    data: {
                        cnpj: cnpjVal,
                    },
                    dataType: "json",
                    success: function (data) {
                        // Exibir feedback ao usuário
                        if (data.mensagem) {
                            $(cnpj).removeClass('is-invalid');
                            $(cnpj).addClass('is-valid');
                            resolve(true); // CNPJ disponível
                        } else {
                            $(feedbackCNPJ).text('Usuário já existente');
                            $(cnpj).removeClass('is-valid');
                            $(cnpj).addClass('is-invalid');
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
                            $(feedbackCNPJ).text('Preencha corretamente');
                            $(cnpj).removeClass('is-valid');
                            $(cnpj).addClass('is-invalid');
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
                        resolve(true); // CNPJ disponível
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

    function validacaoEmailResponsavel() {

        let valEmail = emailResponsavel.val();

        // Expressão regular para validar o formato do e-mail
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (valEmail.length === 0) {
            feedbackEmailResponsavel.text('Campo obrigatório *');
            emailResponsavel.removeClass('is-valid').addClass('is-invalid');
            return false;
        }

        if (valEmail.length > 100) {
            feedbackEmailResponsavel.text('Limite de 100 caracteres *');
            emailResponsavel.removeClass('is-valid').addClass('is-invalid');
            return false;
        }

        if (!emailRegex.test(valEmail)) {
            feedbackEmailResponsavel.text('Formato de e-mail inválido');
            emailResponsavel.removeClass('is-valid').addClass('is-invalid');
            return false;
        }

        emailResponsavel.addClass('is-valid').removeClass('is-invalid');
        return true;

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
    cnpj.on("blur", validacaoCNPJ);

    nomeEscola.on("blur", function () {
        validacaoTamanho(nomeEscola, feedbackNomeEscola, 'minimo', 0);
    });

    email.on("blur", validacaoEmail);

    emailResponsavel.on("blur", validacaoEmailResponsavel);

    telefone.on("blur", function () {
        validacaoTamanho(telefone, feedbackTelefone, 'igual', 14);
    });

    telefoneResponsavel.on("blur", function () {
        validacaoTamanho(telefoneResponsavel, feedbackTelefoneResponsavel, 'igual', 14);
    });

    nomeResponsavel.on("blur", function () {

        validacaoTamanho(nomeResponsavel, feedbackNomeResponsavel, 'minimo', 0);

    });

    cargoResponsavel.on("blur", function () {

        validacaoTamanho(cargoResponsavel, feedbackCargoResponsavel, 'minimo', 0);

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

    niveisEnsino.on("blur", function () {

        validacaoTamanho(niveisEnsino, feedbackniveisEnsino, 'minimo', 0);

    });

    descricao.on("blur", function () {

        validacaoTamanho(descricao, feedbackDescricao, 'minimo', 0);

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
        alert("E-mail ou CNPJ preenchidos incorretamente.");
    }


    $('#formEtapa1').submit(async function (event) {
        event.preventDefault();

        try {
            let cnpjF = await validacaoCNPJ();
            let emailF = await validacaoEmail()

            if (cnpjF && validacaoTamanho(nomeEscola, feedbackNomeEscola, 'minimo', 0) && validacaoTamanho(telefone, feedbackTelefone, 'igual', 14) && emailF) {
                this.submit(); // Envio do formulário
            } else {
                console.log('Campos não preenchidos corretamente');
            }
        } catch (error) {
            console.log('Erro na validação do CNPJ:', error);
        }
    });

    $('#formEtapa2').submit(function (event) {
        // Evita o envio padrão do formulário
        event.preventDefault();

        // Realiza a validação do campo antes do envio
        if (validacaoTamanho(nomeResponsavel, feedbackNomeResponsavel, 'minimo', 0) && validacaoTamanho(cargoResponsavel, feedbackCargoResponsavel, 'minimo', 0) && validacaoTamanho(telefoneResponsavel, feedbackTelefoneResponsavel, 'igual', 14) && validacaoEmailResponsavel()) {
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
        if (validacaoTamanho(cep, feedbackCep, 'igual', 9) && validacaoTamanho(pais, feedbackPais, 'minimo', 0) && validacaoTamanho(cidade, feedbackCidade, 'minimo', 0) && validacaoSelect(estado, feedbackEstado) && validacaoTamanho(endereco, feedbackEndereco, 'minimo', 0) && validacaoTamanho(bairro, feedbackBairro, 'minimo', 0) && validacaoTamanho(numero, feedbackNumero, 'minimo', 0)) {
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
        if (validacaoTamanho(niveisEnsino, feedbackniveisEnsino, 'minimo', 0) && validacaoTamanho(descricao, feedbackDescricao, 'minimo', 0)) {
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
