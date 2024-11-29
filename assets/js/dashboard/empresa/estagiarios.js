$(document).ready(function () {
    const main = $('#principal');
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');
    let contratos = [];
    let cEncerrados = [];

    function formatarData(data) {
        if (!data) {
            return data; // Return the input as-is if it's null, undefined, or an empty string
        }

        const [dataPart, horaPart] = data.split(' ');
        const [ano, mes, dia] = dataPart.split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function puxarEstagiarios() {
        $.getJSON('../../server/api/estagiarios/mostrarEstagiarios.php/estagiarios')
            .done(function (data) {
                console.log(data.contratos);
                contratos = data.contratos;
                main.empty();
                if (data.contratos.length === 0) {
                    main.append('<h3 class="text-center">Não há estagiários contratados</h3>');
                } else {
                    main.append(`
                        <!--<div class="row mb-4">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="searchInput" placeholder="Buscar estagiário por nome...">
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>-->
                        <div id="estagiariosContainer" class="row"></div>
                    `);

                    const estagiariosContainer = $('#estagiariosContainer');
                    $('#estagiariosEncContainer').empty();
                    data.contratos.forEach((estagiario, index) => {
                        if (estagiario.status === 0) {
                            cEncerrados.push(index);
                            $('#estagiariosEncContainer').append(`
                                <div class="col-12 col-sm-12 col-md-9 col-lg-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">${estagiario.nome_estagiario} ${estagiario.sobrenome_estagiario}</h5>
                                            <p class="card-text"><strong>Vaga:</strong> ${estagiario.titulo_vaga}</p>
                                            <p class="card-text"><strong>Data de Contratação:</strong> ${formatarData(estagiario.data_contratacao)}</p>
                                            <p class="card-text"><strong>Término contrato:</strong> ${formatarData(estagiario.data_termino) || 'Não definido'}</p>
                                            <p class="card-text"><strong>Contato:</strong> ${estagiario.email_estagiario}</p>
                                        </div>
                                    </div>
                                </div>
                             `);
                        } else {
                            estagiariosContainer.append(`
                                <div class="col-12 col-sm-12 col-md-9 col-lg-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">${estagiario.nome_estagiario} ${estagiario.sobrenome_estagiario}</h5>
                                            <p class="card-text"><strong>Vaga:</strong> ${estagiario.titulo_vaga}</p>
                                            <p class="card-text"><strong>Data de Contratação:</strong> ${formatarData(estagiario.data_contratacao)}</p>
                                            <p class="card-text"><strong>Contato:</strong> ${estagiario.email_estagiario}</p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <button class="btn btn-primary btn-sm btnEditarContrato" value="${index}">Editar</button>
                                            <button class="btn btn-secondary btn-sm btnVerContrato" value="${index}">Ver Contrato</button>
                                        </div>
                                    </div>
                                </div>
                             `);
                        }

                    });
                    console.log(cEncerrados)

                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error(errorThrown);
            });
    }

    puxarEstagiarios();

    $(document).on('click', '.btnVerContrato', function () {
        let index = $(this).val();
        let contrato = contratos[index];
        console.table(contrato);
        $('#modalContratoTitulo').text(contrato.nome_estagiario);
        $('#modalEstagiarioNome').text(contrato.nome_estagiario + ' ' + contrato.sobrenome_estagiario);
        $('#modalEstagiarioVaga').text(contrato.titulo_vaga);
        $('#modalEstagiarioCelular').text(contrato.celular_estagiario.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4'));
        $('#modalEstagiarioEmail').text(contrato.email_estagiario);
        $('#modalEstagiarioDataContratacao').text(formatarData(contrato.data_contratacao));
        $('#modalEstagiarioFimContrato').text(formatarData(contrato.data_termino) || 'Não definido');
        $('#modalEstagiarioObservacoes').text(contrato.observacoes || 'Nenhuma observação');
        $('#btnEditarContratoModalView').val(index);

        if (contrato.caminho_anexo !== null) {
            $('#modalEstagiarioContratoGeral').show();
            $('#modalEstagiarioContrato').attr('src', '../server/contratos/' + contrato.caminho_anexo);
        } else {
            $('#modalEstagiarioContratoGeral').hide();
            $('#modalEstagiarioContrato').removeAttr('src');
        }


        $('#modalContrato').modal('show');
    });

    $(document).on('click', '.btnEditarContrato', function () {
        let index = $(this).val();
        let contrato = contratos[index];
        console.table(contrato);
        $('#idContrato').val(contrato.id_contrato);
        $('#modalNomeEditar').text(contrato.nome_estagiario + ' ' + contrato.sobrenome_estagiario);
        $('#modalVagaEditar').text(contrato.titulo_vaga);
        $('#modalDataContratacaoEditar').text(formatarData(contrato.data_contratacao));
        $('#modalFimContratoEditar').val(contrato.data_termino);
        $('#modalObservacoesEditar').text(contrato.observacoes || 'Nenhuma observação');
        $('#anexoEditarContrato').val('');
        $('#btnModalEncerrarCont').val(index);
        $('#divAnexo').show();

        if (contrato.caminho_anexo !== null && contrato.caminho_anexo !== '') {
            $('#iconFile').removeClass('text-danger');
            $('#iconFile').addClass('text-success');
            $('#divRmAnexo').show();
            $('#rmAnexo').prop('checked', false);
            $('#labelAttAnexo').text('Atualizar anexo:');
        } else {
            $('#iconFile').removeClass('text-success');
            $('#iconFile').addClass('text-danger');
            $('#divRmAnexo').hide();
            $('#rmAnexo').prop('checked', false);
            $('#labelAttAnexo').text('Novo anexo:');
        }

        $('#modalContrato').modal('hide');
        $('#modalEditarContrato').modal('show');
    });

    $('#rmAnexo').on('click', () => {
        if ($('#rmAnexo').prop('checked')) {
            $('#anexoEditarContrato').val('');
            $('#divAnexo').hide();
        } else {
            $('#divAnexo').show();
        }
    });

    $("#formAtualizarContrato").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData($(this)[0]);
        console.log(formData);
        $.ajax({
            url: '../server/api/candidatos/contratarCandidato.php/editar',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (response) {
                puxarEstagiarios();
                console.log(response);
                corpoToastInformacao.text(response);
                toastInformacao.show();
                $('#modalEditarContrato').modal('hide');
            },
            error: function (response) {
                console.log(response);
                corpoToastInformacao.text('Erro ao enviar arquivo.');
                toastInformacao.show();
            },
            complete: function () {
                $("#overlay").hide();
            }
        });
    });

    $('#btnModalEncerrarCont').on('click', function () {
        $('#btnModalEncerrar').val($(this).val());
        $('#formAtualizarContrato').modal('hide');
        $('#modalEncerrar').modal('show');
    })

    $('#btnModalEncerrar').on('click', function () {
        let idCont = contratos[$(this).val()].id_contrato;

        $.ajax({
            url: `../server/api/candidatos/contratarCandidato.php/encerrar`,
            type: 'POST',
            data: { idContrato: idCont },
            success: function (data) {
                puxarEstagiarios();
                console.log(data);
                corpoToastInformacao.text(data);
                toastInformacao.show();
            },
            error: function (xhr, status, error) {
                console.log(`Erro: ${xhr.responseText} | Status: ${status} | Detalhe: ${error}`);
                corpoToastInformacao.text('Erro ao encerrar contrato');
                toastInformacao.show();
                puxarEstagiarios();
            }
        });
    });

    $('#contEncerrados').on('click',function(){
        if ($('#registrosContEncerrados').val() == 0) {
            $('#registrosContEncerrados').show();
            $('#registrosContEncerrados').val(1);
        } else {
            $('#registrosContEncerrados').hide();
            $('#registrosContEncerrados').val(0);
        }
    })

});
