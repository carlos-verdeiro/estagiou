$(document).ready(function () {
    const main = $('#principal');
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');
    let contratos = [];

    function formatarData(data) {
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
                    data.contratos.forEach((estagiario, index) => {
                        estagiariosContainer.append(`
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${estagiario.nome_estagiario} ${estagiario.sobrenome_estagiario}</h5>
                                    <p class="card-text"><strong>Vaga:</strong> ${estagiario.titulo_vaga}</p>
                                    <p class="card-text"><strong>Data de Contratação:</strong> ${formatarData(estagiario.data_contratacao)}</p>
                                    <p class="card-text"><strong>Contato:</strong> ${estagiario.email_estagiario}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-primary btn-sm btnEditarContrato" value="${index}">Editar</button>
                                    <button class="btn btn-secondary btn-sm btnVerContrato" value="${index}">Ver Contrato</button>
                                </div>
                            </div>
                        </div>

                        `);
                    });
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
        $('#modalEstagiarioFimContrato').text(formatarData(contrato.data_termino));
        $('#modalEstagiarioObservacoes').text(contrato.observacoes || 'Nenhuma observação');
        $('#btnEditarContratoModalView').val(index);
        if (contrato.caminho_anexo !== null) {
            $('#modalEstagiarioContratoGeral').show();
            $('#modalEstagiarioContrato').attr('src', '../server/contratos/' + contrato.caminho_anexo);
        } else {
            $('#modalEstagiarioContratoGeral').hide();
            $('#modalEstagiarioContrato').attr('src', mull);
        }


        $('#modalContrato').modal('show');
    });

    $(document).on('click', '.btnEditarContrato', function () {
        let index = $(this).val();
        let contrato = contratos[index];
        console.table(contrato);
        $('#modalContratoTitulo').text(contrato.nome_estagiario);
        $('#modalEstagiarioNome').text(contrato.nome_estagiario + ' ' + contrato.sobrenome_estagiario);
        $('#modalEstagiarioVaga').text(contrato.titulo_vaga);
        $('#modalEstagiarioCelular').text(contrato.celular_estagiario.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4'));
        $('#modalEstagiarioEmail').text(contrato.email_estagiario);
        $('#modalEstagiarioDataContratacao').text(formatarData(contrato.data_contratacao));
        $('#modalEstagiarioFimContrato').text(formatarData(contrato.data_termino));
        $('#modalEstagiarioObservacoes').text(contrato.observacoes || 'Nenhuma observação');
        $('#btnEditarContratoModalView').val(index);
        if (contrato.caminho_anexo !== null) {
            $('#modalEstagiarioContratoGeral').show();
            $('#modalEstagiarioContrato').attr('src', '../server/contratos/' + contrato.caminho_anexo);
        } else {
            $('#modalEstagiarioContratoGeral').hide();
            $('#modalEstagiarioContrato').attr('src', mull);
        }


        $('#modalContrato').modal('show');
    });
});
