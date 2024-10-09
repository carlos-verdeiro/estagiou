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

    puxarCandidatos();
});
