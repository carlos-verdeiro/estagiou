<?php

session_start();
if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || !isset($_SESSION['idUsuarioLogin'])) {
    session_unset();
    session_destroy();
    header('location: ../index.php?acessoNegado');
    exit;
}

$usuario = array(
    "tipo" => $_SESSION['tipoUsuarioLogin'],
    "id" => $_SESSION['idUsuarioLogin']
);

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('location: ../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Otimize o processo de contratação de estágios conectando estagiários, empregadores e instituições de ensino em uma plataforma intuitiva. Encontre oportunidades de estágio ideais, simplifique o recrutamento e promova o crescimento profissional. Cadastre-se agora e descubra como facilitar sua busca por estágios ou talentos para sua empresa.">
    <link rel="shortcut icon" href="../assets/img/icons/favicontransparente.ico" type="image/x-icon">
    <title>Estagiou</title>

    <!--BIBLIOTECAS-->


    <!--BOOTSTRAP-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!--ICONES-->

    <!--FIM BOOTSTRAP-->

    <!--JQUERY-->
    <script src="../assets/js/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.mask.js"></script><!--PLUGIN JQUERY MASK-->

    <!--FIM JQUERY-->

    <!--CARREGAMENTO-->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring.js"></script>
    <!--FIM CARREGAMENTO-->

    <!--FIM BIBLIOTECAS-->
    <link rel="stylesheet" href="../assets/css/dashboard/dashboard.css">
</head>

<body>

    <nav class="offcanvas-sm offcanvas-start sidebar" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-body btnLogo">
            <button type="button" class="btn" id="divLogoNav"><img src="../assets/img/logo.svg" alt="Logo Estagiou"></button>

        </div>
        <section class="divNavBody">

            <?php
            switch ($usuario['tipo']) {
                case 'estagiario':
                    echo '
                    <div class="offcanvas-body itemNav">
                        <button class="btn linkNav linkNavEstagiario linkNavMenu" id="btnNavEstagiarioMenu"><i class="bi bi-house iconLinkNav"></i><p class="textLinkNav">MENU</p></button>
                    </div>';
                    echo '
                    <div class="offcanvas-body itemNav">
                        <button class="btn linkNav linkNavEstagiario" id="btnNavEstagiarioCurriculo"><i class="bi bi-person-vcard iconLinkNav"></i><p class="textLinkNav">Currículo</p></button>
                    </div>';
                    echo '
                    <div class="offcanvas-body itemNav">
                        <button class="btn linkNav linkNavEstagiario" id="btnNavEstagiarioVagas"><i class="bi bi-grid iconLinkNav"></i></i><p class="textLinkNav">Vagas</p></button>
                    </div>';
                    /*echo '
                    <div class="offcanvas-body itemNav">
                        <button class="btn linkNav linkNavEstagiario" id="btnNavEstagiarioNotificacoes"><i class="bi bi-bell iconLinkNav"></i><p class="textLinkNav">Notificações</p></button>
                    </div>';
                    echo '
                    <div class="offcanvas-body itemNav">
                        <button class="btn linkNav linkNavEstagiario linkNavMensagens" id="btnNavEstagiarioMensagens"><i class="bi bi-chat iconLinkNav"></i><p class="textLinkNav">Mensagens</p></button>
                    </div>';*/
                    break;


                case 'empresa':
                    echo '
                        <div class="offcanvas-body itemNav">
                            <button class="btn linkNav linkNavEmpresa linkNavMenu" id="btnNavEmpresaMenu"><i class="bi bi-house iconLinkNav"></i><p class="textLinkNav">MENU</p></button>
                        </div>';
                    echo '
                        <div class="offcanvas-body itemNav">
                            <button class="btn linkNav linkNavEmpresa" id="btnNavEmpresaVagas"><i class="bi bi-grid iconLinkNav"></i></i><p class="textLinkNav">Vagas</p></button>
                        </div>';
                    echo '
                        <div class="offcanvas-body itemNav">
                            <button class="btn linkNav linkNavEmpresa" id="btnNavEmpresaCandidatos"><i class="bi bi-person-vcard iconLinkNav"></i><p class="textLinkNav">Candidatos</p></button>
                        </div>';
                    echo '
                        <div class="offcanvas-body itemNav">
                            <button class="btn linkNav linkNavEmpresa" id="btnNavEmpresaSeusEstagiarios"><i class="bi bi-person-check iconLinkNav"></i></i><p class="textLinkNav">Seus Estagiários</p></button>
                        </div>';
                    /*echo '
                        <div class="offcanvas-body itemNav">
                            <button class="btn linkNav linkNavEmpresa" id="btnNavEmpresaNotificacoes"><i class="bi bi-bell iconLinkNav"></i><p class="textLinkNav">Notificações</p></button>
                        </div>';
                    echo '
                        <div class="offcanvas-body itemNav">
                            <button class="btn linkNav linkNavEmpresa linkNavMensagens" id="btnNavEmpresaMensagens"><i class="bi bi-chat iconLinkNav"></i><p class="textLinkNav">Mensagens</p></button>
                        </div>';*/
                    break;


                case 'escola':
                    echo '
                            <div class="offcanvas-body itemNav">
                                <button class="btn linkNav linkNavEscola linkNavMenu" id="btnNavEscolaMenu"><i class="bi bi-house iconLinkNav"></i><p class="textLinkNav">MENU</p></button>
                            </div>';
                    echo '
                            <div class="offcanvas-body itemNav">
                                <button class="btn linkNav linkNavEscola" id="btnNavEscolaCurriculo"><i class="bi bi-person-vcard iconLinkNav"></i><p class="textLinkNav">Alunos</p></button>
                            </div>';
                    echo '
                            <div class="offcanvas-body itemNav">
                                <button class="btn linkNav linkNavEscola" id="btnNavEscolaVagas"><i class="bi bi-grid iconLinkNav"></i></i><p class="textLinkNav">Vagas</p></button>
                            </div>';
                    echo '
                            <div class="offcanvas-body itemNav">
                                <button class="btn linkNav linkNavEscola" id="btnNavEscolaEmpresas"><i class="bi bi-building iconLinkNav"></i></i><p class="textLinkNav">Empresas</p></button>
                            </div>';
                    /*echo '
                            <div class="offcanvas-body itemNav">
                                <button class="btn linkNav linkNavEscola" id="btnNavEscolaNotificacoes"><i class="bi bi-bell iconLinkNav"></i><p class="textLinkNav">Notificações</p></button>
                            </div>';
                    echo '
                            <div class="offcanvas-body itemNav">
                                <button class="btn linkNav linkNavEscola linkNavMensagens" id="btnNavEscolaMensagens"><i class="bi bi-chat iconLinkNav"></i><p class="textLinkNav">Mensagens</p></button>
                            </div>';*/
                    break;
                default:
                    echo 'ERROR';
                    break;
            }
            ?>
        </section>
    </nav>

    <main id="main">
        <header id="header" class="d-flex flex-row px-2">
            <button class="btn d-sm-none botaoMenu text-white p-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive"><i class="bi bi-list text-white fs-1"></i></button>

            <div class="dropdown text-white-50 ms-auto">
                <button class="btn  dropdown-toggle text-white" id="btnMenuPerson" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle text-white fs-4 "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item linkNavEstagiario linkNavEscola linkNavEmpresa" id="btnPerfil">Perfil</button></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger " href="?logout">Sair</a></li>
                </ul>
            </div>
        </header>
        <section id="sectionPrincipal">
            <?php include_once "templates/carregamento.php"; ?>
        </section>
    </main>
    <script src="../assets/js/dashboard/dashboard.js"></script>
    <?php
    switch ($usuario['tipo']) {
        case 'estagiario':

            echo '<script src="../assets/js/dashboard/estagiario/estagiario.js"></script>';

            break;

        case 'empresa':

            echo '<script src="../assets/js/dashboard/empresa/empresa.js"></script>';

            break;

        case 'escola':

            echo '<script src="../assets/js/dashboard/escola/escola.js"></script>';

            break;
        default:
            echo 'ERROR';
            break;
    }
    ?>

</body>

</html>