<section class="sectionPages sectionPagesEstagiario" id="sectionPageCurriculo">
    <link rel="stylesheet" href="../assets/css/dashboard/empresa/vagas.css">
    <script src="../assets/js/dashboard/empresa/vagas.js"></script>

    <h1 class="tituloPage mb-5">VAGAS</h1>
    <button type="button" class="btn btn-primary sm" id="btnCriarVaga" data-bs-toggle="modal" data-bs-target="#modalCriarVaga">Criar nova vaga</button>

    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <div class="divBlocos row row-cols-2 gap-4 w-100 d-flex justify-content-center blocosVagas">
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
                        <button type="button" id="btnModalCancelarVagaEditar" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                    <input type="hidden" name="idVagaEditar" id="idVagaEditar">
                </form>
            </div>
        </div>
    </div>
</section>