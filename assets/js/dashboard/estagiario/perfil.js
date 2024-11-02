$(document).ready(function () {
    var perfilData;
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    function preencherCampos(data) {
        $.each(data, function (key, value) {
            $("#" + key).val(value);
        });
        $('#cpf').mask('000.000.000-00', { reverse: true });
        $('#rg').mask('00.000.000.0', { reverse: true });
        $('#celular').mask('(00) 00000-0000', { reverse: false });
        $('#telefone').mask('(00) 0000-0000', { reverse: false });

    }

    function puxarDados() {
        $.getJSON("../server/api/estagiarios/mostrarEstagiarios.php/estagiario")
            .done(function (data) {
                perfilData = data[0];
                console.log(perfilData);
                preencherCampos(perfilData);
                // Atualiza a comparação dos campos após preencher
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
        $(formulario).find("input, select").prop("disabled", true); // Exclui o campo CPF
    }

    function compararCampos(formulario) {
        $(formulario).find("input, select").not("#cpf").not("#rg").not("#data_nascimento").each(function () {
            const campoId = $(this).attr('id');
            const valorOriginal = perfilData[campoId];
            const valorAtual = $(this).val();
    
            // Inicializa as variáveis de valores limpos
            let valorOriginalLimpo = valorOriginal ? valorOriginal : ""; // Define como string vazia se nulo
            let valorAtualLimpo = valorAtual ? valorAtual : ""; // Define como string vazia se nulo
    
            // Ignorar caracteres especiais no campo celular e telefone
            if (campoId === 'celular' || campoId === 'telefone') {
                valorOriginalLimpo = valorOriginalLimpo.replace(/\D/g, ''); // Remove caracteres não numéricos
                valorAtualLimpo = valorAtualLimpo.replace(/\D/g, ''); // Remove caracteres não numéricos
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

    function salvarDados(formulario) {
        const dados = $(formulario).serialize(); // Coleta todos os dados do formulário
        $.post("../server/api/estagiarios/updateEstagiario.php", dados + "&formulario_id=" + formulario)
            .done(function (response) {
                corpoToastInformacao.text(response.mensagem);
                toastInformacao.show();
                puxarDados(); // Atualiza os dados do perfil
                desabilitarCampos(formulario); // Desabilita os campos após salvar
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Erro ao salvar dados: " + textStatus, errorThrown);
            });
    }

    // Função para gerenciar o clique do botão "Salvar" de forma genérica
    function gerenciarCliqueBotao(formulario, editarBotao) {
        if (editarBotao.text() === "Salvar") {
            salvarDados(formulario); // Chama a função para salvar os dados
            editarBotao.text("Editar"); // Troca o texto do botão para "Editar"
        } else {
            habilitarCampos(formulario);
            editarBotao.text("Salvar"); // Troca o texto do botão para "Salvar"
        }
    }

    // Adiciona o evento de clique ao botão "Salvar" para todos os formulários
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
