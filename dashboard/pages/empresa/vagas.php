<section class="sectionPages sectionPagesEmpresa" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/empresa/vagas.css">
    <script src="../assets/js/dashboard/empresa/vagas.js"></script>

    <h1 class="tituloPage mb-2">VAGAS</h1>
    <button type="button" class="btn btn-primary mb-2" id="btnCriarVaga" data-bs-toggle="modal" data-bs-target="#modalCriarVaga">Criar nova vaga</button>

    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <div class="divBlocos row row-cols-2 gap-4 w-100 d-flex justify-content-center blocosVagas">
        <!--VAGAS AQUI-->
    </div>




    <!-- Modal Criar Vaga-->
    <div class="modal fade" id="modalCriarVaga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Criar nova vaga</h1>
                    <button type="button" id="btnFecharModalVaga" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formCadastroVaga">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tituloVaga" class="form-label">Título *</label>
                            <input type="text" class="form-control" id="tituloVaga" maxlength="255" name="tituloVaga" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoVaga" class="form-label">Descrição *</label>
                            <textarea class="form-control" id="descricaoVaga" rows="4" name="descricaoVaga" maxlength="10000" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="requisitosVaga" class="form-label">Requisitos *</label>
                            <textarea class="form-control" id="requisitosVaga" rows="5" name="requisitosVaga" maxlength="10000" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dataEncerramentoVaga" class="form-label">Encerramento das inscrições</label>
                            <input type="datetime-local" class="form-control" id="dataEncerramentoVaga" name="dataEncerramentoVaga" min="<?php echo $now; ?>" required>

                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="encerraCheckVaga" name="encerraCheckVaga">
                                <label class="form-check-label" for="encerraCheckVaga">Não programar encerramento</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnModalCancelarVaga" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Vaga-->
    <div class="modal fade" id="modalEditarVaga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar vaga</h1>
                    <button type="button" id="btnFecharModalVaga" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formAtualizarVaga">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tituloEditarVaga" class="form-label">Título *</label>
                            <input type="text" class="form-control" id="tituloEditarVaga" maxlength="255" name="tituloEditarVaga" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricaoEditarVaga" class="form-label">Descrição *</label>
                            <textarea class="form-control" id="descricaoEditarVaga" rows="4" name="descricaoEditarVaga" maxlength="10000" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="requisitosEditarVaga" class="form-label">Requisitos *</label>
                            <textarea class="form-control" id="requisitosEditarVaga" rows="5" name="requisitosEditarVaga" maxlength="10000" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dataEncerramentoEditarVaga" class="form-label">Encerramento das inscrições</label>
                            <input type="datetime-local" class="form-control" id="dataEncerramentoEditarVaga" name="dataEncerramentoEditarVaga" min="<?php echo $now; ?>" required>

                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="encerraCheckEditarVaga" name="encerraCheckEditarVaga">
                                <label class="form-check-label" for="encerraCheckEditarVaga">Não programar encerramento</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger sm btnEncerrar" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
                        <button type="button" id="btnModalCancelarVagaEditar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                    <input type="hidden" name="idVagaEditar" id="idVagaEditar">
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Vaga Vizualizar-->
    <div class="modal fade pgNumBTN" id="modalVaga" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tituloVagaModal">Título</h1>
                    <button type="button" id="btnFecharModalVaga" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Candidatos:</h6>
                    <div class="list-group" id="listaCandidatos">
                        <!--Candidatos aqui-->
                    </div>
                    <nav aria-label="Page navigation" class="mt-3 mb-0 navPaginacao">
                        <ul class="pagination justify-content-center">
                            <li class="page-item pgVoltar">
                                <button class="page-link">Voltar</button>
                            </li>
                            <div class="page-item pgNumeros pagination d-flex flex-row">
                            </div>
                            <li class="page-item pgAvancar">
                                <button class="page-link">Avançar</button>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnModalCancelarVaga" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Candidato -->
    <div class="modal fade " id="modalCandidato" data-bs-backdrop="static" aria-hidden="true" aria-labelledby="modalCandidato" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h2 class="modal-title fs-4 fw-bold user-select-all placeholder" id="modalCandidatoTitulo">nome</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-target="#modalVaga" data-bs-toggle="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- Nome e Sobrenome -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Nome:</h5>
                                <p id="modalCandidatoNome" class=" user-select-all placeholder">nome completo</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Celular:</h5>
                                <p id="modalCandidatoCelular" class=" user-select-all placeholder">celular</p>
                            </div>
                        </div>

                        <!-- Email e Telefone -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Email:</h5>
                                <p id="modalCandidatoEmail" class=" user-select-all placeholder">email</p>
                            </div>
                            <div class="col-md-6" id="modalCandidatoDivTelefone">
                                <h5 class="fw-bold">Telefone:</h5>
                                <p id="modalCandidatoTelefone" class=" user-select-all placeholder">telefone</p>
                            </div>
                        </div>

                        <!-- Proficiência em Idiomas -->
                        <div class="row mb-3">
                            <div class="col-md-4" id="modalCandidatoProInglesNivel">
                                <h5 class="fw-bold">Inglês:</h5>
                                <p id="modalCandidatoProIngles" class=" placeholder">nivel</p>
                            </div>
                            <div class="col-md-4" id="modalCandidatoProEspanholNivel">
                                <h5 class="fw-bold">Espanhol:</h5>
                                <p id="modalCandidatoProEspanhol" class=" placeholder">nivel</p>
                            </div>
                            <div class="col-md-4" id="modalCandidatoProFrancesNivel">
                                <h5 class="fw-bold">Francês:</h5>
                                <p id="modalCandidatoProFrances" class=" placeholder">nivel</p>
                            </div>
                        </div>

                        <!-- Formações -->
                        <div class="row mb-3" id="modalCandidatoFormacoesGeral">
                            <div class="col-12">
                                <h5 class="fw-bold">Formações:</h5>
                                <p id="modalCandidatoFormacoes" class=" placeholder">formacoes</p>
                            </div>
                        </div>

                        <!-- Experiências -->
                        <div class="row mb-3" id="modalCandidatoExperienciasGeral">
                            <div class="col-12">
                                <h5 class="fw-bold">Experiências:</h5>
                                <p id="modalCandidatoExperiencias" class=" placeholder">experiencias</p>
                            </div>
                        </div>

                        <!-- Certificações -->
                        <div class="row mb-3" id="modalCandidatoCertificacoesGeral">
                            <div class="col-12">
                                <h5 class="fw-bold">Certificações:</h5>
                                <p id="modalCandidatoCertificacoes" class=" placeholder">certificacoes</p>
                            </div>
                        </div>

                        <!-- Habilidades -->
                        <div class="row mb-3" id="modalCandidatoHabilidadesGeral">
                            <div class="col-12">
                                <h5 class="fw-bold">Habilidades:</h5>
                                <p id="modalCandidatoHabilidades" class=" placeholder">habilidades</p>
                            </div>
                        </div>

                        <!-- Disponibilidade -->
                        <div class="row mb-3" id="modalCandidatoDisponibilidadeGeral">
                            <div class="col-12">
                                <h5 class="fw-bold">Disponibilidade:</h5>
                                <p id="modalCandidatoDisponibilidade" class=" placeholder">disponibilidade</p>
                            </div>
                        </div>

                        <!-- Currículo -->
                        <div class="row" id="modalCandidatoCurriculoGeral">
                            <div class="col-12">
                                <iframe id="modalCandidatoCurriculo" class="rounded border" frameborder="0" style="height: 80vh; max-height: 600px; width: 100%;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <div>
                        <button class="btn btn-primary" data-bs-target="#modalVaga" data-bs-toggle="modal">Voltar</button>
                        <button type="button" class="btn btn-success" id="btnSelecionarCand">Selecionar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <!-- Modal Exluir-->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluir" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja excluir a vaga?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnModalExcluir" data-bs-dismiss="modal" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Encerrar-->
    <div class="modal fade" id="modalEncerrar" tabindex="-1" aria-labelledby="modalEncerrar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja finalizar a candidatura?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnModalEncerrar" data-bs-dismiss="modal" class="btn btn-danger">finalizar</button>
                </div>
            </div>
        </div>
    </div>

    <!--TOAST INFORMÇÃO-->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastInformacao" class="toast" role="information" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Estagiou</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="corpoToastInformacao">
                Text
            </div>
        </div>
    </div>
</section>