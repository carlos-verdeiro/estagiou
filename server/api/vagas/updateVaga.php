<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o estagiário está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        http_response_code(401);
        die("Erro: Usuário não autenticado.");
    }

    // Obtém dados do formulário
    $empresa_id = $_SESSION['idUsuarioLogin'];
    $titulo = $_POST['tituloEditarVaga'];
    $descricao = isset($_POST['descricaoEditarVaga']) ? $_POST['descricaoEditarVaga'] : '';
    $requisitos = isset($_POST['requisitosEditarVaga']) ? $_POST['requisitosEditarVaga'] : '';
    $data_encerramento = isset($_POST['dataEncerramentoEditarVaga']) ? $_POST['dataEncerramentoEditarVaga'] : null;
    $idVagaEditar = $_POST['idVagaEditar'];

    try {

        // Conecta ao banco de dados para verificação
        $mysqli = new mysqli('localhost', 'root', '', 'estagiou');
        if ($mysqli->connect_error) {
            throw new Exception("Conexão falhou: " . $mysqli->connect_error);
        }

        // Verifica se já existe um currículo para o estagiário
        $stmt = $mysqli->prepare("UPDATE vaga SET titulo=?, descricao=?, requisitos=?, data_encerramento=? WHERE id = ?");
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta para verificação: " . $mysqliSelect->error);
        }

        $stmt->bind_param('ssssi', $titulo, $descricao, $requisitos, $data_encerramento, $idVagaEditar);
        $stmt->execute();
        $stmt->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo "Falha Interna, favor entrar em contato com o suporte";
    } finally {
        // Fechar as conexões
        if (isset($mysqli)) $mysqli->close();
    }
} else {
    http_response_code(400);
    echo "Método de requisição inválido.";
}
