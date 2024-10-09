<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] != "empresa") {
        http_response_code(200);
        die("Erro: Usuário não autenticado.");
    }

    // Sanitização e processamento da URI
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    $idEmpresa = $_SESSION['idUsuarioLogin'];

    $busca = isset($uri[5]) ? $uri[5] : null;

    switch ($busca) {
        case 'selecionar':
            $idCand = $_POST['idCand'] ?? null;

            
            if (!is_numeric($idCand) || $idCand <= 0) {
                die(json_encode(["error" => "Erro: ID inválido.", "code" => 0]));
            }

            try {
                include_once '../../conexao.php';

                // Verificar status da candidatura existente
                $query = "SELECT status FROM candidatura WHERE id = ?";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('i', $idCand);
                $stmt->execute();
                $stmt->bind_result($statusAtual);
                $stmt->fetch();
                $stmt->close();

                $novoStatus = ($statusAtual == 2) ? 1 : 2;

                $updateQuery = "UPDATE candidatura SET status = ? WHERE id = ?";
                $updateStmt = $conn->prepare($updateQuery);
                if (!$updateStmt) {
                    throw new Exception("Erro na preparação da consulta de atualização: " . $conn->error);
                }

                $updateStmt->bind_param('ii', $novoStatus, $idCand, );
                if (!$updateStmt->execute()) {
                    throw new Exception("Erro ao atualizar a inscrição: " . $updateStmt->error);
                }
                $updateStmt->close();

                $mensagem = $novoStatus == 2 ? "Candidato selecionado!" : "Seleção removida!";
                $codigo = $novoStatus == 2 ? 2 : 1;
                
                // Incluindo o ID da candidatura na resposta
                echo json_encode(["message" => $mensagem, "code" => $codigo, "idCandidatura" => $idCand]);
            } catch (Exception $e) {
                echo json_encode(["error" => "Erro ao processar a candidatura: " . $e->getMessage()]);
            } finally {
                if (isset($conn)) $conn->close();
            }

            break;

        default:
            echo "Ação inválida.";
            break;
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
