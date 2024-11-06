<?php
session_start();
include_once '../../../server/conexao.php'; // Inclui a conexão com o banco de dados

if (!isset($_SESSION['idUsuarioLogin'])) {
    echo json_encode(['mensagem' => 'Sessão inválida.', 'code' => 1]);
    exit;
}

// Verifica se a escola está autenticada
if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'escola') {
    echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
    exit;
}

$idEscola = $_SESSION['idUsuarioLogin'];

?>

<section class="sectionPages sectionPagesEscola" id="sectionPageMenu">
    <link rel="stylesheet" href="../assets/css/dashboard/menu.css">

    <h1 class="tituloPage">MENU</h1>

    <div class="container text-center containerBlocosMenu">
        <div class="row row-cols-2 divBlocosMenu">
            <?php
            try {
                // Consulta para verificar o último login
                $stmt = $conn->prepare("SELECT ultimo_login FROM estagiario WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('i', $idEstagiario);
                $stmt->execute();
                $stmt->bind_result($ultimo_login);
                $stmt->fetch();
                $stmt->close();

                // Se não houver último login, exibe a mensagem de boas-vindas
                if (!$ultimo_login) {
                    echo '
                    <div class="col blocosMenu">
                        <div class="card boasVindas" style="width: 18rem;">
                            <div class="col card-body">
                                <h5 class="card-title">Bem-vindo!</h5>
                                <p class="card-text">Seja bem-vindo ao <strong>Estagiou</strong>, esperamos que goste da nossa plataforma😉</p>
                                <button class="btn btn-secondary btnFecharBoasVindas">Fechar</button>
                            </div>
                        </div>
                    </div>
                    <script> $(".btnFecharBoasVindas").on("click", ()=>{ $(".boasVindas").remove();})</script>
                    ';
                }
                // Atualiza o timestamp de último login
                $stmt = $conn->prepare("UPDATE estagiario SET ultimo_login = NOW() WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da atualização: " . $conn->error);
                }

                $stmt->bind_param('i', $idEstagiario);
                $stmt->execute();
                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 2]);
                exit;
            } finally {
                $conn->close();
            }
            ?>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Currículos</h5>
                        <p class="card-text">Publique os currículos para que as empresas visualizem.</p>
                        <button class="btn btn-primary btnMenus" value="curriculos">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Vagas</h5>
                        <p class="card-text">Veja as vagas disponíveis.</p>
                        <button class="btn btn-primary btnMenus" value="vagas">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Empresas</h5>
                        <p class="card-text">Aqui você pode ver as empresas.</p>
                        <button class="btn btn-primary btnMenus" value="empresas">Ver mais</button>
                    </div>
                </div>
            </div>
            <!--<div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Notificações</h5>
                        <p class="card-text">Aqui você pode ver suas notificações.</p>
                        <button class="btn btn-primary btnMenus" value="notificacoes">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Mensagens</h5>
                        <p class="card-text">Converse com empresas.</p>
                        <button class="btn btn-primary btnMenus" value="mensagens">Ver mais</button>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
    <script src="../assets/js/dashboard/escola/menu.js"></script>
</section>