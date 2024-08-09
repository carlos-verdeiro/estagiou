<?php
session_start();
include_once '../../../server/conexao.php'; // Inclui a conexão com o banco de dados

// Verifica se a sessão do usuário está ativa
if (!isset($_SESSION['idUsuarioLogin'])) {
    echo json_encode(['mensagem' => 'Sessão inválida.', 'code' => 1]);
    exit;
}

$idEstagiario = $_SESSION['idUsuarioLogin'];

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

        // Atualiza o timestamp de último login
        $stmt = $conn->prepare("UPDATE estagiario SET ultimo_login = NOW() WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Erro na preparação da atualização: " . $conn->error);
        }

        $stmt->bind_param('i', $idEstagiario);
        $stmt->execute();
        $stmt->close();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 2]);
    exit;
} finally {
    $conn->close();
}
?>

<section class="sectionPages sectionPagesEstagiario" id="sectionPageMenu">
    <link rel="stylesheet" href="../assets/css/dashboard/menu.css">

    <h1 class="tituloPage">MENU</h1>

    <div class="container text-center containerBlocosMenu">
        <div class="row row-cols-2 divBlocosMenu">
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Currículo</h5>
                        <p class="card-text">Publique seu currículo para que os contratantes possam ver.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Vagas</h5>
                        <p class="card-text">Veja as vagas disponíveis para você.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Notificações</h5>
                        <p class="card-text">Aqui você pode ver suas notificações.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
            <div class="col blocosMenu">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Mensagens</h5>
                        <p class="card-text">Converse com empresas.</p>
                        <button class="btn btn-primary">Ver mais</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
