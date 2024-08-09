<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once "../conexao.php"; // Inclua a conexão uma vez no início

    //------CPF------
    if (isset($_POST['cpf'])) {
        $cpf = $_POST['cpf'];

        // Validar o formato do CPF
        if (!is_numeric($cpf) || strlen($cpf) != 11) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parâmetros inválidos.', 'code' => 1]);
            exit;
        }

        $stmt = $conn->prepare("SELECT COUNT(*) FROM estagiario WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        
        // Verifica se o CPF está disponível
        $mensagem = ($count == 0);
        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }

    //------RG------
    if (isset($_POST['rg'])) {
        $rg = $_POST['rg'];

        // Validar o formato do RG
        if (!is_numeric($rg) || strlen($rg) != 9) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parâmetros inválidos.', 'code' => 1]);
            exit;
        }

        $stmt = $conn->prepare("SELECT COUNT(*) FROM estagiario WHERE rg = ?");
        $stmt->bind_param("s", $rg);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // Verifica se o RG está disponível
        $mensagem = ($count == 0);
        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }

    //------EMAIL------
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Validar o comprimento do email
        if (strlen($email) > 100 || strlen($email) < 1) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'Parâmetro inválido.', 'code' => 1]);
            exit;
        }

        // Verificar em várias tabelas
        $tables = ['estagiario', 'empresa', 'escola'];
        $mensagem = true; // Assumir disponível inicialmente

        foreach ($tables as $table) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $mensagem = false; // EMAIL indisponível
                break;
            }
        }

        $conn->close();
        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }

    //------CNPJ------
    if (isset($_POST['cnpj'])) {
        $cnpj = $_POST['cnpj'];

        // Validar o formato do CNPJ
        if (!is_numeric($cnpj) || strlen($cnpj) != 14) {
            http_response_code(400);
            echo json_encode(['mensagem' => 'CNPJ inválido.', 'code' => 0]);
            exit;
        }

        // Verificar em várias tabelas
        $tables = ['empresa', 'escola'];
        $mensagem = true; // Assumir disponível inicialmente

        foreach ($tables as $table) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE cnpj = ?");
            $stmt->bind_param("s", $cnpj);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                $mensagem = false; // CNPJ indisponível
                break;
            }
        }

        $conn->close();
        echo json_encode(['mensagem' => $mensagem]);
        exit;
    }
}
?>
