<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    die("Método de requisição inválido.");
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Verifica se a empresa está autenticado
if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'empresa') {
    http_response_code(401);
    die("Erro: Usuário não autenticado.");
}

if (!isset($uri[5]) || !is_numeric($uri[5])) {
    http_response_code(422);
    die("Erro: Parâmetros inválidos.");
}

$idVaga = $uri[5];

try {

    // Conecta ao banco de dados para verificação
    $mysqli = new mysqli('localhost', 'root', '', 'estagiou');
    if ($mysqli->connect_error) {
        throw new Exception("Conexão falhou: " . $mysqli->connect_error);
    }

    // Verifica se já existe um currículo para o estagiário
    $stmt = $mysqli->prepare("DELETE FROM vaga  WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta para verificação: " . $mysqliSelect->error);
    }

    $stmt->bind_param('i', $idVaga);
    $stmt->execute();
    $stmt->close();
    echo "Deletado";
} catch (Exception $e) {
    http_response_code(500);
    echo "Falha Interna, favor entrar em contato com o suporte";
} finally {
    // Fechar as conexões
    if (isset($mysqli)) $mysqli->close();
}
