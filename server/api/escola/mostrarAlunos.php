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

    case 'alunos':
        if (
            !isset($_SESSION['statusLogin'], $_SESSION['tipoUsuarioLogin']) ||
            $_SESSION['statusLogin'] !== 'autenticado' ||
            $_SESSION['tipoUsuarioLogin'] !== 'escola'
        ) {
            http_response_code(401);
            echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
            exit;
        }

        $idEstagiario = $_SESSION['idUsuarioLogin'];

        try {
            include_once '../../conexao.php';

            $stmt = $conn->prepare("SELECT a.id_estagiario, 
                                    e.id,e.nome,e.sobrenome,e.estado_civil,e.cpf,e.rg,e.data_nascimento,e.genero,e.nacionalidade,e.email,e.celular,e.telefone,e.endereco,e.numero,e.complemento,e.bairro,e.cidade,e.estado,e.cep,e.pais,escolaridade,e.formacoes,e.experiencias,e.proIngles,e.proEspanhol,e.proFrances,e.certificacoes,e.habilidades,e.disponibilidade,e.cnh,e.dependentes,rg_org_emissor,e.rg_estado_emissor
                                    FROM aluno AS a
                                    LEFT JOIN estagiario AS e ON e.id = a.id_estagiario
                                    WHERE a.id_escola = ?
                                    ");
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
