<?php

session_start();
header('Content-Type: application/json');
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

$busca = isset($uri[5]) ? $uri[5] : null; //ID da vaga
switch ($busca) {
    case 'vaga':

        $idVaga = isset($uri[6]) && is_numeric($uri[6]) ? (int)$uri[6] : null; //ID da vaga
        $partida = isset($uri[7]) && is_numeric($uri[7]) ? (int)$uri[7] : 0; //inicio
        $limiteBusca = isset($uri[8]) && is_numeric($uri[8]) ? (int)$uri[8] : 50; //limite
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
            SELECT c.id AS id_candidatura,
                c.status AS status_candidatura,
                e.id AS id_estagiario,
                e.nome,
                e.sobrenome,
                e.curriculo_id,
                cu.caminho_arquivo
            FROM candidatura c
            INNER JOIN estagiario e ON c.id_estagiario = e.id
            LEFT JOIN curriculo cu ON e.curriculo_id = cu.id
            INNER JOIN vaga v ON c.id_vaga = v.id
            WHERE c.id_vaga = ?
            AND v.empresa_id = ?
            AND c.status != ?
            ORDER BY c.status ASC
            LIMIT ?
            OFFSET ?;

            "); //LEFT JOIN retorna todos independente se tem currículo
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

            echo $json_data;

            // Fecha as consultas
            $stmt->close();
            $stmt_total->close();
        } catch (Exception $e) {
            http_response_code(500); // Erro interno do servidor
            error_log('Erro interno: ' . $e->getMessage()); // Loga o erro para análise
            echo json_encode(['mensagem' => 'Erro interno do servidor.' . $e->getMessage(), 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }

        break;

        header('Content-Type: application/json');

    case 'candidato':
        $idcand = isset($uri[6]) && is_numeric($uri[6]) ? (int)$uri[6] : null;

        if (is_null($idcand)) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parâmetros obrigatórios ausentes.', 'code' => 4]);
            exit;
        }

        try {
            include_once '../../conexao.php';

            $stmt = $conn->prepare("
                        SELECT e.id, e.nome, e.sobrenome, e.email, e.celular, e.telefone, 
                            e.escolaridade, e.formacoes, e.experiencias, e.proIngles, 
                            e.proEspanhol, e.proFrances, e.certificacoes, e.habilidades, 
                            e.disponibilidade, e.curriculo_id, c.caminho_arquivo
                        FROM estagiario e
                        LEFT JOIN curriculo c ON e.curriculo_id = c.id
                        INNER JOIN candidatura ca ON ca.id_estagiario = e.id
                        INNER JOIN vaga v ON ca.id_vaga = v.id
                        WHERE ca.id = ?
                        AND v.empresa_id = ?;
    
    
                    ");

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param("ii", $idcand, $idEmpresa);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $vagas = $result->fetch_assoc();
                echo json_encode($vagas);
            } else {
                echo json_encode(['mensagem' => 'Candidato não encontrado.', 'code' => 4.1]);
            }

            $stmt->close();
        } catch (Exception $e) {
            http_response_code(500);
            error_log('Erro interno: ' . $e->getMessage());
            echo json_encode(['mensagem' => 'Erro interno do servidor.', 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }
        break;
    case 'selecionados':
        include_once('../../conexao.php');

        $response = [];

        try {
            // Verifica a conexão
            if ($conn->connect_error) {
                throw new Exception("Conexão falhou: " . $conn->connect_error);
            }

            // Inicia a transação
            $conn->begin_transaction();

            // Prepara a query para buscar as vagas da empresa
            $queryVagas = $conn->prepare("SELECT id, titulo FROM vaga WHERE status = 1 AND empresa_id = ?");
            $queryVagas->bind_param('i', $idEmpresa);
            $queryVagas->execute();
            $resultVagas = $queryVagas->get_result();

            if ($resultVagas === false) {
                throw new Exception("Erro ao buscar as vagas: " . $conn->error);
            }

            // Verifica se há vagas disponíveis
            if ($resultVagas->num_rows > 0) {
                // Para cada vaga, buscar os candidatos selecionados
                while ($vaga = $resultVagas->fetch_assoc()) {
                    $vagaId = $vaga['id'];
                    $tituloVaga = $vaga['titulo'];

                    // Query para buscar os candidatos selecionados para essa vaga
                    $queryCandidatos = $conn->prepare("
                            SELECT c.id, ca.id AS id_candidatura, c.nome, c.sobrenome, c.formacoes, c.email, c.celular 
                            FROM estagiario AS c
                            INNER JOIN candidatura AS ca ON c.id = ca.id_estagiario
                            WHERE ca.id_vaga = ? AND ca.status = 2
                        ");
                    $queryCandidatos->bind_param('i', $vagaId);
                    $queryCandidatos->execute();
                    $resultCandidatos = $queryCandidatos->get_result();

                    if ($resultCandidatos === false) {
                        throw new Exception("Erro ao buscar os candidatos para a vaga $vagaId: " . $conn->error);
                    }

                    // Lista de candidatos
                    $candidatos = [];
                    if ($resultCandidatos->num_rows > 0) {
                        while ($candidato = $resultCandidatos->fetch_assoc()) {
                            $candidatos[] = [
                                'id' => $candidato['id'],
                                'id_candidatura' => $candidato['id_candidatura'],
                                'nome' => $candidato['nome'],
                                'sobrenome' => $candidato['sobrenome'],
                                'formacoes' => $candidato['formacoes'],
                                'email' => $candidato['email'],
                                'celular' => $candidato['celular']
                            ];
                        }
                    }

                    // Adiciona a vaga e seus candidatos à resposta
                    $response[] = [
                        'titulo' => $tituloVaga,
                        'candidatos' => $candidatos
                    ];
                }
            }

            // Commit a transação se tudo estiver ok
            $conn->commit();
        } catch (Exception $e) {
            // Rollback da transação em caso de erro
            $conn->rollback();

            // Retorna o erro como JSON
            http_response_code(500);
            echo json_encode([
                'error' => $e->getMessage()
            ]);
            exit;
        }

        // Retorna os dados em formato JSON, caso não haja erro
        header('Content-Type: application/json');
        echo json_encode($response, JSON_PRETTY_PRINT); // Formatação opcional

        break;




    default:
        echo json_encode(['mensagem' => 'Parâmetros incorretos.', 'code' => 1]);
        exit;
        break;
}
