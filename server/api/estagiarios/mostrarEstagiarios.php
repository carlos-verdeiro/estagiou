<?php

session_start();
header('Content-Type: application/json');
// Verificação de autenticação e tipo de usuário

// Verificação do método de requisição
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Método não permitido
    echo json_encode(['mensagem' => 'Método de requisição inválido.', 'code' => 1]);
    exit;
}

// Sanitização e processamento da URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$busca = isset($uri[5]) ? $uri[5] : null;
switch ($busca) {
    case 'estagiarios':

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


        // -----PAGINAÇÃO
        $partida = isset($uri[6]) && is_numeric($uri[6]) ? (int)$uri[6] : 0; //inicio
        $limiteBusca = isset($uri[7]) && is_numeric($uri[7]) ? (int)$uri[7] : 50; //limite

        try {
            include_once '../../conexao.php';

            // Consulta para buscar as vagas e verificar candidaturas
            $stmt = $conn->prepare("
            SELECT c.id AS id_contrato,
                c.data_contratacao,
                c.caminho_anexo,
                c.nome_anexo,
                c.observacoes,
                c.data_termino,
                c.status,

                e.id AS id_estagiario,
                e.nome AS nome_estagiario,
                e.sobrenome AS sobrenome_estagiario,
                e.email AS email_estagiario,
                e.celular AS celular_estagiario,
                
                v.titulo AS titulo_vaga,
                v.descricao AS descricao_vaga
            FROM contratos c
            INNER JOIN estagiario e ON c.id_estagiario = e.id
            INNER JOIN vaga v ON c.id_vaga = v.id
            WHERE c.id_empresa = ?
            ORDER BY c.data_contratacao ASC
            LIMIT ?
            OFFSET ?;

            ");

            $statusVaga = -1;

            $stmt->bind_param("iii", $idEmpresa, $limiteBusca, $partida);
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $contratos = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $contratos[] = $row;
                }
            }

            // Consulta para contar o total de registros, incluindo os mesmos filtros
            $stmt_total = $conn->prepare("
            SELECT COUNT(*) AS total_registros
            FROM contratos
            WHERE contratos.id_empresa = ?
            ");

            if (!$stmt_total) {
                throw new Exception("Erro na preparação da consulta de contagem: " . $conn->error);
            }

            $stmt_total->bind_param("i", $idEmpresa);

            if (!$stmt_total->execute()) {
                throw new Exception("Erro ao executar a consulta de contagem: " . $stmt_total->error);
            }

            $total_result = $stmt_total->get_result();
            $total_registros = $total_result->fetch_assoc()['total_registros'];

            // Converte o array em JSON, incluindo o total de registros
            $json_data = json_encode([
                'total_registros' => $total_registros,
                'contratos' => $contratos
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

    case 'estagiario':
        if (
            !isset($_SESSION['statusLogin'], $_SESSION['tipoUsuarioLogin']) ||
            $_SESSION['statusLogin'] !== 'autenticado' ||
            $_SESSION['tipoUsuarioLogin'] !== 'estagiario'
        ) {
            http_response_code(401);
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEstagiario = $_SESSION['idUsuarioLogin'];

        try {
            include_once '../../conexao.php';

            $stmt = $conn->prepare("SELECT nome,sobrenome,estado_civil,cpf,rg,data_nascimento,genero,nacionalidade,email,celular,telefone,endereco,numero,complemento,bairro,cidade,estado,cep,pais FROM estagiario WHERE id = ?;");
            $stmt->bind_param("i", $idEstagiario);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch data as associative array
            echo json_encode($data);

            $stmt->close();
        } catch (Exception $e) {
            http_response_code(500);
            error_log('Erro interno: ' . $e->getMessage());
            echo json_encode(['mensagem' => 'Erro interno do servidor: ' . $e->getMessage(), 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }

        break;



    default:
        echo json_encode(['mensagem' => 'Parâmetros incorretos.', 'code' => 1]);
        exit;
        break;
}
