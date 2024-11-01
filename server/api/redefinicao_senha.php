<?php
session_start();

// Inclui os arquivos do PHPMailer
require '../../assets/PHPMailer/src/PHPMailer.php';
require '../../assets/PHPMailer/src/SMTP.php';
require '../../assets/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();                                            // Define o uso do SMTP
        $mail->Host       = 'email-ssl.com.br';                        // Define o servidor SMTP
        $mail->SMTPAuth   = true;                                 // Habilita a autenticação SMTP
        $mail->Username   = 'nao-responda@estagiou.com';              // Seu usuário de e-mail
        $mail->Password   = 'Ac3ss0Est@g10u';                          // Sua senha de e-mail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Para usar com porta 465
        $mail->Port       = 465;      // Porta TCP para se conectar
        $mail->CharSet = 'UTF-8';

        // Destinatários
        $mail->setFrom('nao-responda@estagiou.com', 'Estagiou');
        $mail->addAddress($to);                                   // Adiciona um destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true);                                      // Define o formato do e-mail como HTML
        $mail->Subject = $subject;                                // Assunto do e-mail
        $mail->Body    = $message;                               // Corpo do e-mail

        $mail->send();                                           // Envia o e-mail
        return true;
    } catch (Exception $e) {
        echo ("Erro ao enviar e-mail: {$mail->ErrorInfo}"); // Log de erro
        return false;                                           // Retorna false em caso de falha
    }
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
        include_once '../conexao.php';

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

                $message = "
                <!DOCTYPE html>
                <html lang='pt-BR'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Redefinição de Senha</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 20px;
                        }
                        .container {
                            background-color: #ffffff;
                            border-radius: 8px;
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            padding: 20px;
                            max-width: 600px;
                            margin: auto;
                        }
                        .header {
                            text-align: center;
                            padding: 10px 0;
                        }
                        .header h1 {
                            color: #333333;
                        }
                        .button {
                            background-color: #4c4eba;
                            color: white;
                            padding: 10px 20px;
                            text-decoration: none;
                            border-radius: 5px;
                            display: inline-block;
                            margin-top: 20px;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 14px;
                            color: #777777;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Redefinição de Senha</h1>
                        </div>
                        <p>Olá <strong>$nome</strong>,</p>
                        <p>Para redefinir sua senha, acesse o seguinte link:</p>
                        <a class='button' href='https://www.estagiou.com/redefinicao.php?token=" . htmlspecialchars($token) . "'>Redefinir Senha</a>
                        <p>Se você não solicitou esta redefinição, ignore este e-mail.</p>
                        <div class='footer'>
                            <p>Atenciosamente,<br>Sua Equipe</p>
                        </div>
                    </div>
                </body>
                </html>
                ";


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