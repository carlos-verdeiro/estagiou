$(document).ready(function () {

    let vagasJson = null;
    const blocosVagas = $('.blocosVagas');
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

    // MODAL
    const tituloModal = $('#tituloVaga');
    const descricaoModal = $('#descricaoVaga');
    const requisitosModal = $('#requisitosVaga');
    const encerramentoModal = $('#dataEncerramentoVaga');
    const checkEncerramentoModal = $('#encerraCheckVaga');

    // MODAL EDITAR
    const tituloEditarModal = $('#tituloEditarVaga');
    const descricaoEditarModal = $('#descricaoEditarVaga');
    const requisitosEditarModal = $('#requisitosEditarVaga');
    const encerramentoEditarModal = $('#dataEncerramentoEditarVaga');
    const checkEncerramentoEditarModal = $('#encerraCheckEditarVaga');
    const idVagaEditar = $('#idVagaEditar');

    // MODAL EXCLUIR
    const btnModalExcluir = $('#btnModalExcluir');

    function formatarData(data) {
        // Verifica se a data é válida
        if (!data) return 'Não programado';

        // Dividir a data e hora
        const partes = data.split(' ');
        const [ano, mes, dia] = partes[0].split('-');
        const hora = partes[1].substring(0, 5);

        // Formatar a data como DD/MM/AAAA
        return `${dia}/${mes}/${ano} ${hora}`;
    }

    function puxarVagas() {
        $.getJSON('../../server/api/vagas/mostrarVaga.php/empresaVagas')
            .done(function (data) {
                vagasJson = data;
                console.log(vagasJson);
                blocosVagas.empty();
                if (data.length === 0) {
                    blocosVagas.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    data.forEach((vaga, index) => {
                        const dataEncerramento = vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado';
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
                                    <p class="card-text">${dataEncerramento}</p>
                                    <h6>Publicado:</h6>
                                    <p class="card-text">${formatarData(vaga.data_publicacao)}</p>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary sm btnVizualizar" value="${index}">Vizualizar</button>
                                    <button type="button" class="btn btn-warning sm btnEditar" value="${index}">Editar</button>
                                    <button type="button" class="btn btn-danger sm btnEncerrar" value="${index}" data-bs-toggle="modal" data-bs-target="#modalEncerrar">Encerrar</button>
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

    // Inicializa as vagas
    puxarVagas();

    $('#formCadastroVaga').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        const formData = new FormData(this);

        $.ajax({
            url: '../server/api/vagas/criarVaga.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function () {
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
                $("#overlay").hide();
            }
        });
    });

    $('#formAtualizarVaga').submit(function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        const formData = new FormData(this);

        $.ajax({
            url: '../server/api/vagas/updateVaga.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function () {
                puxarVagas();
                $('#modalEditarVaga').modal('hide');
                limparModalEditarVaga();
                corpoToastInformacao.text('Vaga editada com sucesso');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Falha ao editar vaga');
                toastInformacao.show();
            },
            complete: function () {
                $("#overlay").hide();
            }
        });
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

    blocosVagas.on('click', '.btnEditar', function () {
        const vagaEditar = vagasJson[$(this).val()];
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
        const vagaEncerrar = idVagaEditar.val();

        $.ajax({
            url: `../server/api/vagas/deletarVaga.php/${vagaEncerrar}`,
            type: 'GET',
            success: function (data) {
                puxarVagas();
                corpoToastInformacao.text(data === 'Deletado' ? 'Vaga deletada com sucesso' : 'Erro ao deletar a vaga');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Erro ao deletar a vaga');
                toastInformacao.show();
                puxarVagas();
            }
        });
    });

});
