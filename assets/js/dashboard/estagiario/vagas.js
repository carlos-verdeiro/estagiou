$(document).ready(function () {
    const listaVagas = $('#listaVagas');
    const blocoVagas = $('.blocoVagas');
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    // Variáveis globais
    let vagasJson = [];
    let totalRegistros = 0;
    let paginaAtual = 1;

    //Modal vaga
    let modalVaga = $('#modalVaga');


    let vagaContratado =[];

    function formatarData(data) {
        if (!data) return 'Não programado';
        const [ano, mes, dia] = data.split(' ')[0].split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function paginacao(totalRegistros) {
        const paginas = Math.ceil(totalRegistros / 30);
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
        if (pagina === Math.ceil(totalRegistros / 30)) {
            $('.pgAvancar').addClass('disabled');
        }

        // Atualiza o estado do botão "active"
        $('.pgNumBTN').removeClass('active');
        $(`#pgNum${pagina}`).addClass('active');
    }

    function puxarVagas(inicio) {
        $.getJSON(`../../server/api/vagas/mostrarVaga.php/estagiarioVagas/${inicio}`)
            .done(function (data) {
                vagasJson = data.vagas || [];
                totalRegistros = data.total_registros || 0;
                candidaturas = data.candidatura || null;
                console.log(`Total de registros: ${totalRegistros}`, candidaturas, vagasJson);

                if (inicio === 0) {
                    paginacao(totalRegistros);
                }

                listaVagas.empty();
                if (vagasJson.length === 0) {
                    listaVagas.html('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    vagasJson.forEach((vaga, index) => {
                        if (!vaga.candidatou) {
                            const dataEncerramento = vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado';
                            listaVagas.append(`
                            <button class="list-group-item btnVaga list-group-item-action p-3 activate" value="${index}">
                                <div class="d-flex w-100 justify-content-around">
                                    <h5 class="mb-1">${vaga.empresa_nome}</h5>
                                    <h5 class="mb-1">${vaga.titulo}</h5>
                                </div>
                                <p class="mt-1 mb-1">${vaga.descricao}</p>

                                <div class="d-flex w-100 justify-content-around">
                                    <small>Encerramento: ${dataEncerramento}</small>
                                    <small>Publicado: ${formatarData(vaga.data_publicacao)}</small>
                                </div>
                            </button>
                        `);
                        }
                    });
                    if (listaVagas.children().length === 0) {
                        listaVagas.html('<h3 class="text-center">Não há vagas</h3>');
                    }
                }
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });
    }

    function puxarMinhasVagas(inicio) {
        $.getJSON(`../../server/api/vagas/mostrarVaga.php/estagiarioVagasCandidato/${inicio}`)
            .done(function (data) {
                vagasJson = data.vagas || [];
                totalRegistros = data.total_registros || 0;
                candidaturas = data.candidatura || null;
                console.log(`Minhas vagas => Total de registros: ${totalRegistros}`, candidaturas, vagasJson);

                if (inicio === 0) {
                    paginacao(totalRegistros);
                }

                listaVagas.empty();
                if (vagasJson.length === 0) {
                    listaVagas.append('<h3 class="text-center">Não há vagas candidatadas</h3>');
                } else {
                    vagasJson.forEach((vaga, index) => {
                        const dataEncerramento = vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado';
                        listaVagas.append(`
                            <button class="list-group-item btnVaga list-group-item-action p-3 activate" value="${index}">
                                <div class="d-flex w-100 justify-content-around">
                                    <h5 class="mb-1">${vaga.empresa_nome}</h5>
                                    <h5 class="mb-1">${vaga.titulo}</h5>
                                </div>
                                <p class="mt-1 mb-1">${vaga.descricao}</p>

                                <div class="d-flex w-100 justify-content-around">
                                    <small>Encerramento: ${dataEncerramento}</small>
                                    <small>Publicado: ${formatarData(vaga.data_publicacao)}</small>
                                </div>
                            </button>
                        `);
                    });
                }
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });
    }

    function puxarVagaContratado() {
        $.getJSON(`../../server/api/vagas/mostrarVaga.php/estagiarioVagaContratado`)
            .done(function (data) {
                vagaContratado = data.vaga || [];
                console.log(vagaContratado);
                blocoVagas.empty();
                if (vagasJson.length === 0) {
                    listaVagas.append('<h3 class="text-center">Não há vagas candidatadas</h3>');
                } else {
                    vagasJson.forEach((vaga, index) => {
                        listaVagas.append(`
                            foi
                        `);
                    });
                }
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });
    }

    // Inicializa as vagas
    puxarVagas(0);

    function vagaBlocoDetalhe(status, vaga, index) {
        let cardGeral = $('#cardGeralVaga');
        switch (status) {
            case 1://ativa

                $('#blocoTituloVaga').text(vaga.titulo);
                $('#blocoDescricaoVaga').text(vaga.descricao);
                $('#blocoRequisitosVaga').text(vaga.requisitos);
                $('#blocoencerramentoVaga').text(vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado');
                $('#blocoPublicacaoVaga').text(formatarData(vaga.data_publicacao));
                $('.btnVizualizarVaga').val(index);
                $('.inscreverVaga').val(index);

                if (cardGeral.hasClass('d-none')) {
                    cardGeral.removeClass('d-none');
                }
                break;

            default://desativa
                if (!cardGeral.hasClass('d-none')) {
                    cardGeral.addClass('d-none');
                }
                break;
        }
    }

    function vagaModalDetalhe(vaga, index) {

        $('#tituloVagaModal').text(vaga.titulo);
        $('#descricaoVagaModal').text(vaga.descricao);
        $('#requisitosVagaModal').text(vaga.requisitos);
        $('#dataEncerramentoVagaModal').text(vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado');
        $('#dataPublicacaoVagaModal').text(formatarData(vaga.data_publicacao));
        $('.inscreverVaga').val(index);
        if (vaga.candidatou == 0) {
            $('.inscreverVaga').text('Inscrever-se');
            $('.inscreverVaga').removeClass('btn-primary');
            $('.inscreverVaga').removeClass('btn-danger');
            $('.inscreverVaga').addClass('btn-primary');
        } else {
            $('.inscreverVaga').text('Cancelar inscrição');
            $('.inscreverVaga').removeClass('btn-primary');
            $('.inscreverVaga').removeClass('btn-danger');
            $('.inscreverVaga').addClass('btn-danger');
        }
        modalVaga.modal('show');

    }

    //paginação
    $('.pgNumeros').on('click', '.pgNumBTN', function () {
        if (!$(this).hasClass('active')) {
            const novaPagina = parseInt($(this).val(), 10);
            ativaBtnAvanco(novaPagina);
            paginaAtual = novaPagina;
            puxarVagas(30 * (paginaAtual - 1));
            $('#listaVagas').scrollTop(0);
        }
    });

    $('.pgVoltar').click(function () {
        if (paginaAtual > 1) {
            paginaAtual--;
            ativaBtnAvanco(paginaAtual);
            puxarVagas(30 * (paginaAtual - 1));
            $('#listaVagas').scrollTop(0);
        }
    });

    $('.pgAvancar').click(function () {
        if (paginaAtual < Math.ceil(totalRegistros / 30)) {
            paginaAtual++;
            ativaBtnAvanco(paginaAtual);
            puxarVagas(30 * (paginaAtual - 1));
            $('#listaVagas').scrollTop(0);
        }
    });
    //paginação

    //navVagas
    $('.navPage').click(function () {
        if (!$(this).hasClass('active')) {
            vagaBlocoDetalhe();//desaparece datalhes
            if ($(this).attr('id') == 'navPageTodas') {
                $('.navPage').removeClass('active');
                $('#navPageTodas').addClass('active');
                puxarVagas(0);//carrega TODAS as vagas
            } else if ($(this).attr('id') == 'navPageMinhas') {
                $('.navPage').removeClass('active');
                $('#navPageMinhas').addClass('active');
                puxarMinhasVagas(0);//carrega SOMENTE CANDIDATADAS
            } else if ($(this).attr('id') == 'navPageContratado') {
                $('.navPage').removeClass('active');
                $('#navPageContratado').addClass('active');
                puxarVagaContratado(0);//carrega SOMENTE CONTRATADO
            }
        }
    });
    //navVagas


    blocoVagas.on('click', '.btnVaga', function () {
        const vagaVizualizar = vagasJson[$(this).val()];
        vagaBlocoDetalhe(1, vagaVizualizar, $(this).val());
        $('.btnVaga').removeClass('active');
        $(this).addClass('active');
    });


    $('#btnVizualizarVaga').click(function () {
        const vagaVizualizar = vagasJson[$(this).val()];
        vagaModalDetalhe(vagaVizualizar, $(this).val());
    });

    $('#inscreverVagaModal').click(function () {
        const idV = $(this).val()
        const vaga = vagasJson[idV];
        const data = { idVaga: vaga.id };

        $.post(
            "../../server/api/candidatos/candVaga.php",
            data,
            function (response, textStatus, jqXHR) {
                modalVaga.modal('hide');
                corpoToastInformacao.text(response);
                toastInformacao.show();
                if (response == "Inscrição realizada!") {
                    vagasJson[idV].candidatou = 1;
                } else if (response == "Inscrição excluída!") {

                    vagasJson[idV].candidatou = 0;
                }
                console.log(vagasJson);
                if ($('#navPageTodas').hasClass('active')) {
                    puxarVagas(0);
                } else if ($('#navPageMinhas').hasClass('active')) {
                    puxarMinhasVagas(0);
                } else if ($('#navPageContratado').hasClass('active')){
                    puxarVagaContratado(0);
                }
            }
        ).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Erro:', textStatus, errorThrown);
            corpoToastInformacao.text(`Erro ao candidatar-se`);
            toastInformacao.show();
        });
    });

});
