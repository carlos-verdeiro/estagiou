<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] != "empresa") {
        http_response_code(200);
        die("Erro: Usuário não autenticado.");
    }


    // Sanitização e processamento da URI
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    $idEmpresa = $_SESSION['idUsuarioLogin'];

    $busca = isset($uri[5]) ? $uri[5] : null; //ID da vaga

    switch ($busca) {
        case 'selecionar':
            $idCandidato = $_POST['idCand'] || null;
            $idVaga = $_POST['idVaga'] || null;

            if (!is_numeric($vaga_id) || $vaga_id <= 0) {
                die("Erro: ID da vaga inválido.");
            }
            if (!is_numeric($idCandidato) || $idCandidato <= 0) {
                die("Erro: ID do candidato inválido.");
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


            break;

        default:
            # code...
            break;
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
