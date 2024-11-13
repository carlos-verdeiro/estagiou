$(document).ready(function () {

    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');
    let alunosJson;


    //etapa 1
    const cpf = $("#cpf");
    const feedbackCPF = $("#feedback-cpf");
    const nome = $("#nome");
    const feedbackNome = $("#feedback-nome");
    const nomeSocial = $("#nomeSocial");
    const sobrenome = $("#sobrenome");
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
    const complemento = $("#complemento");
    //etapa 5
    const senha = $("#senha");
    const feedbackSenha = $("#feedback-senha");


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


    function calculoCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000" || strCPF == "11111111111" || strCPF == "22222222222" || strCPF == "33333333333" || strCPF == "44444444444" || strCPF == "55555555555" || strCPF == "66666666666" || strCPF == "77777777777" || strCPF == "88888888888" || strCPF == "99999999999") return false;

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




    $('#idiomaIngles').click(function () {
        if (this.checked) {
            $(`#nivelIngles`).val(1).prop('disabled', false);
        } else {
            $(`#nivelIngles`).val(0).prop('disabled', true);
        }
    });

    $('#idiomaEspanhol').click(function () {
        if (this.checked) {
            $(`#nivelEspanhol`).val(1).prop('disabled', false);
        } else {
            $(`#nivelEspanhol`).val(0).prop('disabled', true);
        }
    });

    $('#idiomaFrances').click(function () {
        if (this.checked) {
            $(`#nivelFrances`).val(1).prop('disabled', false);
        } else {
            $(`#nivelFrances`).val(0).prop('disabled', true);
        }
    });


    function salvarDados(formulario) {

        const dados = $(formulario).serialize();
        let caminho = ($('#tipoForm').val() == 'novo') ? "../server/api/escola/cadastrarEstagiario.php" : "../server/api/estagiarios/updateEstagiario.php";
        $.post(caminho, dados)
            .done(function (response) {
                console.log(response);
                corpoToastInformacao.text(($('#tipoForm').val() == 'novo') ? response : response['mensagem']);
                toastInformacao.show();
                $('#alunoModal').modal('hide');
                $('#formAluno')[0].reset();
                $('#formAluno input[type="checkbox"]').attr('checked', false);

                puxarAlunos();
            })
            .fail(function (response) {
                console.error(response.responseText);
                corpoToastInformacao.text("Erro ao salvar dados, tente novamente mais tarde");
                toastInformacao.show();
            });

    }

    function limparForm(){
        cpf.val('');
        nome.val('');
        email.val('');
        sobrenome.val('');
        rg.val('');
        orgaoEmissor.val('');
        estadoEmissor.val('');
        genero.val('');
        estadoCivil.val('');
        nacionalidade.val('');
        celular.val('');
        telefone.val('');
        dataNascimento.val('');
        dependentes.val('');
        cep.val('');
        pais.val('');
        cidade.val('');
        estado.val('');
        endereco.val('');
        bairro.val('');
        numero.val('');
        complemento.val('');
        nomeSocial.val('');
        $(`#idiomaIngles`).prop('checked', false);
        $(`#nivelIngles`).prop('disabled', true);
        $(`#idiomaEspanhol`).prop('checked', false);
        $(`#nivelEspanhol`).prop('disabled', true);
        $(`#idiomaFrances`).prop('checked', false);
        $(`#nivelFrances`).prop('disabled', true);
        $(`#nivelIngles`).val(0);
        $(`#nivelEspanhol`).val(0);
        $(`#nivelFrances`).val(0);
        $('#formAluno input[type="checkbox"], #formAluno input[type="radio"]').prop('checked', false);
        $(`#formacoes`).text('');
        $(`#experiencias`).text('');
        $(`#habilidades`).text('');
        $(`#certificacoes`).text('');
        $('#formAluno')[0].reset();
    }

    $('#btnModalNovoCand').on('click', () => {
        cpf.attr('disabled', false);
        email.attr('disabled', false);
        rg.attr('disabled', false);
        orgaoEmissor.attr('disabled', false);
        estadoEmissor.attr('disabled', false);


        $('#divSenha').show()

        $('#tipoForm').val('novo');
        $('#alunoModalLabel').text('Cadastrar Novo Aluno');
        $('#alunoModal').modal('show');
        limparForm();
        $('#formAluno input[type="checkbox"]').attr('checked', false);
    })

    $('#divCardsAlunos').on('click', '.btnEditarAluno', function () {
        limparForm();
        $('#formAluno input[type="checkbox"]').attr('checked', false);

        let estagiario = alunosJson[$(this).val()];

        cpf.attr('disabled', true);
        email.attr('disabled', true);
        rg.attr('disabled', true);
        orgaoEmissor.attr('disabled', true);
        estadoEmissor.attr('disabled', true);

        $('#divSenha').hide();

        $('#tipoForm').val('edicao');
        $('#alunoModalLabel').text(estagiario.nome);

        $('#id_estagiario').val(estagiario.id);

        cpf.val(estagiario.cpf.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'));
        nome.val(estagiario.nome);
        email.val(estagiario.email);
        sobrenome.val(estagiario.sobrenome);
        rg.val(estagiario.rg.replace(/\D/g, '').replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, '$1.$2.$3-$4'));
        orgaoEmissor.val(estagiario.rg_org_emissor);
        estadoEmissor.val(estagiario.rg_estado_emissor);
        genero.val(estagiario.genero);
        estadoCivil.val(estagiario.estado_civil);
        nacionalidade.val(estagiario.nacionalidade);
        celular.val(estagiario.celular.replace(/\D/g, '').replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3'));
        telefone.val(estagiario.telefone.replace(/\D/g, '').replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3'));
        dataNascimento.val(estagiario.data_nascimento);
        dependentes.val(estagiario.dependentes);
        cep.val(estagiario.cep.replace(/(\d{5})(\d{3})/, '$1-$2'));
        pais.val(estagiario.pais);
        cidade.val(estagiario.cidade);
        estado.val(estagiario.estado);
        endereco.val(estagiario.endereco);
        bairro.val(estagiario.bairro);
        numero.val(estagiario.numero);
        complemento.val(estagiario.complemento);
        nomeSocial.val(estagiario.nome_social);

        var cnh = estagiario.cnh.split('');
        $.each(cnh, function (index, letra) {
            $(`#cnh` + letra).attr('checked', true);
        });
        if (cnh == "N") {
            $(`#cnhSem`).attr('checked', true);
        }

        //1
        $(`#escolaridade${estagiario.escolaridade}`).prop('checked', true);
        $(`#formacoes`).text(estagiario.formacoes);

        //2
        $(`#experiencias`).text(estagiario.experiencias);

        //3
        if (estagiario.proIngles != null && estagiario.proIngles != 0) { // inglês
            $(`#idiomaIngles`).prop('checked', true);
            $(`#nivelIngles`).val(estagiario.proIngles);
            $(`#nivelIngles`).prop('disabled', false);
        } else {
            $(`#idiomaIngles`).prop('checked', false);
            $(`#nivelIngles`).val(0);
            $(`#nivelIngles`).prop('disabled', true);
        }

        if (estagiario.proEspanhol != null && estagiario.proEspanhol != 0) { // espanhol
            $(`#idiomaEspanhol`).prop('checked', true);
            $(`#nivelEspanhol`).val(estagiario.proEspanhol);
            $(`#nivelEspanhol`).prop('disabled', false);
        } else {
            $(`#idiomaEspanhol`).prop('checked', false);
            $(`#nivelEspanhol`).val(0);
            $(`#nivelEspanhol`).prop('disabled', true);
        }

        if (estagiario.proFrances != null && estagiario.proFrances != 0) { // francês
            $(`#idiomaFrances`).prop('checked', true);
            $(`#nivelFrances`).val(estagiario.proFrances);
            $(`#nivelFrances`).prop('disabled', false);
        } else {
            $(`#idiomaFrances`).prop('checked', false);
            $(`#nivelFrances`).val(0);
            $(`#nivelFrances`).prop('disabled', true);
        }

        //4
        $(`#certificacoes`).text(estagiario.certificacoes);

        //5
        $(`#habilidades`).text(estagiario.habilidades);

        //6
        if (estagiario.disponibilidade) {
            let valores = estagiario.disponibilidade.split('/');

            valores.forEach(element => {
                $(`#${element}`).prop('checked', true);
            });
        }


        $('#alunoModal').modal('show');
    });



    $('#formAluno').submit(async function (event) {
        event.preventDefault();

        try {

            let cpaF = ($('#tipoForm').val() == 'novo') ? await validacaoCPF() : true;
            let emailF = ($('#tipoForm').val() == 'novo') ? await validacaoEmail() : true;
            let rg = ($('#tipoForm').val() == 'novo') ? validacaoRG() : true;
            let senha = ($('#tipoForm').val() == 'novo') ? validacaoSenha() : true;

            if (cpaF && validacaoTamanho(nome, feedbackNome, 'minimo', 0) && emailF && rg && validacaoOrgaoEmissor() && validacaoSelect(estadoEmissor, feedbackEstadoEmissor) && validacaoSelect(genero, feedbackGenero) && validacaoSelect(estadoCivil, feedbackEstadoCivil) && validacaoTamanho(dataNascimento, feedbackDataNascimento, 'igual', 10) && validacaoTamanho(nacionalidade, feedbackNacionalidade, 'minimo', 0) && validacaoTamanho(celular, feedbackCelular, 'igual', 15) && validacaoTamanho(cep, feedbackCep, 'igual', 9) && validacaoTamanho(pais, feedbackPais, 'minimo', 0) && validacaoTamanho(cidade, feedbackCidade, 'minimo', 0) && validacaoSelect(estado, feedbackEstado) && validacaoTamanho(endereco, feedbackEndereco, 'minimo', 0) && validacaoTamanho(bairro, feedbackBairro, 'minimo', 0) && validacaoTamanho(numero, feedbackNumero, 'minimo', 0) && senha) {
                salvarDados('#formAluno');
            } else {
                console.log('Campos não preenchidos corretamente');
                alert('Campos não preenchidos corretamente');
            }
        } catch (error) {
            console.log('Erro na validação do CPF ou E-mail:', error);
        }
    });

    const divCardsAlunos = $('#divCardsAlunos');

    function puxarAlunos() {
        $.getJSON('../../server/api/escola/mostrarAlunos.php/alunos')
            .done(function (data) {
                alunosJson = data;
                console.log(alunosJson);
                divCardsAlunos.empty();
                if (data.length === 0) {
                    divCardsAlunos.append('<h3 class="text-center">Não há alunos cadastrados</h3>');
                } else {
                    data.forEach((aluno, index) => {
                        $('#divCardsAlunos').append(`
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1">${aluno.nome}</h5>
                                        <p class="card-text mb-0"><strong>CPF:</strong> ${aluno.cpf}</p>
                                        <p class="card-text"><strong>Email:</strong> ${aluno.email}</p>
                                        <button class="btn btn-outline-secondary btnEditarAluno" value="${index}">
                                            Editar
                                        </button>
                                    </div>
                                </div>
                            </div>`);
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
            });
    }

    puxarAlunos();

});