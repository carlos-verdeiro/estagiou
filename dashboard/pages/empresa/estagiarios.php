<section class="sectionPages">
    <h2 class="text-center mb-4">Estagiários Contratados</h2>
    <div id="principal">
        <!-- Conteúdo-->
    </div>

    <!-- Modal contrato -->
    <div class="modal fade " id="modalContrato" aria-hidden="true" aria-labelledby="modalContrato" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h2 class="modal-title fs-4 fw-bold user-select-all" id="modalContratoTitulo">nome</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-target="#modalContrato" data-bs-toggle="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- info estagiario -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Nome:</h5>
                                <p id="modalEstagiarioNome" class=" user-select-all">nome completo</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Vaga:</h5>
                                <p id="modalEstagiarioVaga" class=" user-select-all">vaga</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Celular:</h5>
                                <p id="modalEstagiarioCelular" class=" user-select-all">celular</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Email:</h5>
                                <p id="modalEstagiarioEmail" class=" user-select-all">email</p>
                            </div>
                        </div>

                        <!-- Data Contratacao -->
                        <div class="row mb-3" id="modalEstagiarioDatas">
                            <div class="col-12">
                                <h5 class="fw-bold">Data de contratação:</h5>
                                <p id="modalEstagiarioDataContratacao">contratacao</p>
                            </div>
                            <div class="col-12">
                                <h5 class="fw-bold">Fim de contrato:</h5>
                                <p id="modalEstagiarioFimContrato">fim contratacao</p>
                            </div>
                        </div>

                        <!-- Observacoes -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5 class="fw-bold">Observações:</h5>
                                <p id="modalEstagiarioObservacoes">Observações</p>
                            </div>
                        </div>

                        <!-- Currículo -->
                        <div class="row" id="modalEstagiarioContratoGeral">
                            <div class="col-12">
                                <iframe id="modalEstagiarioContrato" class="rounded border" frameborder="0" style="height: 80vh; max-height: 600px; width: 100%;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button class="btn btn-primary btnEditarContrato" id="btnEditarContratoModalView">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Contrato-->
    <div class="modal fade" id="modalEditarContrato" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Contrato</h1>
                    <button type="button" id="btnFecharModalEditCont" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formAtualizarContrato">
                    <input type="hidden" name="idContrato" id="idContrato">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Nome:</h6>
                                <p id="modalNomeEditar" class=" user-select-all">nome completo</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Vaga:</h6>
                                <p id="modalVagaEditar" class=" user-select-all">vaga</p>
                            </div>
                            <div class="col-12">
                                <h6 class="fw-bold">Data de contratação:</h6>
                                <p id="modalDataContratacaoEditar">contratacao</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modalFimContratoEditar" class="form-label">Fim de contrato:</label>
                            <input type="date" class="form-control" id="modalFimContratoEditar" name="modalFimContratoEditar">
                        </div>
                        <div class="mb-3">
                            <label for="modalObservacoesEditar" class="form-label">Observações:</label>
                            <textarea class="form-control" id="modalObservacoesEditar" rows="4" name="modalObservacoesEditar" maxlength="1000"></textarea>
                        </div>
                        <div class="mb-3" id="divAnexo">
                            <i class="bi bi-file-text-fill" id="iconFile"></i>
                            <label for="anexoEditarContrato" class="form-label" id="labelAttAnexo">Novo anexo:</label>
                            <input type="file" class="form-control" id="anexoEditarContrato" name="anexoEditarContrato" accept="application/pdf">
                        </div>
                        <div class="form-check form-switch mb-3" id="divRmAnexo">
                            <input class="form-check-input" type="checkbox" role="switch" id="rmAnexo" name="rmAnexo">
                            <label class="form-check-label" for="rmAnexo">Remover anexo atual</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger sm btnEncerrar" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
                        <button type="button" id="btnModalCancelarVagaEditar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
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


    <script src="../assets/js/dashboard/empresa/estagiarios.js"></script>
</section>