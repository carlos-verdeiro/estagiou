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

    case 'estagiarioVagas':
        if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'estagiario') {
            http_response_code(401); // Não autorizado
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEstagiario = $_SESSION['idUsuarioLogin'];

        if (isset($uri[6]) && is_numeric($uri[6])) {
            $partida = $uri[6];
        } else {
            $partida = 0;
        }

        if (isset($uri[7]) && is_numeric($uri[7])) {
            $limiteBusca = $uri[7];
        } else {
            $limiteBusca = 30;
        }

        try {
            // Inclui o arquivo de conexão
            include_once '../../conexao.php';

            // Consulta para buscar os dados paginados
            $stmt = $conn->prepare("SELECT * FROM vaga WHERE status = ? ORDER BY titulo LIMIT ? OFFSET ?");
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }
            $statusVaga = 1;
            $stmt->bind_param("iii", $statusVaga, $limiteBusca, $partida);

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

            // Consulta para contar o total de registros
            $stmt_total = $conn->prepare("SELECT COUNT(*) AS total_registros FROM vaga WHERE status = ?");
            if (!$stmt_total) {
                throw new Exception("Erro na preparação da consulta de contagem: " . $conn->error);
            }
            $stmt_total->bind_param("i", $statusVaga);

            if (!$stmt_total->execute()) {
                throw new Exception("Erro ao executar a consulta de contagem: " . $stmt_total->error);
            }

            $total_result = $stmt_total->get_result();
            $total_registros = $total_result->fetch_assoc()['total_registros'];

            // Converte o array em JSON, incluindo o total de registros
            $json_data = json_encode([
                'total_registros' => $total_registros,
                'vagas' => $vagas
            ]);

            // Define o cabeçalho para JSON
            header('Content-Type: application/json');

            // Imprime o JSON
            echo $json_data;

            // Fecha as consultas
            $stmt->close();
            $stmt_total->close();
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
