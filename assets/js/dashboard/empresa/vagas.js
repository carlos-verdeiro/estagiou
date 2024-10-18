$(document).ready(function () {

    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    let vagasJson = null;
    let limiteCand = 50;
    let vagaAtual = null;
    let paginaAtual = 1;


    let vagaAcessada = null;

    const blocosVagas = $('.blocosVagas');


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

    // MODAL VAGA
    let modalVaga = $('#modalVaga');

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
                                    <h6>Candidatos:</h6>
                                    <p class="card-text">${vaga.total_candidatos}</p>
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

    function paginacao(totalRegistros) {
        const paginas = Math.ceil(totalRegistros / limiteCand);
        if (paginas > 1) {
            $('.pgNumeros').empty();
            for (let i = 1; i <= paginas; i++) {
                const activeClass = i === 1 ? 'active' : '';
                $('.pgNumeros').append(
                    `<li class="pgNum" value="${i}">
                        <button class="page-link pgNumBTN ${activeClass}" id="pgNum${i}" value="${i}">${i}</button>
                    </li>`
                );
            }
            $('.pgVoltar').toggleClass('disabled', true);
        } else {
            $('.navPaginacao').addClass('invisible');
        }
    }

    function ativaBtnAvanco(pagina) {
        $('.pgVoltar, .pgAvancar').removeClass('disabled');
        if (pagina === 1) {
            $('.pgVoltar').addClass('disabled');
        }
        if (pagina === Math.ceil(totalRegistros / limiteCand)) {
            $('.pgAvancar').addClass('disabled');
        }

        // Atualiza o estado do botão "active"
        $('.pgNumBTN').removeClass('active');
        $(`#pgNum${pagina}`).addClass('active');
    }

    function puxarCandidatos(vaga, index, inicio) {
        $.getJSON(`../../server/api/candidatos/candMostrar.php/vaga/${vaga.id}/${inicio}`)
            .done(function (data) {
                candidatosJson = data.vagas || [];
                totalRegistros = data.total_registros || 0;
                vaga = data.id || null;
                vagaAcessada = vagasJson[index].id;
                //console.log(`Total de registros: ${totalRegistros}`, vaga, candidatosJson);
                listaCandidatos = $('#listaCandidatos');
                if (inicio === 0) {
                    paginacao(totalRegistros);
                }

                listaCandidatos.empty();
                if (candidatosJson.length === 0) {
                    listaCandidatos.html('<h5 class="text-center">Não há candidatos</h5>');
                } else {
                    candidatosJson.forEach((candidato, index) => {
                        let selecionado = candidato.status_candidatura == 2 ? 'statusSelecionado' : '';
                        listaCandidatos.append(`
                            <button class=" ${selecionado} list-group-item btnVaga list-group-item-action p-3" id="btnCandidatura${candidato.id_candidatura}"  data-bs-target="#modalCandidato" data-bs-toggle="modal" value="${candidato.id_candidatura}">
                                <div class="d-flex w-100 justify-content-around">
                                    <h5 class="mb-1">${candidato.nome} ${candidato.sobrenome}</h5>
                                </div>  
                            </button>
                        `);

                    });
                    if (listaCandidatos.children().length === 0) {
                        listaCandidatos.html('<h5 class="text-center">Não há candidatos</h5>');
                    }
                }
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });
    }

    function vagaModalVizualizar(vaga, index) {
        puxarCandidatos(vaga, index, 0)
        $('#tituloVagaModal').text(vaga.titulo);
        vagaAtual = vaga;
        paginaAtual = 1;
        modalVaga.modal('show');
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
                corpoToastInformacao.text(data);
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Erro ao deletar a vaga');
                toastInformacao.show();
                puxarVagas();
            }
        });
    });

    $('#teste').on('click', () => {
        modalVaga.modal('hide');
        $('#modalCandidato').modal('show');
    });

    $('.blocosVagas').on('click', '.btnVizualizar', function () {
        const vagaVizualizar = vagasJson[$(this).val()];
        vagaModalVizualizar(vagaVizualizar, $(this).val());
    });

    $('#listaCandidatos').on('click', '.btnVaga', function () {
        let valor = $(this).val();
        $.getJSON(`../../server/api/candidatos/candMostrar.php/candidato/${$(this).val()}`)
            .done(function (data) {
                console.log(data);
                function modCand(type, campo, val) {
                    $(campo).removeClass('placeholder');
                    $(campo).removeClass('visually-hidden');

                    switch (type) {
                        case 1:
                            $(campo).text(val);
                            break;
                        case 2://niveis proeficiencia
                            if (val == 1) {
                                $(campo + 'Nivel').removeClass('visually-hidden');
                                $(campo).text('Básico');
                            } else if (val == 2) {
                                $(campo + 'Nivel').removeClass('visually-hidden');
                                $(campo).text('Intermediário');
                            } else if (val == 3) {
                                $(campo + 'Nivel').removeClass('visually-hidden');
                                $(campo).text('Avançado');
                            } else {
                                $(campo + 'Nivel').addClass('visually-hidden');
                                $(campo).text('');
                            }
                            break;
                        case 3://opcionais
                            if (val != null && val != '') {
                                $(campo + 'Geral').removeClass('visually-hidden');
                                // Substitui quebras de linha por <br>
                                $(campo).html(val.replace(/\n/g, '<br>'));
                            } else {
                                $(campo + 'Geral').addClass('visually-hidden');
                                $(campo).html('');
                            }
                            break;
                        case 4://disponibilidade
                            if (val != null && val != '') {
                                $(campo + 'Geral').removeClass('visually-hidden');

                                // Substitui "Meio" por "Meio Período" e as barras por quebras de linha <br>, capitalizando a primeira letra de cada segmento
                                const formatado = val.split('/').map(function (linha) {
                                    linha = linha.toLowerCase() === 'meio' ? 'Meio Período' : linha;
                                    return linha.charAt(0).toUpperCase() + linha.slice(1);
                                }).join('<br>');

                                $(campo).html(formatado);
                            } else {
                                $(campo + 'Geral').addClass('visually-hidden');
                                $(campo).html('');
                            }
                            break;

                        case 5://curriculo
                            if (val != null && val != '') {
                                $(campo + 'Geral').removeClass('visually-hidden');
                                $(campo).attr('src', `../server/curriculos/${val}`);
                            } else {
                                $(campo + 'Geral').addClass('visually-hidden');
                            }
                            break;

                        case 6://id
                            $(campo).val(val);
                            break;

                        default:
                            $(campo).addClass('placeholder');
                            $(campo).text('');
                            break;
                    }
                }

                modCand(1, '#modalCandidatoTitulo', data.nome);
                modCand(1, '#modalCandidatoNome', data.nome + ' ' + data.sobrenome);
                let celular = data.celular.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4'); // Aplica a máscara
                modCand(1, '#modalCandidatoCelular', celular);

                modCand(1, '#modalCandidatoEmail', data.email);

                modCand(2, '#modalCandidatoProIngles', data.proIngles);
                modCand(2, '#modalCandidatoProEspanhol', data.proEspanhol);
                modCand(2, '#modalCandidatoProFrances', data.proFrances);

                if (data.telefone === null || data.telefone === '') {
                    $('#modalCandidatoDivTelefone').addClass('visually-hidden');
                } else {
                    $('#modalCandidatoDivTelefone').removeClass('visually-hidden');
                    let telefone = data.telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3'); // Aplica a máscara
                    modCand(1, '#modalCandidatoTelefone', telefone);
                }

                modCand(3, '#modalCandidatoFormacoes', data.formacoes);
                modCand(3, '#modalCandidatoExperiencias', data.experiencias);
                modCand(3, '#modalCandidatoCertificacoes', data.certificacoes);
                modCand(3, '#modalCandidatoHabilidades', data.habilidades);
                modCand(4, '#modalCandidatoDisponibilidade', data.disponibilidade);
                modCand(5, '#modalCandidatoCurriculo', data.caminho_arquivo);
                modCand(6, '#btnSelecionarCand', valor);

                if ($(`#btnCandidatura${valor}`).hasClass('statusSelecionado')) {
                    $(`#btnSelecionarCand`).removeClass('btn-success');
                    $(`#btnSelecionarCand`).addClass('btn-danger');
                    $(`#btnSelecionarCand`).text('Desselecionar');
                } else {
                    $(`#btnSelecionarCand`).removeClass('btn-danger');
                    $(`#btnSelecionarCand`).addClass('btn-success');
                    $(`#btnSelecionarCand`).text('Selecionar');
                }

                modalVaga.show('hide');
                $('#modalCandidato').modal('show');
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });

    });

    $('#btnModalCancelarVaga').on('click', limparModalNovaVaga);

    //paginação
    $('.pgNumeros').on('click', '.pgNumBTN', function () {
        if (!$(this).hasClass('active')) {
            const novaPagina = parseInt($(this).val(), 10);
            ativaBtnAvanco(novaPagina);
            paginaAtual = novaPagina;
            puxarCandidatos(vagaAtual, 0, limiteCand * (paginaAtual - 1));
            $('#modalVaga').scrollTop(0);
        }
    });

    $('.pgVoltar').click(function () {
        if (paginaAtual > 1) {
            paginaAtual--;
            ativaBtnAvanco(paginaAtual);
            puxarCandidatos(vagaAtual, 0, limiteCand * (paginaAtual - 1));
            $('#modalVaga').scrollTop(0);
        }
    });

    $('.pgAvancar').click(function () {
        if (paginaAtual < Math.ceil(totalRegistros / limiteCand)) {
            paginaAtual++;
            ativaBtnAvanco(paginaAtual);
            puxarCandidatos(vagaAtual, 0, limiteCand * (paginaAtual - 1));
            $('#modalVaga').scrollTop(0);
        }
    });
    //paginação

    $(document).off('click', '#btnSelecionarCand').on('click', '#btnSelecionarCand', function () {
        let candidaturaId = $(this).val(); // Obtém o valor do botão (ID do candidato)

        // Envia o ID para o PHP via requisição POST
        $.post('../../server/api/candidatos/statusCandidato.php/selecionar',
            { idCand: candidaturaId }, // Correção aqui: use um objeto
            function (data, textStatus, jqXHR) {

                if (data.code == 1) {
                    $(`#btnCandidatura${candidaturaId}`).removeClass('statusSelecionado');
                    $(`#btnSelecionarCand`).removeClass('btn-danger');
                    $(`#btnSelecionarCand`).addClass('btn-success');
                    $(`#btnSelecionarCand`).text('Selecionar');
                } else {
                    $(`#btnCandidatura${candidaturaId}`).addClass('statusSelecionado');
                    $(`#btnSelecionarCand`).removeClass('btn-success');
                    $(`#btnSelecionarCand`).addClass('btn-danger');
                    $(`#btnSelecionarCand`).text('Desselecionar');
                }
                console.log(data)
                // Exibe o toast com a mensagem de resposta
                corpoToastInformacao.text(data.message);
                toastInformacao.show();
            },
            "json"
        );
    });



});
