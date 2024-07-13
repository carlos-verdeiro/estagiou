<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cpf'])) {
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

        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM estagiario WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count > 0) {
            $mensagem = false; //CPF indisponível
        } else {
            $mensagem = true; //CPF disponível
        }

        $stmt->close();
        $mysqli->close();

        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }
    //------RG------
    if (isset($_POST['rg'])) {

        if (!isset($_POST['rg']) && !is_numeric($_POST['rg'])) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parametros invalidos. TYPE', 'code' => 0]);
            exit;
        }
        if (strlen($_POST['rg']) != 9) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parametros invalidos. NUM', 'code' => 1]);
            exit;
        }
        $rg = $_POST['rg'];

        $mysqli = new mysqli("localhost", "root", "", "estagiou");

        if ($mysqli->connect_error) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados.', 'code' => 2]);
            exit;
        }

        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM estagiario WHERE rg = ?");
        $stmt->bind_param("s", $rg);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count > 0) {
            $mensagem = false; //RG indisponível
        } else {
            $mensagem = true; //RG disponível
        }

        $stmt->close();
        $mysqli->close();

        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }
    //------EMAIL------
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    
        if (strlen($email) > 100 || strlen($email) < 1) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parâmetro inválido.', 'code' => 1]);
            exit;
        }
    
        $mysqli = new mysqli("localhost", "estagiarioSelect", "123", "estagiou");
    
        if ($mysqli->connect_error) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro ao conectar ao banco de dados.', 'code' => 2]);
            exit;
        }
    
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM estagiario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
    
        $mensagem = ($count > 0) ? false : true; // Email disponível se $count == 0
    
        $stmt->close();
        $mysqli->close();
    
        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }
}
