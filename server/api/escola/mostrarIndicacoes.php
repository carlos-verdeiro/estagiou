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

    case 'escola':
        if (
            !isset($_SESSION['statusLogin'], $_SESSION['tipoUsuarioLogin']) ||
            $_SESSION['statusLogin'] !== 'autenticado' ||
            $_SESSION['tipoUsuarioLogin'] !== 'escola'
        ) {
            http_response_code(401);
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $id_escola = $_SESSION['idUsuarioLogin'];

        try {
            include_once '../../conexao.php';

            $stmt = $conn->prepare("SELECT 
                                    v.id AS id_vaga,
                                    v.titulo,

                                    e.id AS id_estagiario,
                                    e.nome,
                                    e.sobrenome,
                                    e.email,
                                    e.cpf,

                                    i.id AS id_indicacao

                                    FROM indicacao AS i
                                    LEFT JOIN vaga AS v ON v.id = i.id_vaga
                                    LEFT JOIN estagiario AS e ON e.id = i.id_estagiario
                                    WHERE i.id_escola = ?
                                    ");
            $stmt->bind_param("i", $id_escola);

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
