$(document).ready(function () {
    var perfilData;
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    function preencherCampos(data) {
        $.each(data, function (key, value) {
            $("#" + key).val(value);
        });
        aplicarMascaras();
    }

    function aplicarMascaras() {
        $('#cpf').mask('000.000.000-00', { reverse: false });
        $('#rg').mask('00.000.000.0', { reverse: false });
        $('#celular').mask('(00) 00000-0000', { reverse: false });
        $('#telefone').mask('(00) 0000-0000', { reverse: false });
    }

    function puxarDados() {
        $.getJSON("../server/api/estagiarios/mostrarEstagiarios.php/estagiario")
            .done(function (data) {
                perfilData = data[0];
                console.log(perfilData);
                preencherCampos(perfilData);
                compararCampos("#formDadosPessoais");
                compararCampos("#formContato");
                compararCampos("#formEndereco");
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Error fetching data: " + textStatus, errorThrown);
            });
    }

    puxarDados();

    function habilitarCampos(formulario) {
        $(formulario).find("input, select").not("#cpf").not("#rg").not("#data_nascimento").not("#email").prop("disabled", false);
    }

    function desabilitarCampos(formulario) {
        $(formulario).find("input, select").prop("disabled", true);
    }

    function compararCampos(formulario) {
        $(formulario).find("input, select").not("#cpf").not("#rg").not("#data_nascimento").each(function () {
            const campoId = $(this).attr('id');
            const valorOriginal = perfilData[campoId];
            const valorAtual = $(this).val();

            let valorOriginalLimpo = valorOriginal ? valorOriginal : "";
            let valorAtualLimpo = valorAtual ? valorAtual : "";

            if (campoId === 'celular' || campoId === 'telefone') {
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

    $("input, select").on("change input", function () {
        const formulario = $(this).closest("form").attr("id");
        compararCampos("#" + formulario);
    });

    function limparDados(dados) {
        return dados.replace(/\D/g, '');
    }

    function salvarDados(formulario) {
        $('#cpf').val(limparDados($('#cpf').val()));
        $('#rg').val(limparDados($('#rg').val()));
        $('#celular').val(limparDados($('#celular').val()));
        $('#telefone').val(limparDados($('#telefone').val()));

        const dados = $(formulario).serialize();
        $.post("../server/api/estagiarios/updateEstagiario.php", dados + "&formulario_id=" + formulario)
            .done(function (response) {
                corpoToastInformacao.text(response.mensagem);
                toastInformacao.show();
                puxarDados();
                desabilitarCampos(formulario);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Erro ao salvar dados: " + textStatus, errorThrown);
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
});
