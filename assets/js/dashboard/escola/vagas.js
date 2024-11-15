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


    let vagaContratado = [];

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
        $.getJSON(`../../server/api/vagas/mostrarVaga.php/escolaVagas/${inicio}`)
            .done(function (data) {
                vagasJson = data.vagas || [];
                totalRegistros = data.total_registros || 0;
                candidaturas = data.candidatura || null;
                console.log(data);

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
            .fail(function (response) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${response}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', response.responseJSON.mensagem);
            });
    }

    function puxarIndicacoes() {
        $.getJSON(`../../server/api/escola/mostrarIndicacoes.php/escola`)
            .done(function (data) {
                console.log(data);

                listaVagas.empty();
                if (vagasJson.length === 0) {
                    listaVagas.html('<h3 class="text-center">Não há indicações feitas</h3>');
                } else {
                    const row = $('<div id="blocosCards" class="row m-0 p-0">');

                    data.forEach((aluno, index) => {
                        const card = `
                            <div class="col-12 col-md-6 col-lg-4 m-0">
                                <div class="card" style="width: 100%;">
                                    <div class="card-header">
                                        <h5 class="card-title">${aluno.nome}</h5>
                                    </div>
                                    <div class="card-body">
                                        <h6>Vaga:</h6>
                                        <p class="card-text">Desenvolvedor de Software</p>
                                        <h6>CPF:</h6>
                                        <p class="card-text">${aluno.cpf}</p> <!-- Exemplo de CPF -->
                                        <h6>E-mail:</h6>
                                        <p class="card-text">${aluno.email}</p> <!-- Exemplo de E-mail -->
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-danger sm btnRmIndicacao" data-idvaga="${aluno.id_vaga}" data-idestagiario="${aluno.id_estagiario}">Remover</button>
                                    </div>
                                </div>
                            </div>
                        `;

                        row.append(card);
                    });

                    listaVagas.append(row);

                    if (listaVagas.children().length === 0) {
                        listaVagas.html('<h3 class="text-center">Não há indicações</h3>');
                    }
                }
            })
            .fail(function (response) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${response}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', response.responseJSON.mensagem);
            });
    }

    function formatarData(data) {
        // Divide a string para pegar apenas a data (YYYY-MM-DD), ignorando o horário, se houver
        const dataSemHora = data.split(' ')[0];
        const [ano, mes, dia] = dataSemHora.split('-');
        return `${dia}/${mes}/${ano}`;
    }


    function formatarTelefone(telefone) {
        return telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    }

    function formatarCEP(cep) {
        return cep.replace(/(\d{5})(\d{3})/, '$1-$2');
    }



    // Inicializa as vagas
    puxarVagas(0);
    puxarAlunos();

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

    function puxarAlunos() {
        $.getJSON('../../server/api/escola/mostrarAlunos.php/alunos')
            .done(function (data) {
                alunosJson = data;
                console.log(alunosJson);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados de alunos: ${textStatus}`);
                toastInformacao.show();
            });
    }

    function vagaModalDetalhe(index) {
        let vaga = vagasJson[index];
        $('#tituloVagaModal').text(vaga.titulo);
        $('#descricaoVagaModal').text(vaga.descricao);
        $('#requisitosVagaModal').text(vaga.requisitos);
        $('#dataEncerramentoVagaModal').text(vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado');
        $('#dataPublicacaoVagaModal').text(formatarData(vaga.data_publicacao));

        let id_candidatado = vaga.candidatos_ids.split('&');
        let id_candidatura = vaga.indicacoes_ids.split('&');
        let cpf_candidatado = vaga.candidatos_cpfs.split('&');
        let email_candidatado = vaga.candidatos_emails.split('&');
        let nome_candidatado = vaga.candidatos_nomes.split('&');
        $('#accordionAlunos').empty();
        alunosJson.forEach((aluno, i) => {
            let candidatado = id_candidatado.find((element) => element == aluno.id);
            $('#accordionAlunos').append(`
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="${candidatado ? 'statusSelecionado' : ''} accordion-button collapsed" id="btnColapsoAluno${aluno.id}" type="button" data-bs-toggle="collapse" data-bs-target="#colapsoAluno${aluno.id}" aria-expanded="false" aria-controls="colapsoAluno${aluno.id}">
                            ${aluno.nome}
                        </button>
                    </h2>
                    <div id="colapsoAluno${aluno.id}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <p><strong>CPF: </strong>${aluno.cpf.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')}</p>
                            <p><strong>E-mail: </strong>${aluno.email}</p>
                            <button type="button" class="btn btn-primary inscreverVaga" id="inscreverVagaModal"  
                                    data-idvaga="${index}" data-idestagiario="${aluno.id}">
                                Inscrever aluno
                            </button>
                        </div>
                    </div>
                </div>
                `);
        });



        modalVaga.modal('show');

    }

    $(document).on('click', '#inscreverVagaModal', function () {
        let indexVaga = $(this).data('idvaga');
        const idV = vagasJson[$(this).data('idvaga')].id;
        const idE = $(this).data('idestagiario');
        const data = { idVaga: idV, idEstagiario: idE };

        $.post(
            "../../server/api/escola/indicarVaga.php",
            data,
            function (response, textStatus, jqXHR) {
                corpoToastInformacao.text(response);
                toastInformacao.show();
                if (response == "Indicação realizada!") {
                    $(`#btnColapsoAluno${idE}`).addClass('statusSelecionado');
                } else if (response == "Indicação excluída!") {
                    $(`#btnColapsoAluno${idE}`).removeClass('statusSelecionado');
                }
            }
        ).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Erro:', textStatus, errorThrown);
            corpoToastInformacao.text(`Erro ao candidatar-se`);
            toastInformacao.show();
        });
        puxarAlunos();
    });

    $(document).on('click', '.btnRmIndicacao', function () {
        const idV = $(this).data('idvaga');
        const idE = $(this).data('idestagiario');
        const data = { idVaga: idV, idEstagiario: idE };

        $.post(
            "../../server/api/escola/indicarVaga.php",
            data,
            function (response, textStatus, jqXHR) {
                console.log(response);
                corpoToastInformacao.text(response);
                toastInformacao.show();
            }
        ).fail(function (jqXHR, textStatus, errorThrown) {
            console.error('Erro:', textStatus, errorThrown);
            corpoToastInformacao.text(`Erro ao candidatar-se`);
            toastInformacao.show();
        });
        puxarIndicacoes();
    });

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
            vagaBlocoDetalhe();
            if ($(this).attr('id') == 'navPageTodas') {
                $('.navPage').removeClass('active');
                $('#navPageTodas').addClass('active');
                puxarVagas(0);
            } else if ($(this).attr('id') == 'navPageIndicacoes') {
                $('.navPage').removeClass('active');
                $('#navPageIndicacoes').addClass('active');
                puxarIndicacoes();
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
        vagaModalDetalhe($(this).val());
    });
});
