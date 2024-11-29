<?php
session_start();

header('Content-Type: application/json');


// Sanitização e processamento da URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

require '../../../assets/PHPMailer/src/PHPMailer.php';
require '../../../assets/PHPMailer/src/SMTP.php';
require '../../../assets/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$busca = isset($uri[4]) ? $uri[4] : null; //ID da vaga

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['email'], $_POST['mensagem'])) {
    $response = []; // Array para armazenar a resposta

    try {

        include_once '../../conexao.php';


            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $mensagem = $_POST['mensagem'];

            // Prepare and send the email
            $subject = "Suporte ao cliente";

            $message = "
                            <!DOCTYPE html>
                                <html lang='pt-BR'>
                                <head>
                                    <meta charset='UTF-8'>
                                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                    <title>Suporte ao cliente</title>
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
                                            <h1>Suporte ao cliente</h1>
                                        </div>
                                        <p>Olá,</p>
                                        <p>Solicitado suporte estagiou para <strong>$nome</strong></p>
                                        <p>E-mail do usuário: <strong>$email</strong></p>
                                        <p>Mensagem: $mensagem</p>
                                    </div>
                                </body>
                                </html>
                    ";

            if (sendEmail('suporte@estagiou.com', $subject, $message)) {
                $response['status'] = 'success';
                $response['message'] = 'Mensagem enviada com sucesso. Entraremos em contato';
            } else {
                throw new Exception("Erro ao enviar o mensagem.");
            }



            $response['message'] = 'Mensagem enviada com sucesso. Entraremos em contato';


        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        error_log($e->getMessage());
        $response['status'] = 'error';
        $response['message'] = 'Erro: ' . $e->getMessage();
    }

    // Retorna a resposta em JSON
    echo json_encode($response);
}
