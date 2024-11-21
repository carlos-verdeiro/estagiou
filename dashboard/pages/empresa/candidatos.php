<?php
$hoje = date('Y-m-d');
$ontem = date('Y-m-d', strtotime('-1 day'));

?>
<section class="container my-5 sectionPagesEstagiario" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/empresa/candidatos.css">
    <script src="../assets/js/dashboard/empresa/candidatos.js"></script>

    <h2 class="text-center mb-4">Candidatos Selecionados</h2>

    <div id="divVagas">

    </div>



    <!-- Modal curriculo -->
    <div class="modal fade " id="modalCandidato" aria-hidden="true" aria-labelledby="modalCandidato" tabindex="-1">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal contrato-->
    <div class="modal fade" id="modalContrato" tabindex="-1" aria-labelledby="modalContrato" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" id="formContratar">
                    <input type="hidden" name="idCand" id="idCand">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Contratar candidato</h1>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="iniContra" class="form-label">Início de contrato:</label>
                            <input type="date" class="form-control" id="iniContra" min="<?php echo $ontem; ?>" value="<?php echo $hoje; ?>" name="iniContra">
                        </div>
                        <div class="mb-3">
                            <label for="fimContra" class="form-label">Fim de contrato:</label>
                            <input type="date" class="form-control" id="fimContra" min="<?php echo $hoje; ?>" name="fimContra">
                        </div>
                        <div class="mb-3">
                            <label for="obsContra" class="form-label">Observação:</label>
                            <textarea class="form-control" id="obsContra" rows="3" maxlength="1000" name="obsContra"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fileContra" class="form-label">Salvar contrato:</label>
                            <input type="file" class="form-control" id="fileContra" accept="application/pdf" name="fileContra">
                            <p class="text-secondary fs-6">Formato PDF</p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnModalContrato" class="btn btn-primary">Contratar</button>
                    </div>
                </form>
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

    <!-- Modal Exluir-->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluir" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja remover o candidato selecionado?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnModalExcluir" data-bs-dismiss="modal" class="btn btn-danger">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>
</section>