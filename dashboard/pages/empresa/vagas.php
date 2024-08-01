<section class="sectionPages sectionPagesEstagiario" id="sectionPageCurriculo">
    <link rel="stylesheet" href="../assets/css/dashboard/empresa/vagas.css">
    <script src="../assets/js/dashboard/empresa/vagas.js"></script>
    <h1 class="tituloPage mb-5">VAGAS</h1>

    <?php
    date_default_timezone_set('America/Sao_Paulo'); // Definindo o fuso horário correto
    $now = date('Y-m-d\TH:i');
    session_start();
    // Conectar com usuário e senha específicos para atualização
    $dsn = 'mysql:host=localhost;dbname=estagiou;charset=utf8mb4';
    $selectUser = 'root';
    $selectPassword = '';

    $connselect = new PDO($dsn, $selectUser, $selectPassword);
    $connselect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $select_stmt = $connselect->prepare("SELECT curriculo_id FROM estagiario WHERE id = :id");
    $select_stmt->bindValue(':id', $_SESSION['idUsuarioLogin'], PDO::PARAM_INT);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="divBlocos row row-cols-2">
        <div class="blocos col-md arquivo mt-2">
            <h1>olá</h1>
        </div>



    </div>
    <button type="button" class="btn btn-danger sm" id="btnExcluir" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
    <button type="button" class="btn btn-primary sm" id="btnCriarVaga" data-bs-toggle="modal" data-bs-target="#modalCriarVaga">Criar nova vaga</button>

    <!-- Modal Exluir-->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluir" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja excluir essa vaga?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnModalExcluir" data-bs-dismiss="modal" class="btn btn-danger">Criar</button>
                </div>
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
                <form method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tituloVaga" class="form-label">Título</label>
                            <input type="text" class="form-control" id="tituloVaga" maxlength="255" name="tituloVaga">
                        </div>
                        <div class="mb-3">
                            <label for="descricaoVaga" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricaoVaga" rows="4" name="descricaoVaga" maxlength="10000" ></textarea>
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