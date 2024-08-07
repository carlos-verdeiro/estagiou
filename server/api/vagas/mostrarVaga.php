<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    die("Método de requisição inválido.");
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

switch ($uri[5]) {
    case 'empresaVagas':
        if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'empresa') {
            echo json_encode(array("mensagem" => "Usuário não autenticado"));
            exit;
        }

        $idEmpresa = $_SESSION['idUsuarioLogin'];

        $mysqli = new mysqli("localhost", "root", "", "estagiou");
        if ($mysqli->connect_error) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados.', 'code' => 2]);
            exit;
        }

        $stmt = $mysqli->prepare("SELECT * FROM vaga WHERE empresa_id = ?");
        $stmt->bind_param("i", $idEmpresa);

        if (!$stmt->execute()) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao executar a consulta.', 'code' => 3]);
            exit;
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
        $mysqli->close();
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array("mensagem" => "Method not allowed"));
        break;
}

exit;
