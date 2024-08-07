$(document).ready(function () {

    const checkEncerra = $('#encerraCheckVaga');
    const dataEncerramentoVaga = $('#dataEncerramentoVaga');

    const blocosVagas = $('.blocosVagas');

    const btnModalExcluir = $('#btnModalExcluir');

    let data_encerramento = null;

    //MODAL
    const tituloModal = $('#tituloVaga');
    const descricaoModal = $('#descricaoVaga');
    const requisitosModal = $('#requisitosVaga');
    const encerramentoModal = $('#dataEncerramentoVaga');
    const checkEncerramentoModal = $('#encerraCheckVaga');

    function formatarData(data) {
        // Dividir a data em partes
        var partes = data.split(' ');
        var dataParte = partes[0];
        var horaParte = partes[1];

        // Dividir a data em ano, mês e dia
        var dataArray = dataParte.split('-');
        var ano = dataArray[0];
        var mes = dataArray[1];
        var dia = dataArray[2];

        // Formatar a data como DD/MM/AAAA
        var dataFormatada = dia + '/' + mes + '/' + ano;

        // Retornar a data formatada com a hora
        return dataFormatada + ' ' + horaParte.substring(0, 5); // Pega somente HH:MM
    }

    function puxarVagas() {
        $.getJSON('../../server/api/mostrarVaga.php/empresaVagas', function (data) {
            blocosVagas.empty();
            if (data.length == 0) {
                blocosVagas.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
            }
            $.each(data, function (index, vaga) {

                if (vaga.data_encerramento == null || vaga.data_encerramento == '') {
                    data_encerramento = 'Não programado';
                } else {
                    data_encerramento = formatarData(vaga.data_encerramento);
                }

                blocosVagas.append(`<div class="card px-0" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">${vaga.titulo}</h5>
                <hr>
                <h6>Descrição:</h6>
                <p class="card-text">${vaga.descricao}</p>
                <h6>Requisitos:</h6>
                <p>${vaga.requisitos}</p>
                <h6>Encerra:</h6>
                <p>${data_encerramento}</p>

                <button type="button" class="btn btn-primary sm btnVizualizar" data-bs-toggle="modal" data-bs-target="#modalVizualizar">Vizualizar</button>
                <button type="button" class="btn btn-warning sm btnEditar" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                <button type="button" class="btn btn-danger sm btnEncerrar" data-bs-toggle="modal" data-bs-target="#modalEncerrar">Encerrar</button>
            </div>
            <div class="card-footer">
                Publicado: ${formatarData(vaga.data_publicacao)}</div>
            </div>`);

            });
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert('Erro ao obter os dados: ' + textStatus, errorThrown);
        });
    }



    puxarVagas();

    checkEncerra.on('click', () => {

        if (dataEncerramentoVaga.prop('disabled')) {
            dataEncerramentoVaga.prop('disabled', false);
        } else {
            dataEncerramentoVaga.prop('disabled', true);
            dataEncerramentoVaga.val('');
        }
    });

    $('#formCadastroVaga').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/manipularVaga.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Mostra o indicador de carregamento
                $("#overlay").show();
            },
            success: function (response) {
                puxarVagas();
                $('#modalCriarVaga').modal('hide');
                tituloModal.val('');
                descricaoModal.val('');
                requisitosModal.val('');
                encerramentoModal.val('');
                encerramentoModal.prop('disabled', false);
                checkEncerramentoModal.prop('checked', false);

            },
            error: function () {
                alert('Erro ao enviar arquivo.');
            },
            complete: function () {
                // Esconde o indicador de carregamento
                $("#overlay").hide();
            }
        });

        return false;
    });

    $.getJSON("../../server/api/mostrarVaga.php/empresaVagas",
        function (data, textStatus, jqXHR) {
            console.log(data);
        }
    );
});