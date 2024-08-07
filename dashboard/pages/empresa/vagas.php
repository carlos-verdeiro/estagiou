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

    <div class="divBlocos row row-cols-2 gap-4 w-100 d-flex justify-content-center">

        <div class="card px-0" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Título da vaga bem graaaaande</h5>
                <hr>
                <h6>Descrição:</h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <h6>Requisitos:</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed corrupti repellendus rerum numquam nam illo expedita maiores ipsam iure molestiae repudiandae earum commodi, facilis at atque quaerat fuga, blanditiis tenetur.</p>
                <h6>Encerra:</h6>
                <p>07/08/2024 22:45</p>

                <button type="button" class="btn btn-primary sm btnVizualizar" data-bs-toggle="modal" data-bs-target="#modalVizualizar">Vizualizar</button>
                <button type="button" class="btn btn-warning sm btnEditar" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                <button type="button" class="btn btn-danger sm btnEncerrar" data-bs-toggle="modal" data-bs-target="#modalEncerrar">Encerrar</button>
            </div>
            <div class="card-footer">
                Publicado: 06/08/2024
            </div>
        </div>

    </div>




    <!-- Modal Criar Vaga-->
    <div class="modal fade" id="modalCriarVaga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Criar nova vaga</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formCadastroVaga">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tituloVaga" class="form-label">Título</label>
                            <input type="text" class="form-control" id="tituloVaga" maxlength="255" name="tituloVaga">
                        </div>
                        <div class="mb-3">
                            <label for="descricaoVaga" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricaoVaga" rows="4" name="descricaoVaga" maxlength="10000"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="requisitosVaga" class="form-label">Requisitos</label>
                            <textarea class="form-control" id="requisitosVaga" rows="5" name="requisitosVaga" maxlength="10000"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="dataEncerramentoVaga" class="form-label">Encerramento das inscrições</label>
                            <input type="datetime-local" class="form-control" id="dataEncerramentoVaga" name="dataEncerramentoVaga" min="<?php echo $now; ?>">

                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="encerraCheckVaga" name="encerraCheckVaga">
                                <label class="form-check-label" for="encerraCheckVaga">Não programar encerramento</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>