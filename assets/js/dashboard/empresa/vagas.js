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

    //MODAL EXCLUIR
    const btnModalExcluir = $('#btnModalExcluir');

    //TOAST
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

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

                blocosVagas.append(`
            <div class="card px-0" style="width: 18rem;">
                <div class="card-header">
                    <h5 class="card-title m-0">${vaga.titulo}</h5>
                </div>
                <div class="card-body">
                    <h6>Descrição:</h6>
                    <p class="card-text">${vaga.descricao}</p>
                    <h6>Requisitos:</h6>
                    <p class="card-text">${vaga.requisitos}</p>
                    <h6>Encerra:</h6>
                    <p class="card-text">${data_encerramento}</p>
                    <h6>Publicado:</h6>
                    <p class="card-text">${formatarData(vaga.data_publicacao)}</p>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary sm btnVizualizar" value="${index}">Vizualizar</button>
                    <button type="button" class="btn btn-warning sm btnEditar" value="${index}">Editar</button>
                    <button type="button" class="btn btn-danger sm btnEncerrar" value="${index}"  data-bs-toggle="modal" data-bs-target="#modalEncerrar">Encerrar</button>
                </div>
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
                corpoToastInformacao.text('Vaga criada com sucesso');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Falha ao criar vaga');
                toastInformacao.show();
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
                corpoToastInformacao.text('Vaga editada com sucesso');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Falha ao editar a vaga');
                toastInformacao.show();
            },
            complete: function () {
                // Esconde o indicador de carregamento
                $("#overlay").hide();
            }
        });

        return false;
    });


    $('#btnModalCancelarVaga').on('click', limparModalNovaVaga);

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

    blocosVagas.on('click', '.btnEditar', function () { //adiciona o eventos a todos os .btnEditar do elemento pai sempre existente
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

    btnModalExcluir.on('click', () => {
        let vagaEncerrar = idVagaEditar.val();

        $.ajax({
            url: "../server/api/vagas/deletarVaga.php/" + vagaEncerrar,
            type: "GET",
            dataType: "text", // Especifica que a resposta será texto
            success: function (data, textStatus, jqXHR) {
                puxarVagas();
                if (data === 'Deletado') {
                    corpoToastInformacao.text('Vaga deletada com sucesso');
                    toastInformacao.show();
                }else{
                    corpoToastInformacao.text('Erro ao deletar a vaga ERRO:0');
                    toastInformacao.show();
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text('Erro ao deletar a vaga ERRO:1');
                    toastInformacao.show();
                puxarVagas();
            }
        });
    });


});