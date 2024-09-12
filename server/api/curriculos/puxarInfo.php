<?php
session_start();

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Verifica se o estagiario está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || !isset($_SESSION['idUsuarioLogin'])) {
        http_response_code(401); // Código de resposta para não autorizado
        $response['message'] = "Erro: Usuário não autenticado.";
        echo json_encode($response);
        exit;
    }

    $tipoUsuario = $_SESSION['tipoUsuarioLogin'];
    $id = $_SESSION['idUsuarioLogin'];

    switch ($tipoUsuario) {
        case 'estagiario':
            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Prepara a consulta
                $stmt = $conn->prepare("SELECT escolaridade, formacoes, experiencias, proIngles, proEspanhol, proFrances, certificacoes, habilidades, disponibilidade FROM estagiario WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                // Vincula o ID do estagiário ao parâmetro
                $stmt->bind_param('i', $id);
                $stmt->execute();

                // Processa o resultado
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();

                if ($data) {
                    $response['success'] = true;
                    $response['data'] = $data;
                } else {
                    http_response_code(404); // Código de resposta para não encontrado
                    $response['message'] = "Estagiário não encontrado.";
                }

                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao recuperar informações: " . $e->getMessage();
            } finally {
                // Fecha a conexão
                if (isset($conn)) $conn->close();
            }
            break;

        default:
            http_response_code(400); // Código de resposta para requisição ruim
            $response['message'] = "Falha: Tipo de usuário desconhecido.";
            break;
    }
} else {
    http_response_code(405); // Código de resposta para método não permitido
    $response['message'] = "Método de requisição inválido.";
}

// Envia a resposta JSON
echo json_encode($response);
exit;
