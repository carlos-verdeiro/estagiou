<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['cpf']) && !is_numeric($_POST['cpf'])) {
        http_response_code(400);
        echo json_encode(['mensagem' => 'Parametros invalidos. TYPE', 'code' => 0]);
        exit;
    }

    if (strlen($_POST['cpf']) != 11) {
        http_response_code(400);
        echo json_encode(['mensagem' => 'Parametros invalidos. NUM', 'code' => 1]);
        exit;
    }

    $cpf = $_POST['cpf'];

    $mysqli = new mysqli("localhost", "root", "", "estagiou");

    if ($mysqli->connect_error) {
        http_response_code(500);
        echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados.', 'code' => 2]);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM usuarios WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    if ($count > 0) {
        $mensagem = false;//CPF indisponível
    } else {
        $mensagem = true;//CPF disponível
    }

    $stmt->close();
    $mysqli->close();

    echo json_encode(['mensagem' => $mensagem]);
}
?>