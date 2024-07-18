<section class="sectionPages sectionPagesEstagiario" id="sectionPageCurriculo">
    <link rel="stylesheet" href="../assets/css/dashboard/curriculo.css">
    <script src="../assets/js/dashboard/estagiario/curriculo.js"></script>
    <h1 class="tituloPage">CURRÍCULO</h1>

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

    if (!$row['curriculo_id']) {
        echo"Você não possui nenhum currículo salvo.";
    }

    ?>

    <div>

    </div>
    <form id="formArquivo" enctype="multipart/form-data">

        <label for="curriculo" class="form-label">Faça upload de seu currículo aqui:</label>
        <input class="form-control form-control-lg" id="curriculo" name="curriculo" type="file" accept="application/pdf">

        <label for="observacoes" class="form-label">Observação:</label>
        <input class="form-control form-control-sm" id="observacoes" name="observacoes" type="text">
        <input type="submit" class="btn btn-primary sm" value="Salvar">


    </form>

</section>