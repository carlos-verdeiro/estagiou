<?php

session_start();
if (isset($_SESSION['statusLogin']) && $_SESSION['statusLogin'] === 'autenticado' && isset($_SESSION['idUsuarioLogin'])) {
    header('location: dashboard/');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Otimize o processo de contratação de estágios conectando estagiários, empregadores e instituições de ensino em uma plataforma intuitiva. Encontre oportunidades de estágio ideais, simplifique o recrutamento e promova o crescimento profissional. Cadastre-se agora e descubra como facilitar sua busca por estagiarios para sua empresa.">
    <link rel="shortcut icon" href="assets/img/logo/logo.svg" type="image/x-icon">
    <title>Estagiou</title>

    <!--BIBLIOTECAS-->


    <!--BOOTSTRAP-->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.js"></script>
    <!--FIM BOOTSTRAP-->

    <!--JQUERY-->
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="assets/js/jquery.mask.js"></script><!--PLUGIN JQUERY MASK-->

    <!--FIM JQUERY-->


    <!--FIM BIBLIOTECAS-->

    <link rel="stylesheet" href="assets/css/index/index.css">
</head>

<body>
    <?php
    include_once "assets/templates/index/header.php";
    ?>
    <main id="main">

        <?php
        include_once "assets/templates/index/initial.php";
        ?>
    </main>
    
    <script src="assets/js/index/index.js"></script>
</body>

</html>