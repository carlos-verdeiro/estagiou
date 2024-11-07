<?php
session_start();

header('Content-Type: application/json');


// Sanitização e processamento da URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

require '../../assets/PHPMailer/src/PHPMailer.php';
require '../../assets/PHPMailer/src/SMTP.php';
require '../../assets/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$busca = isset($uri[4]) ? $uri[4] : null; //ID da vaga

switch ($busca) {
    case 'redefinicao':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha'], $_POST['token'])) {
            try {
                $senha = trim($_POST['senha']);
                $data = date('Y-m-d H:i:s');
                $token = trim($_POST['token']);

                if (empty($senha) || empty($token)) {
                    throw new Exception("Sem parâmetros.");
                }

                include_once '../conexao.php';

                // Check for token validity
                $stmt_check = $conn->prepare("SELECT COUNT(*), nome, email, tipo, utilizado FROM redefinicao_senha WHERE token = ?");
                $stmt_check->bind_param('s', $token);
                $stmt_check->execute();
                $stmt_check->bind_result($count, $nome, $email, $tipo, $utilizado);
                $stmt_check->fetch();
                $stmt_check->close();

                if ($count < 1) {
                    $response = ['status' => 'error', 'message' => 'Token inválido.'];
                } else if ($utilizado == 1) {
                    $response = ['status' => 'error', 'message' => 'Token já utilizado.'];
                } else if ($utilizado == 2) {
                    $response = ['status' => 'error', 'message' => 'Token expirado.'];
                } else if ($utilizado == 0) {
                    $stmt = $conn->prepare("UPDATE redefinicao_senha SET data_utilizacao = ?, utilizado = 1 WHERE token = ?");
                    $stmt->bind_param('ss', $data, $token);

                    if ($stmt->execute()) {

                        $novaSenha = password_hash($senha, PASSWORD_DEFAULT);

                        switch ($tipo) {
                            case 'estagiario':
                                $sql = "UPDATE estagiario SET senha = ? WHERE email = ?";
                                break;
                            case 'empresa':
                                $sql = "UPDATE empresa SET senha = ? WHERE email = ?";
                                break;
                            case 'escola':
                                $sql = "UPDATE escola SET senha = ? WHERE email = ?";
                                break;
                            default:
                                $response = ['status' => 'error', 'message' => 'Tipo de usuário inválido.'];
                                exit;
                        }

                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('ss', $novaSenha, $email);

                        if ($stmt->execute()) {
                            $response = ['status' => 'success', 'message' => 'Senha redefinida com sucesso.'];
                        } else {
                            $response = ['status' => 'error', 'message' => 'Falha ao redefinir senha.'];
                        }
                    } else {
                        $response = ['status' => 'error', 'message' => 'Erro ao tentar atualizar o uso do token.'];
                    }
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                $response = ['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()];
            }

            echo json_encode($response);
        }
        break;


    default:

        function sendEmail($to, $subject, $message)
        {
            $mail = new PHPMailer(true);

            try {
                // Configurações do servidor
                $mail->isSMTP();                                            // Define o uso do SMTP
                $mail->Host       = 'email-ssl.com.br';                        // Define o servidor SMTP
                $mail->SMTPAuth   = true;                                 // Habilita a autenticação SMTP
                $mail->Username   = 'nao-responda@estagiou.com';              // Seu usuário de e-mail
                $mail->Password   = 'n@0Responda01';                          // Sua senha de e-mail
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
                error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}"); // Log de erro
                return false;                                           // Retorna false em caso de falha
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dado'], $_POST['tipo'], $_POST['metodo'])) {
            $response = []; // Array para armazenar a resposta

            try {
                $metodo = $_POST['metodo'];
                switch ($metodo) {
                    default:
                    case 'email':
                        $email = filter_var(trim($_POST['dado']), FILTER_SANITIZE_EMAIL);
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            throw new Exception("E-mail inválido.");
                        }



                        break;
                    case 'cpf':
                        $cpf = preg_replace('/[^0-9]/', '', trim($_POST['dado']));
                        if (strlen($cpf) < 11 || strlen($cpf) > 11) {
                            throw new Exception("CPF inválido.");
                        }



                        break;
                    case 'cnpj':
                        $cnpj = preg_replace('/[^0-9]/', '', trim($_POST['dado']));

                        if (strlen($cnpj) < 14 || strlen($cnpj) > 14) {
                            throw new Exception("CNPJ inválido.");
                        }



                        break;
                }

                $tipo = trim($_POST['tipo']);

                if (empty($tipo)) {
                    throw new Exception("Tipo de usuário ausente.");
                }

                // Database connection
                include_once '../conexao.php';

                // Function to verify login
                function verificarLogin($conn, $email, $table, $met)
                {
                    $stmt = $conn->prepare("SELECT nome,email FROM $table WHERE $met = ?");
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    return $stmt->get_result()->fetch_assoc();
                }

                // Check user type
                switch ($tipo) {
                    case 'estagiario':
                    case 'escola':
                    case 'empresa':
                        $row = verificarLogin($conn, $email, $tipo, $metodo);
                        break;
                    default:
                        throw new Exception("Tipo de usuário inválido.");
                }

                if ($row) {
                    $nome = $row['nome'];
                    $email = $row['email'];
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
                                            text-align:center;
                                        }
                                        .header {
                                            text-align: center;
                                            padding: 10px 0;
                                        }
                                        .header h1 {
                                            color: #333333;
                                        }
                                        p {
                                            color: #333333;
                                        }
                                        .button {
                                            background-color: #4c4eba;
                                            color: #FFFFFF !important;
                                            padding: 10px 20px;
                                            text-decoration: none;
                                            border-radius: 5px;
                                            display: inline-block;
                                            margin-top: 20px;
                                            transition: background-color 0.3s, box-shadow 0.3s;
                                        }
                                        .button:hover {
                                            background-color: #3b3a9c;
                                            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
                                        <a class='button' href='https://www.estagiou.com/esqueci_senha.php?token=" . htmlspecialchars($token) . "'>Redefinir Senha</a>
                                        <p>Se você não solicitou esta redefinição, ignore este e-mail.</p>
                                        <div class='footer'>
                                            <p>Atenciosamente,<br>Sua Equipe</p>
                                        </div>
                                    </div>
                                </body>
                                </html>
                    ";

                        if (sendEmail($email, $subject, $message)) {
                            $response['status'] = 'success';
                            $response['message'] = 'Email enviado com sucesso.';
                        } else {
                            throw new Exception("Erro ao enviar o e-mail.");
                        }

                        $response['message'] = 'Confira a caixa de entrada do email: ' . $email . ' . Expira em 30 minutos';
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = 'Email já foi utilizado para redefinição de senha.';
                    }
                } else {
                    throw new Exception("E-mail não encontrado.");
                }
            } catch (Exception $e) {
                // Log the error message
                error_log($e->getMessage());
                $response['status'] = 'error';
                $response['message'] = 'Erro: ' . $e->getMessage();
            }

            // Retorna a resposta em JSON
            echo json_encode($response);
        }
        break;
}
exit;
