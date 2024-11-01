<?php
session_start();

function sendEmail($to, $subject, $message) {
    $headers = 'From: no-reply@seusite.com' . "\r\n" .
               'Reply-To: no-reply@seusite.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    
    return mail($to, $subject, $message, $headers);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['tipo'])) {
    try {
        // Validate and sanitize input
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail inválido.");
        }
        $tipo = trim($_POST['tipo']);

        if (empty($tipo)) {
            throw new Exception("Tipo de usuário ausente.");
        }

        // Database connection
        include_once 'server/conexao.php';

        // Function to verify login
        function verificarLogin($conn, $email, $table)
        {
            $stmt = $conn->prepare("SELECT nome FROM $table WHERE email = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        // Check user type
        switch ($tipo) {
            case 'estagiario':
            case 'escola':
            case 'empresa':
                $row = verificarLogin($conn, $email, $tipo);
                break;
            default:
                throw new Exception("Tipo de usuário inválido.");
        }

        if ($row) {
            $nome = $row['nome'];
            $token = bin2hex(random_bytes(16)); // Generates a 32-character token

            // Check if email already used
            $stmt_check = $conn->prepare("SELECT COUNT(*) FROM redefinicao_senha WHERE email = ? AND utilizado = 0");
            $stmt_check->bind_param('s', $email);
            $stmt_check->execute();
            $stmt_check->bind_result($count);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($count == 0) {
                $stmt = $conn->prepare("INSERT INTO redefinicao_senha(nome, email, tipo, token) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('ssss', $nome, $email, $tipo, $token);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao tentar redefinir a senha.");
                }
                
                // Prepare and send the email
                $subject = "Redefinição de Senha";
                $message = "Olá $nome,\n\nPara redefinir sua senha, acesse o seguinte link:\n";
                $message .= "http://localhost/redefinicao.php?token=$token\n\n";
                $message .= "Se você não solicitou esta redefinição, ignore este e-mail.\n\nAtenciosamente,\nSua Equipe.";
                
                if (sendEmail($email, $subject, $message)) {
                    echo 'Email enviado com sucesso.';
                } else {
                    throw new Exception("Erro ao enviar o e-mail.");
                }

                echo 'criado com sucesso.';
            } else {
                echo 'Email já foi utilizado para redefinição de senha.';
            }
        } else {
            throw new Exception("E-mail não encontrado.");
        }
    } catch (Exception $e) {
        // Log the error message
        error_log($e->getMessage());
        echo 'Erro: Ocorreu um problema ao processar sua solicitação.';
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/icons/favicontransparente.ico" type="image/x-icon">
    <title>Estagiou - Esqueci Senha</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="assets/css/index/senha.css">
</head>

<body>
    <?php include_once "assets/templates/index/header_fora.php"; ?>
    <main class="d-flex justify-content-center">
        <form method="post" class="container d-flex justify-content-center row m-auto">
            <h1 class="w-100 text-center">Redefinição de senha</h1>
            <div class="mb-3 wm-50">
                <label for="email" class="form-label">Endereço de E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@email.com" required>
                <div class="form-text">Digite o email referente a conta.</div>
            </div>
            <div class="mb-3 wm-50">
                <label for="tipo" class="form-label">Tipo de usuário</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="estagiario">Estagiário</option>
                    <option value="empresa">Empresa</option>
                    <option value="escola">Instituição de ensino</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary wm-50">Enviar</button>
        </form>
    </main>
    <script src="assets/js/index/senha.js"></script>
</body>

</html>