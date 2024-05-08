<?php

session_start();

if (isset($_SESSION["status"]) && $_SESSION["status"] == "andamento") {

    $status = $_SESSION["status"];
    $tipoUsuario = $_SESSION["tipoUsuario"];
    $etapa = $_SESSION["etapa"];
} else {
    $status = "iniciado";
    $tipoUsuario = NULL;
    $etapa = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Otimize o processo de contratação de estágios conectando estagiários, empregadores e instituições de ensino em uma plataforma intuitiva. Encontre oportunidades de estágio ideais, simplifique o recrutamento e promova o crescimento profissional. Cadastre-se agora e descubra como facilitar sua busca por estágios ou talentos para sua empresa.">
    <link rel="shortcut icon" href="../../assets/img/logo/favicontransparente.ico" type="image/x-icon">
    <title>Estagiou - Cadastro</title>

    <!--BIBLIOTECAS-->


    <!--BOOTSTRAP-->
    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../assets/js/bootstrap.js"></script>
    <!--FIM BOOTSTRAP-->

    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!--FIM JQUERY-->


    <!--FIM BIBLIOTECAS-->

    <link rel="stylesheet" href="../../assets/css/cadastro/cadastro.css">
</head>

<body>
    <?php

    //---------HEADER---------
    include_once "../templates/cadastro/header.php";
    //---------HEADER---------

    //////////////////////////////////////////////////////////////////////////////MANIPULAR O QUE VAI APARECER NO MEIO DA TELA//////////////////////////////////////////////////////////////////////////////
    ?>
    <section id="sectionCadastro">
        <div class="divCadastro" id="cadastro">
            <form class="formComponent p-4">
                <div class="progress w-75" role="progressbar" aria-label="Example with label" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: 0%">0%</div>
                </div>
                <span class="spanPreencha">*Preencha com atenção*</span>
                <div class="divInputs d-flex flex-wrap w-100">
                    <h2 class="h2">Se inscrever como</h2>
                    <form action="cadastro.php" method="post">
                        <button class="btn btn-dark botoesCadastro" id="cadastroEstagiario">Estagiário</button>
                        <button class="btn btn-warning botoesCadastro" id="cadastroIE">Instituição de ensino</button>
                        <button class="btn btn-info botoesCadastro" id="cadastroEmpresa">Empresa</button>
                    </form>
                </div>
            </form>
        </div>
    </section>
    <script src="../../assets/js/cadastro/cadastro.js"></script>
</body>

</html>