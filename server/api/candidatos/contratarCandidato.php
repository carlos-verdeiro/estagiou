<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== "Empresa") {
        die("Erro: Usuário não autenticado.");
    }

    $id_empresa = $_SESSION['idUsuarioLogin'];

    $estagiario_id = $_POST['idCand'];


    if (!is_numeric($id_vaga) || $id_vaga <= 0) {
        die("Erro: ID da vaga inválido.");
    }
    if (!is_numeric($vaga_candidato) || $vaga_candidato <= 0) {
        die("Erro: ID do candidato inválido.");
    }

    try {
        include_once '../../conexao.php';

        $query = "SELECT COUNT(*), * FROM candidatura WHERE id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param('i', $estagiario_id);
        $stmt->execute();
        $stmt->bind_result($count, $candidatura);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {

            $query = "INSERT INTO contratos (id_estagiario, id_empresa, id_vaga) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta de inserção: " . $conn->error);
            }

            $stmt->bind_param('iii', $estagiario_id, $id_empresa, $id_vaga);
            $stmt->execute();
            $stmt->close();

            echo "Contratação realizada com sucesso";
        }
    } catch (Exception $e) {
        echo "Erro ao processar a contratação: " . $e->getMessage();
    } finally {
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
