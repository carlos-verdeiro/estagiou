<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        die("Erro: Usuário não autenticado.");
    }
    if ($_SESSION['tipoUsuarioLogin'] === "estagiario") {
        $estagiario_id = $_SESSION['idUsuarioLogin'];
    }else{
        $estagiario_id = $_POST['idEstagiario'];
    }
    $vaga_id = $_POST['idVaga'];
    $observacao = isset($_POST['observacao']) ? $_POST['observacao'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : 1;

    if (!is_numeric($vaga_id) || $vaga_id <= 0) {
        die("Erro: ID da vaga inválido.");
    }
    if ($observacao !== null && strlen($observacao) > 500) {
        die("Erro: Observação muito longa.");
    }

    try {
        include_once '../../conexao.php';

        $query = "SELECT COUNT(*) FROM candidatura WHERE id_estagiario = ? AND id_vaga = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param('ii', $estagiario_id, $vaga_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $deleteQuery = "DELETE FROM candidatura WHERE id_estagiario = ? AND id_vaga = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            if (!$deleteStmt) {
                throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
            }

            $deleteStmt->bind_param('ii', $estagiario_id, $vaga_id);
            $deleteStmt->execute();
            $deleteStmt->close();

            echo "Inscrição excluída!";
        } else {
            $insertQuery = "INSERT INTO candidatura (id_estagiario, id_vaga, observacao, status) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            if (!$insertStmt) {
                throw new Exception("Erro na preparação da consulta de inserção: " . $conn->error);
            }

            $insertStmt->bind_param('iisi', $estagiario_id, $vaga_id, $observacao, $status);
            $insertStmt->execute();
            $insertStmt->close();

            echo "Inscrição realizada!";
        }

    } catch (Exception $e) {
        echo "Erro ao processar a candidatura: " . $e->getMessage();
    } finally {
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
