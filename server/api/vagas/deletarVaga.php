<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Método não permitido
    die("Método de requisição inválido.");
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Verifica se a empresa está autenticada
if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'empresa') {
    http_response_code(401); // Não autorizado
    die("Erro: Usuário não autenticado.");
}

if (!isset($uri[5]) || !is_numeric($uri[5])) {
    http_response_code(422); // Entidade não processável
    die("Erro: Parâmetros inválidos.");
}

$idVaga = (int)$uri[5]; // Garante que o idVaga seja um inteiro

try {
    // Inclui o arquivo de conexão
    include_once '../../conexao.php';

    // Conecta ao banco de dados para verificação
    $stmt = $conn->prepare("UPDATE vaga SET status = 0 WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta para verificação: " . $conn->error);
    }

    $stmt->bind_param('i', $idVaga);
    $stmt->execute();
    $stmt->close();
    
    echo "Vaga deletada com sucesso!";
} catch (Exception $e) {
    http_response_code(500); // Erro interno do servidor
    echo "Falha Interna, favor entrar em contato com o suporte.";
} finally {
    // Fechar a conexão
    if (isset($conn)) $conn->close();
}
exit;
?>
