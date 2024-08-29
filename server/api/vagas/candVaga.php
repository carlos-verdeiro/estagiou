<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se a empresa está autenticada
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] != 'estagiario') {
        die("Erro: Usuário não autenticado.");
    }

    // Obtém dados do formulário
    $estagiario_id = $_SESSION['idUsuarioLogin'];
    $vaga_id = $_POST['idVaga'];
    $observacao = isset($_POST['observacao']) ? $_POST['observacao'] : null;

    if (!is_numeric($vaga_id) || $vaga_id <= 0) {
        die("Erro: ID da vaga inválido.");
    }
    if ($observacao !== null && strlen($observacao) > 500) {
        die("Erro: Observação muito longa.");
    }

    try {
        // Inclui o arquivo de conexão
        include_once '../../conexao.php';

        // Conecta ao banco de dados para inserção
        $stmt = $conn->prepare("INSERT INTO candidatura (id_estagiario, id_vaga, observacao) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param('iis', $estagiario_id, $vaga_id, $observacao);
        $stmt->execute();
        $stmt->close();

        echo "Inscrição realizada!";
    } catch (Exception $e) {
        echo "Erro ao inscrever-se: " . $e->getMessage();
    } finally {
        // Fechar a conexão
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
