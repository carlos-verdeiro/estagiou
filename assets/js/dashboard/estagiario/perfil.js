$(document).ready(function() {
    // Exemplo de JSON recebido
    const perfilData = {
        nome: "Carlos",
        sobrenome: "Silva",
        estado_civil: "Solteiro",
        cpf: "123.456.789-00",
        rg: "12.345.678-9",
        data_nascimento: "2000-01-01",
        genero: "Masculino",
        nacionalidade: "Brasileiro",
        email: "carlos.silva@email.com",
        celular: "(11) 91234-5678",
        telefone: "(11) 3456-7890",
        endereco: "Rua Exemplo",
        numero: "123",
        complemento: "Apto 101",
        bairro: "Centro",
        cidade: "São Paulo",
        estado: "SP",
        cep: "12345-678",
        pais: "Brasil"
    };

    // Função para preencher os campos com o JSON recebido
    function preencherCampos(data) {
        $.each(data, function(key, value) {
            $("#" + key).val(value);
        });
    }

    // Preenche os campos no carregamento da página
    preencherCampos(perfilData);

    // Função para alternar entre modo de edição e visualização
    $(".card").each(function() {
        const $card = $(this);
        const $button = $card.find("button");
        
        // Armazena os valores originais
        const originalValues = {};
        $card.find("input").each(function() {
            originalValues[$(this).attr('id')] = $(this).val();
        });

        $button.on("click", function() {
            if ($button.text() === "Editar") {
                // Mudar para modo de edição
                $button.text("Salvar");
                $button.removeClass("btn-light");
                $button.addClass("btn-primary");
                $card.find("input").prop("disabled", false);

                // Detectar mudanças nos campos e aplicar estilo de alteração
                $card.find("input").on("input", function() {
                    const fieldId = $(this).attr('id');
                    if ($(this).val() !== originalValues[fieldId]) {
                        $(this).addClass("bg-warning-subtle");
                    } else {
                        $(this).removeClass("bg-warning-subtle");
                    }
                });
            } else {
                // Salvar dados e restaurar configurações iniciais
                $button.text("Editar");
                $button.removeClass("btn-primary");
                $button.addClass("btn-light");

                $card.find("input").prop("disabled", true).removeClass("bg-warning-subtle");

                // Atualiza os valores originais com os novos valores
                $card.find("input").each(function() {
                    const fieldId = $(this).attr('id');
                    originalValues[fieldId] = $(this).val();
                });

                // Exibe um toast de confirmação
                $("#corpoToastInformacao").text("Perfil atualizado com sucesso!");
                const toast = new bootstrap.Toast($("#toastInformacao"));
                toast.show();
            }
        });
    });
});
