<?php

session_start();

if (isset($_SESSION["status"]) && $_SESSION["status"] == "andamento") {

    $status = $_SESSION["status"];
    $tipoUsuario = $_SESSION["tipoUsuario"];
    $etapa = $_SESSION["etapa"];

    if (isset($_POST['continuarCadastro'])) {
        switch ($tipoUsuario) {
            case 'empresa':
                header("location: empresa/etapa$etapa.php");
                die; //Nada é executado depois
            case 'estagiario':
                header("location: estagiario/etapa$etapa.php");
                die; //Nada é executado depois
            case 'ie':
                header("location: ie/etapa$etapa.php");
                die; //Nada é executado depois

            default:
                $status = "iniciado";
                $tipoUsuario = NULL;
                $etapa = 0;
                break;
        }
    }
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
    <script src="../../../assets/js/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="../../../assets/js/jquery.mask.js"></script><!--PLUGIN JQUERY MASK-->
    <!--FIM JQUERY-->


    <!--FIM BIBLIOTECAS-->

    <link rel="stylesheet" href="../../assets/css/cadastro/cadastro.css">
    <link rel="shortcut icon" href="../../assets/img/icons/favicontransparente.ico" type="image/x-icon">
</head>

<body>
    <?php

    //---------HEADER---------
    include_once "../../assets/templates/cadastro/header.php";
    //---------HEADER---------

    ?>
    <section id="sectionCadastro">
        <div class="divCadastro" id="cadastro">
            <form class="formComponent p-4">
                <?php

                include_once("../../assets/templates/cadastro/selecao.php");

                ?>
            </form>
        </div>
    </section>
</body>

</html>