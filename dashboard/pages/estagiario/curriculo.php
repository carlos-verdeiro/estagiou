<section class="sectionPages sectionPagesEstagiario" id="sectionPageCurriculo">
    <link rel="stylesheet" href="../assets/css/dashboard/estagiario/curriculo.css">
    <script src="../assets/js/dashboard/estagiario/curriculo.js"></script>
    <h1 class="tituloPage mb-5">CURRÍCULO</h1>

    <?php
    session_start();
    // Conectar com usuário e senha específicos para atualização
    $dsn = 'mysql:host=localhost;dbname=estagiou;charset=utf8mb4';
    $selectUser = 'curriculoSelectEstagiario';
    $selectPassword = '123';

    $connselect = new PDO($dsn, $selectUser, $selectPassword);
    $connselect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $select_stmt = $connselect->prepare("SELECT curriculo_id FROM estagiario WHERE id = :id");
    $select_stmt->bindValue(':id', $_SESSION['idUsuarioLogin'], PDO::PARAM_INT);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="divBlocos row d-flex flex-wrap">
        <div class="blocos col arquivo visually-hidden">
            <iframe id="iframeArquivo" frameborder="0">
            </iframe>
        </div>
        <div class="blocos col formulario">

            <form id="formUploadArquivo" class="p-3" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="curriculo" class="form-label">Faça upload de seu currículo aqui:</label>
                    <input class="form-control form-control" id="curriculo" name="curriculo" type="file" accept="application/pdf">

                </div>
                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observação:</label>
                    <textarea class="form-control form-control-sm" id="observacoes" name="observacoes" type="text" maxlength="500"></textarea>
                </div>
                <input type="submit" class="btn btn-primary sm" value="Salvar">
                <button type="button" id="btnExcluir" class="btn btn-danger sm" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>

            </form>
        </div>

    </div>
    <!-- Modal Exluir-->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluir" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja excluir o currículo atual?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</section>