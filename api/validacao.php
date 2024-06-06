<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['cpf'])) {
        http_response_code(400);
        echo json_encode(['mensagem' => 'Parâmetros inválidos.', 'dados' => $_POST]);
        exit;
    }

    $cpf = $_POST['cpf'];

    $mysqli = new mysqli("localhost", "root", "", "estagiou");

    if ($mysqli->connect_error) {
        http_response_code(500);
        echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados.']);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM usuarios WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    if ($count > 0) {
        $mensagem = "CPF indisponível.";
    } else {
        $mensagem = "CPF disponível.";
    }

    $stmt->close();
    $mysqli->close();

    echo json_encode(['mensagem' => $mensagem]);
}
?>