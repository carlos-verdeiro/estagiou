<?php
session_start();

// Verificação se a sessão foi iniciada corretamente
if (session_status() !== PHP_SESSION_ACTIVE) {
    http_response_code(500); // Erro interno do servidor
    echo json_encode(['mensagem' => 'Erro ao iniciar a sessão.', 'code' => 3]);
    exit;
}

// Verificação do método de requisição
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Método não permitido
    echo json_encode(['mensagem' => 'Método de requisição inválido.', 'code' => 1]);
    exit;
}

// Sanitização e processamento da URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Validação do segmento da URI
if (!isset($uri[5]) || empty($uri[5])) {
    http_response_code(404); // Não encontrado
    echo json_encode(['mensagem' => 'Recurso não especificado.', 'code' => 4]);
    exit;
}

switch ($uri[5]) {
    case 'empresaVagas':
        // Verificação de autenticação e tipo de usuário
        if (
            !isset($_SESSION['statusLogin'], $_SESSION['tipoUsuarioLogin']) ||
            $_SESSION['statusLogin'] !== 'autenticado' ||
            $_SESSION['tipoUsuarioLogin'] !== 'empresa'
        ) {
            http_response_code(401); // Não autorizado
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEmpresa = $_SESSION['idUsuarioLogin'];

        try {
            // Inclui o arquivo de conexão
            include_once '../../conexao.php';

            // Prepara a consulta para buscar as vagas da empresa com a contagem de candidatos
            $stmt = $conn->prepare("
                SELECT vaga.*, 
                       IFNULL(candidaturas.total_candidatos, 0) AS total_candidatos
                FROM vaga
                LEFT JOIN (
                    SELECT id_vaga, COUNT(*) AS total_candidatos
                    FROM candidatura
                    GROUP BY id_vaga
                ) AS candidaturas ON vaga.id = candidaturas.id_vaga
                WHERE vaga.empresa_id = ?
            ");
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("i", $idEmpresa);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $vagas = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $vagas[] = $row;
                }
            }

            // Converte o array em JSON
            $json_data = json_encode($vagas);

            // Define o cabeçalho para JSON
            header('Content-Type: application/json');
            echo $json_data;

            $stmt->close();
        } catch (Exception $e) {
            http_response_code(500); // Erro interno do servidor
            echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }
        break;


    case 'estagiarioVagas':
        // Verificação de autenticação e tipo de usuário
        if (
            !isset($_SESSION['statusLogin'], $_SESSION['tipoUsuarioLogin']) ||
            $_SESSION['statusLogin'] !== 'autenticado' ||
            $_SESSION['tipoUsuarioLogin'] !== 'estagiario'
        ) {
            http_response_code(401); // Não autorizado
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEstagiario = $_SESSION['idUsuarioLogin'];
        $partida = isset($uri[6]) && is_numeric($uri[6]) ? (int)$uri[6] : 0;
        $limiteBusca = isset($uri[7]) && is_numeric($uri[7]) ? (int)$uri[7] : 30;

        try {
            include_once '../../conexao.php';

            // Consulta para buscar as vagas e verificar candidaturas
            $stmt = $conn->prepare("
                SELECT vaga.*, empresa.nome AS empresa_nome, 
                       CASE WHEN candidatura.id_vaga IS NOT NULL THEN true ELSE false END AS candidatou
                FROM vaga
                INNER JOIN empresa ON vaga.empresa_id = empresa.id
                LEFT JOIN candidatura ON candidatura.id_vaga = vaga.id AND candidatura.id_estagiario = ?
                WHERE vaga.status = ?
                ORDER BY vaga.titulo
                LIMIT ?
                OFFSET ?
            ");
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $statusVaga = 1;
            $candidatado = 0;

            $stmt->bind_param("iiii", $idEstagiario, $statusVaga, $limiteBusca, $partida);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $vagas = [];

            if ($result->num_rows > 0) {
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
            echo $json_data;

            // Fecha as consultas
            $stmt->close();
            $stmt_total->close();
        } catch (Exception $e) {
            http_response_code(500); // Erro interno do servidor
            echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }
        break;


    case 'estagiarioVagasCandidato':
        // Verificação de autenticação e tipo de usuário
        if (
            !isset($_SESSION['statusLogin'], $_SESSION['tipoUsuarioLogin']) ||
            $_SESSION['statusLogin'] !== 'autenticado' ||
            $_SESSION['tipoUsuarioLogin'] !== 'estagiario'
        ) {
            http_response_code(401); // Não autorizado
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEstagiario = $_SESSION['idUsuarioLogin'];
        $partida = isset($uri[6]) && is_numeric($uri[6]) ? (int)$uri[6] : 0;
        $limiteBusca = isset($uri[7]) && is_numeric($uri[7]) ? (int)$uri[7] : 30;

        try {
            include_once '../../conexao.php';

            // Consulta para buscar as vagas e verificar candidaturas
            $stmt = $conn->prepare("
                    SELECT candidatura.*, vaga.*, empresa.nome AS empresa_nome
                    FROM candidatura
                    INNER JOIN vaga ON candidatura.id_vaga = vaga.id
                    INNER JOIN empresa ON vaga.empresa_id = empresa.id
                    WHERE candidatura.id_estagiario = ?
                    AND vaga.status = ?
                    ORDER BY vaga.titulo
                    LIMIT ?
                    OFFSET ?
                ");

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $statusVaga = 1; // Vagas ativas
            $stmt->bind_param("iiii", $idEstagiario, $statusVaga, $limiteBusca, $partida);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $vagas = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $vagas[] = $row;
                }
            }

            // Consulta para contar o total de registros com os mesmos critérios
            $stmt_total = $conn->prepare("
                    SELECT COUNT(*) AS total_registros 
                    FROM candidatura
                    INNER JOIN vaga ON candidatura.id_vaga = vaga.id
                    WHERE candidatura.id_estagiario = ?
                    AND vaga.status = ?
                ");
            if (!$stmt_total) {
                throw new Exception("Erro na preparação da consulta de contagem: " . $conn->error);
            }

            $stmt_total->bind_param("ii", $idEstagiario, $statusVaga);

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
            echo $json_data;

            // Fecha as consultas
            $stmt->close();
            $stmt_total->close();
        } catch (Exception $e) {
            http_response_code(500); // Erro interno do servidor
            echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }
        break;

    default:
        http_response_code(404); // Não encontrado
        echo json_encode(['mensagem' => 'Recurso não encontrado.', 'code' => 4]);
        break;
}

exit;
