<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar autenticação e tipo de usuário
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] != "empresa") {
        http_response_code(401); // Código apropriado para não autorizado
        die(json_encode(["error" => "Erro: Usuário não autenticado."]));
    }

    // Sanitização e processamento da URI
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    $idEmpresa = $_SESSION['idUsuarioLogin'] ?? null; // Adiciona verificação de existência

    // Ação recebida da URI
    $busca = $uri[5] ?? null;

    // Verificar se a ação é válida
    if ($busca === 'selecionar') {
        $idCand = $_POST['idCand'] ?? null;

        // Validação do ID do candidato
        if (!is_numeric($idCand) || $idCand <= 0) {
            die(json_encode(["error" => "Erro: ID inválido.", "code" => 0]));
        }

        try {
            include_once '../../conexao.php';

            // Preparação da consulta para verificar o status da candidatura
            $query = "SELECT status FROM candidatura WHERE id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param('i', $idCand);
            $stmt->execute();
            $stmt->bind_result($statusAtual);
            if (!$stmt->fetch()) {
                throw new Exception("Candidatura não encontrada.");
            }
            $stmt->close();

            // Alternar status entre 1 (não selecionado) e 2 (selecionado)
            $novoStatus = ($statusAtual == 2) ? 1 : 2;

            // Preparar e executar a consulta de atualização do status
            $updateQuery = "UPDATE candidatura SET status = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if (!$updateStmt) {
                throw new Exception("Erro na preparação da consulta de atualização: " . $conn->error);
            }

            $updateStmt->bind_param('ii', $novoStatus, $idCand);
            if (!$updateStmt->execute()) {
                throw new Exception("Erro ao atualizar a inscrição: " . $updateStmt->error);
            }
            $updateStmt->close();

            // Retorno de resposta JSON com a mensagem apropriada
            $mensagem = $novoStatus == 2 ? "Candidato selecionado!" : "Seleção removida!";
            $codigo = $novoStatus == 2 ? 2 : 1;

            echo json_encode(["message" => $mensagem, "code" => $codigo, "idCandidatura" => $idCand]);

        } catch (Exception $e) {
            // Captura e exibe erros
            echo json_encode(["error" => "Erro ao processar a candidatura: " . $e->getMessage()]);
        } finally {
            // Garantir o fechamento da conexão com o banco de dados
            if (isset($conn)) {
                $conn->close();
            }
        }
    } else {
        // Ação não reconhecida
        echo json_encode(["error" => "Ação inválida."]);
    }
} else {
    // Método de requisição não é POST
    http_response_code(405); // Código apropriado para método não permitido
    echo json_encode(["error" => "Método de requisição inválido."]);
}
exit;
