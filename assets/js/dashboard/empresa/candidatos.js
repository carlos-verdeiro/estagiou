$(document).ready(function () {
    const section = $('#divVagas');
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

    function puxarCandidatos() {
        $.getJSON('../../server/api/candidatos/candMostrar.php/selecionados')
            .done(function (data) {
                section.empty();

                let vagasComCandidatos = 0; // Contador de vagas com candidatos

                if (data.length === 0) {
                    section.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    data.forEach((vaga) => {
                        if (vaga.candidatos.length > 0) {
                            vagasComCandidatos++; // Incrementa se houver candidatos

                            // Crie uma string para armazenar o HTML da vaga e seus candidatos
                            let vagaHtml = `
                            <div class="vaga mb-5">
                                <h3 class="mb-3 tituloCardCandidato">${vaga.titulo}</h3>
                                <div class="row candidatosCardCandidato">
                            `;

                            vaga.candidatos.forEach((candidato) => {
                                console.log(candidato)

                                vagaHtml += `
                                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title tituloCardCandidato">${candidato.nome} ${candidato.sobrenome}</h5>
                                                <p class="card-text EmailCardCandidato"><strong>Email:</strong> <span class="user-select-all">${candidato.email}</span></p>
                                                <p class="card-text CelularCardCandidato"><strong>Celular:</strong> <span class="user-select-all">${candidato.celular.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4')}</span></p>
                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="dropdown-center w-100">
                                                            <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Opções
                                                            </button>
                                                            <ul class="dropdown-menu w-100">
                                                                <li><button class="dropdown-item btnContratarCand" type="button" value="${candidato.id_candidatura}">Contratar</button></li>
                                                                <li><button class="dropdown-item btnCurriculoCand" type="button" value="${candidato.id_candidatura}">Ver Currículo</button></li>
                                                                <!--<li><button class="dropdown-item" type="button" value="${candidato.id_candidatura}">Enviar Mensagem</button></li>-->
                                                                <li><button class="dropdown-item btnRemoveCand" type="button" value="${candidato.id_candidatura}">Remover</button></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });

                            // Feche as divs da vaga
                            vagaHtml += `
                                </div>
                            </div>
                            `;

                            // Insira todo o HTML da vaga de uma vez
                            section.append(vagaHtml);
                        }
                    });

                    // Se nenhuma vaga tiver candidatos, exibir mensagem de "Não há candidatos selecionados"
                    if (vagasComCandidatos === 0) {
                        section.append('<h3 class="text-center">Não há candidatos selecionados</h3>');
                    }
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus} (Código: ${jqXHR.status})`);
                toastInformacao.show();
            });
    }


    $('#sectionPageVagas').on('click', '.btnCurriculoCand', function () {
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
                $('#modalCandidato').modal('show');
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });

    });

    $('#sectionPageVagas').on('click', '.btnRemoveCand', function () {
        $("#btnModalExcluir").val($(this).val());
        $("#modalExcluir").modal('show');
    });

    $("#btnModalExcluir").on('click', function () {
        let candidaturaId = $(this).val(); // Obtém o valor do botão (ID do candidato)
        $.post('../../server/api/candidatos/statusCandidato.php/selecionar',
            { idCand: candidaturaId },
            function (data, textStatus, jqXHR) {
                puxarCandidatos();
                console.log(data)
                // Exibe o toast com a mensagem de resposta
                corpoToastInformacao.text(data.message);
                toastInformacao.show();
            },
            "json"
        );
    });


    $("#sectionPageVagas").on('click', '.btnContratarCand', function () {
        $("#idCand").val($(this).val());
        $('#fimContra').val('');
        $('#obsContra').text('');
        $('#fileContra').val('');
        $('#modalContrato').modal('show');
    });

    $("#formContratar").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/candidatos/contratarCandidato.php/contratar',
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
                puxarCandidatos(); 
                console.log(response);
                corpoToastInformacao.text(response);
                toastInformacao.show();
                $('#modalContrato').modal('hide'); 
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



    puxarCandidatos();
});
