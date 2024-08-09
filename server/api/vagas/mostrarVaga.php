<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Método não permitido
    echo json_encode(['mensagem' => 'Método de requisição inválido.', 'code' => 1]);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

switch ($uri[5]) {
    case 'empresaVagas':
        if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'empresa') {
            http_response_code(401); // Não autorizado
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEmpresa = $_SESSION['idUsuarioLogin'];

        try {
            // Inclui o arquivo de conexão
            include_once '../../conexao.php';

            // Prepara a consulta para buscar as vagas da empresa
            $stmt = $conn->prepare("SELECT * FROM vaga WHERE empresa_id = ?");
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $idEmpresa);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $vagas = array();

            if ($result->num_rows > 0) {
                // Converte cada linha de resultado em um array associativo
                while ($row = $result->fetch_assoc()) {
                    $vagas[] = $row;
                }
            }

            // Converte o array em JSON
            $json_data = json_encode($vagas);

            // Define o cabeçalho para JSON
            header('Content-Type: application/json');

            // Imprime o JSON
            echo $json_data;

            $stmt->close();
        } catch (Exception $e) {
            http_response_code(500); // Erro interno do servidor
            echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
        } finally {
            // Fechar a conexão
            if (isset($conn)) $conn->close();
        }
        break;

    default:
        http_response_code(404); // Não encontrado
        echo json_encode(['mensagem' => 'Recurso não encontrado.', 'code' => 4]);
        break;
}

exit;
?>
