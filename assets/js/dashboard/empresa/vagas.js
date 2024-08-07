$(document).ready(function () {

    var vagasJson = null;

    const blocosVagas = $('.blocosVagas');

    let data_encerramento = null;

    //MODAL
    const tituloModal = $('#tituloVaga');
    const descricaoModal = $('#descricaoVaga');
    const requisitosModal = $('#requisitosVaga');
    const encerramentoModal = $('#dataEncerramentoVaga');
    const checkEncerramentoModal = $('#encerraCheckVaga');

    //MODAL EDITAR
    const tituloEditarModal = $('#tituloEditarVaga');
    const descricaoEditarModal = $('#descricaoEditarVaga');
    const requisitosEditarModal = $('#requisitosEditarVaga');
    const encerramentoEditarModal = $('#dataEncerramentoEditarVaga');
    const checkEncerramentoEditarModal = $('#encerraCheckEditarVaga');
    const idVagaEditar = $('#idVagaEditar');

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
        $.getJSON('../../server/api/vagas/mostrarVaga.php/empresaVagas', function (data) {
            vagasJson = data;
            console.log(vagasJson);
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
                <p class="card-text">${vaga.requisitos}</p>
                <h6>Encerra:</h6>
                <p>${data_encerramento}</p>

                <button type="button" class="btn btn-primary sm btnVizualizar" value="${index}">Vizualizar</button>
                <button type="button" class="btn btn-warning sm btnEditar" value="${index}">Editar</button>
                <button type="button" class="btn btn-danger sm btnEncerrar" value="${index}">Encerrar</button>
            </div>
            <div class="card-footer">
                Publicado: ${formatarData(vaga.data_publicacao)}</div>
            </div>`);

            });
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert('Erro ao obter os dados: ' + textStatus, errorThrown);
        });
    }

    function limparModalNovaVaga() {
        tituloModal.val('');
        descricaoModal.val('');
        requisitosModal.val('');
        encerramentoModal.val('');
        encerramentoModal.prop('disabled', false);
        checkEncerramentoModal.prop('checked', false);
    }

    function limparModalEditarVaga() {
        tituloEditarModal.val('');
        descricaoEditarModal.val('');
        requisitosEditarModal.val('');
        encerramentoEditarModal.val('');
        encerramentoEditarModal.prop('disabled', false);
        checkEncerramentoEditarModal.prop('checked', false);
    }

    puxarVagas();//Puxa as vagas quando inicia a página

    checkEncerramentoModal.on('click', () => {

        if (encerramentoModal.prop('disabled')) {
            encerramentoModal.prop('disabled', false);
        } else {
            encerramentoModal.prop('disabled', true);
            encerramentoModal.val('');
        }
    });
    checkEncerramentoEditarModal.on('click', () => {

        if (encerramentoEditarModal.prop('disabled')) {
            encerramentoEditarModal.prop('disabled', false);
        } else {
            encerramentoEditarModal.prop('disabled', true);
            encerramentoEditarModal.val('');
        }
    });

    $('#formCadastroVaga').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/vagas/criarVaga.php',
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
                limparModalNovaVaga();

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

    $('#formAtualizarVaga').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/vagas/updateVaga.php',
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
                $('#modalEditarVaga').modal('hide');
                limparModalEditarVaga();

            },
            error: function () {
                alert('Falha ao enviar arquivo, tente novamente mais tarde.');
            },
            complete: function () {
                // Esconde o indicador de carregamento
                $("#overlay").hide();
            }
        });

        return false;
    });

    $('#btnModalCancelarVaga').on('click', limparModalNovaVaga);

    blocosVagas.on('click', '.btnEditar', function () { //adiciona o enventos a todos os .btnEditar do elemento pai sempre existente
        let vagaEditar = vagasJson[$(this).val()];
        limparModalEditarVaga();
        tituloEditarModal.val(vagaEditar.titulo);
        descricaoEditarModal.val(vagaEditar.descricao);
        requisitosEditarModal.val(vagaEditar.requisitos);
        if (vagaEditar.data_encerramento === null) {
            encerramentoEditarModal.val('');
            encerramentoEditarModal.prop('disabled', true);
            checkEncerramentoEditarModal.prop('checked', true);
        } else {
            encerramentoEditarModal.val(vagaEditar.data_encerramento);
            encerramentoEditarModal.prop('disabled', false);
            checkEncerramentoEditarModal.prop('checked', false);
        }
        idVagaEditar.val(vagaEditar.id);


        $("#modalEditarVaga").modal('show');
    });


});