$(document).ready(function () {
    let perfilData;
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    const senha = $("#nova_senha");
    const confirmacaoSenha = $("#confirma_senha");

    const feedbackSenha = $("#feedback-senha");
    const feedbackConfirmacaoSenha = $("#feedback-confirmacaoSenha");


    //Bloqueia colagem na senha
    senha.bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    //Bloqueia colagem na confirmação de senha
    confirmacaoSenha.bind('cut copy paste', function (e) {
        e.preventDefault();
    });


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

    senha.on("blur change input", function () {
        validacaoSenha();
    });

    confirmacaoSenha.on("blur change input", function () {
        validacaoConfirmacaoSenha();
    });


    function preencherCampos(data) {
        $.each(data, function (key, value) {
            $("#" + key).val(value);
        });
        aplicarMascaras();
    }

    function aplicarMascaras() {
        $('#cnpj').mask('00.000.000/0000-00', { reverse: false });
        $('#telefone').mask('(00) 0000-0000', { reverse: false });
        $('#telefone_responsavel').mask('(00) 0000-0000', { reverse: false });
    }

    function puxarDados() {
        $.getJSON("../server/api/empresa/mostrarEmpresa.php/empresa")
            .done(function (data) {
                perfilData = data[0];
                console.log(perfilData);
                preencherCampos(perfilData);
                ['#formDadosPessoais', '#formContato', '#formEndereco', '#formResponsavel'].forEach(compararCampos);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Error fetching data: " + textStatus, errorThrown);
            });
    }

    puxarDados();

    function habilitarCampos(formulario) {
        $(formulario).find("input, select").not("#cnpj").not("#email").prop("disabled", false);
    }

    function desabilitarCampos(formulario) {
        $(formulario).find("input, select").prop("disabled", true);
    }

    function compararCampos(formulario) {
        $(formulario).find("input, select").not("#cnpj").not("#email").each(function () {
            const campoId = $(this).attr('id');
            const valorOriginal = perfilData[campoId];
            const valorAtual = $(this).val();

            let valorOriginalLimpo = valorOriginal ? valorOriginal : "";
            let valorAtualLimpo = valorAtual ? valorAtual : "";

            if (campoId === 'telefone' || campoId === 'telefone_responsavel') {
                valorOriginalLimpo = valorOriginalLimpo.replace(/\D/g, '');
                valorAtualLimpo = valorAtualLimpo.replace(/\D/g, '');
            }

            if (valorAtualLimpo !== valorOriginalLimpo) {
                $(this).addClass('bg-warning-subtle');
            } else {
                $(this).removeClass('bg-warning-subtle');
            }
        });
    }

    $("input, select").not("#senha_atual").not("#nova_senha").not("#confirma_senha").on("change input", function () {
        const formulario = $(this).closest("form").attr("id");
        compararCampos("#" + formulario);
    });

    function limparDados(dados) {
        return dados.replace(/\D/g, '');
    }

    function salvarDados(formulario) {
        $('#cnpj').val(limparDados($('#cnpj').val()));
        $('#telefone').val(limparDados($('#telefone').val()));
        $('#telefone_responsavel').val(limparDados($('#telefone_responsavel').val()));

        const dados = $(formulario).serialize();
        $.post("../server/api/empresa/updateEmpresa.php", dados + "&formulario_id=" + formulario)
            .done(function (response) {
                console.log(response);
                corpoToastInformacao.text(response.mensagem);
                toastInformacao.show();
                puxarDados();
                desabilitarCampos(formulario);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Erro ao salvar dados: " + textStatus, errorThrown);
                corpoToastInformacao.text("Erro ao salvar dados, tente novamente mais tarde");
                toastInformacao.show();
            });
    }

    function gerenciarCliqueBotao(formulario, editarBotao) {
        if (editarBotao.text() === "Salvar") {
            salvarDados(formulario);
            editarBotao.text("Editar");
        } else {
            habilitarCampos(formulario);
            editarBotao.text("Salvar");
        }
    }

    $("#formDadosPessoais .btn-light").click(function () {
        gerenciarCliqueBotao("#formDadosPessoais", $(this));
    });

    $("#formContato .btn-light").click(function () {
        gerenciarCliqueBotao("#formContato", $(this));
    });

    $("#formEndereco .btn-light").click(function () {
        gerenciarCliqueBotao("#formEndereco", $(this));
    });

    $("#formResponsavel .btn-light").click(function () {
        gerenciarCliqueBotao("#formResponsavel", $(this));
    });


    $("#formTrocaSenha").on('submit', function (e) {
        e.preventDefault();
        const formulario = "#formTrocaSenha";
        if (validacaoSenha() && validacaoConfirmacaoSenha()) {
            const dados = $(formulario).serialize();
            $.post("../server/api/empresa/updateEmpresa.php", dados + "&formulario_id=" + formulario)
                .done(function (response) {
                    $(formulario).get(0).reset();
                    senha.removeClass('is-invalid');
                    senha.removeClass('is-valid');
                    confirmacaoSenha.removeClass('is-invalid');
                    confirmacaoSenha.removeClass('is-valid');
                    corpoToastInformacao.text(response.mensagem);
                    toastInformacao.show();
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.error("Erro ao salvar dados: " + textStatus, errorThrown);
                });

        } else {
            corpoToastInformacao.text("Campos não preenchidos corretamente");
            toastInformacao.show();
            console.log('Campos não preenchidos corretamente');
        }

    });

});
