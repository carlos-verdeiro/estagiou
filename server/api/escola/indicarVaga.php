<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        die("Erro: Usuário não autenticado.");
    }

    $escola_id = $_SESSION['idUsuarioLogin'];
    $id_estagiario = $_POST['idEstagiario'];
    $vaga_id = $_POST['idVaga'];
    $status = isset($_POST['status']) ? $_POST['status'] : 1;

    if (!is_numeric($vaga_id) || $vaga_id <= 0) {
        die("Erro: ID da vaga inválido.");
    }

    try {
        include_once '../../conexao.php';

        $query = "SELECT COUNT(*) FROM indicacao WHERE id_estagiario = ? AND id_vaga = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param('ii', $id_estagiario, $vaga_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            $deleteQuery = "DELETE FROM indicacao WHERE id_estagiario = ? AND id_vaga = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            if (!$deleteStmt) {
                throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
            }

            $deleteStmt->bind_param('ii', $id_estagiario, $vaga_id);
            $deleteStmt->execute();
            $deleteStmt->close();

            echo "Indicação excluída!";
        } else {
            $insertQuery = "INSERT INTO indicacao (id_estagiario, id_vaga, id_escola, status) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            if (!$insertStmt) {
                throw new Exception("Erro na preparação da consulta de inserção: " . $conn->error);
            }

            $insertStmt->bind_param('iiii', $id_estagiario, $vaga_id, $escola_id, $status);
            $insertStmt->execute();
            $insertStmt->close();

            echo "Indicação realizada!";
        }
    } catch (Exception $e) {
        echo "Erro ao processar a indicação: " . $e->getMessage();
    } finally {
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
