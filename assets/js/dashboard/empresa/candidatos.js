$(document).ready(function () {
    const section = $('#sectionPageVagas');
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

    function puxarCandidatos() {
        $.getJSON('../../server/api/candidatos/candMostrar.php/selecionados')
            .done(function (data) {
                section.empty();
                if (data.length === 0) {
                    section.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    data.forEach((vaga, index) => {
                        section.append(`
                        <div class="vaga mb-5">
                            <h3 class="mb-3 tituloCardCandidato">${vaga.titulo}</h3>
                            <div class="row candidatosCardCandidato">
                        `);

                        vaga.candidatos.forEach((candidato, index) => {
                            section.append(`
                                <div class="col-sm-12 col-md-6 col-lg-4 mb-4 paiCard">
                                    <div class="card h-100">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title tituloCardCandidato">${candidato.nome}</h5>
                                            <p class="card-text CursoCardCandidato"><strong>Curso:</strong> ${candidato.formacao}</p>
                                            <p class="card-text EmailCardCandidato"><strong>Email:</strong> <span class="user-select-all">${candidato.email}</span></p>
                                            <p class="card-text CelularCardCandidato"><strong>Celular:</strong> <span class="user-select-all">${candidato.celular}</span></p>
                                            <div class="mt-auto">
                                            <div class="d-flex justify-content-between">
                                                <div class="dropdown-center w-100">
                                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Opções
                                                    </button>
                                                    <ul class="dropdown-menu w-100">
                                                        <li><button class="dropdown-item" type="button">Contratar</button></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><button class="dropdown-item" type="button">Ver Currículo</button></li>
                                                        <li><button class="dropdown-item" type="button">Enviar Mensagem</button></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><button class="dropdown-item" type="button">Remover</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                        section.append(`
                                </div>
                            </div>
                        </div>
                        `);
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus} (Código: ${jqXHR.status})`);
                toastInformacao.show();
            });
    }

    puxarCandidatos();
});
