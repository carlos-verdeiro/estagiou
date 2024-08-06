<section class="sectionPages sectionPagesEstagiario" id="sectionPageCurriculo">
    <link rel="stylesheet" href="../assets/css/dashboard/estagiario/curriculo.css">
    <script src="../assets/js/dashboard/estagiario/curriculo.js"></script>
    <h1 class="tituloPage mb-5">CURRÍCULO</h1>

    <?php
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
    <span class="visually-hidden">Carregando...</span>
  </div>
</div>

    <div class="divBlocos row row-cols-2">
        <div class="blocos col-md arquivo visually-hidden mt-2">
            <iframe id="iframeArquivo" frameborder="0">
            </iframe>
        </div>
        <div class="col-md mt-2 w-100">

            <div class=" row formulario visually-hidden" id="divInformacoes">

                <div class="p-3" enctype="multipart/form-data">
                    <h4 class="form-label">Informações:</h4>
                    <div class="mb-1">
                        <div class="row">
                            <h6 class="form-label col">Nome do arquivo:</h6>
                            <p id="resNomeArquivo" class="col"></p>
                        </div>
                        <div class="row">
                            <h6 class="form-label col">Data de submissão:</h6>
                            <p id="resSubmissao" class="col"></p>
                        </div>

                        <div class="row">
                            <h6 class="form-label col">Observações:</h6>
                            <p id="resObservacoes"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 row formulario w-100">

                <form id="formUploadArquivo" class="p-3" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="curriculo" class="form-label">Faça upload de seu currículo aqui:</label>
                        <input class="form-control form-control" id="curriculo" name="curriculo" type="file" accept="application/pdf" required>

                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações:</label>
                        <textarea class="form-control form-control-sm" id="observacoes" name="observacoes" type="text" maxlength="500"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary sm" value="Salvar">
                    <button type="button" class="btn btn-danger sm"  id="btnExcluir" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>

                </form>
            </div>
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
                    <button type="button" id="btnModalExcluir" data-bs-dismiss="modal" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>
    </div>
</section>