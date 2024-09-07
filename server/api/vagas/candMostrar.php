<?php

session_start();

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

// Verificação do método de requisição
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Método não permitido
    echo json_encode(['mensagem' => 'Método de requisição inválido.', 'code' => 1]);
    exit;
}

// Sanitização e processamento da URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$idEmpresa = $_SESSION['idUsuarioLogin'];

$idVaga = isset($uri[5]) && is_numeric($uri[5]) ? (int)$uri[5] : null; //ID da vaga
$partida = isset($uri[6]) && is_numeric($uri[6]) ? (int)$uri[6] : 0; //inicio
$limiteBusca = isset($uri[7]) && is_numeric($uri[7]) ? (int)$uri[7] : 50; //limite

// Verificação básica dos parâmetros obrigatórios
if (is_null($idVaga)) {
    http_response_code(400); // Requisição inválida
    echo json_encode(['mensagem' => 'ID da vaga não fornecido.', 'code' => 4]);
    exit;
}

try {
    include_once '../../conexao.php';

    // Consulta para buscar as vagas e verificar candidaturas
    $stmt = $conn->prepare("
        SELECT estagiario.id, 
        estagiario.nome, 
        estagiario.sobrenome, 
        estagiario.curriculo_id, 
        curriculo.caminho_arquivo
        FROM candidatura
        INNER JOIN estagiario ON candidatura.id_estagiario = estagiario.id
        INNER JOIN curriculo ON estagiario.curriculo_id = curriculo.id
        INNER JOIN vaga ON candidatura.id_vaga = vaga.id
        WHERE candidatura.id_vaga = ?
        AND vaga.empresa_id = ?
        AND candidatura.status != ?
        LIMIT ?
        OFFSET ?;
        ");
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }

    $statusVaga = -1;

    $stmt->bind_param("iiiii", $idVaga, $idEmpresa, $statusVaga, $limiteBusca, $partida);

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

    // Consulta para contar o total de registros, incluindo os mesmos filtros
    $stmt_total = $conn->prepare("
        SELECT COUNT(*) AS total_registros
        FROM candidatura
        INNER JOIN vaga ON candidatura.id_vaga = vaga.id
        WHERE candidatura.id_vaga = ?
        AND vaga.empresa_id = ?
        AND candidatura.status != ?");
    
    if (!$stmt_total) {
        throw new Exception("Erro na preparação da consulta de contagem: " . $conn->error);
    }

    $stmt_total->bind_param("iii", $idVaga, $idEmpresa, $statusVaga);

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
    error_log('Erro interno: ' . $e->getMessage()); // Loga o erro para análise
    echo json_encode(['mensagem' => 'Erro interno do servidor.', 'code' => 3]);
} finally {
    if (isset($conn)) $conn->close();
}
