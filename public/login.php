<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/cadastro/action.css">
</head>

<body>
    <div>
        <?php

        class BancoDadosException extends Exception {}
        class ParametrosException extends Exception {}

        try {
            // Verifica se os parâmetros foram passados via POST
            if (empty($_POST['email']) || empty($_POST['senha'])) {
                throw new ParametrosException("Parâmetros ausentes.");
            }

            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Inclui o arquivo de conexão
            include_once '../server/conexao.php';

            // Função para verificar o login em diferentes tabelas
            function verificarLogin($conn, $email, $senha, $table)
            {
                $stmt = $conn->prepare("SELECT senha, id FROM $table WHERE email = ?");
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row && password_verify($senha, $row['senha'])) {
                    return $row['id'];
                }
                return false;
            }

            // Tenta autenticar o usuário em diferentes tabelas
            $id = verificarLogin($conn, $email, $senha, 'estagiario');
            if ($id !== false) {
                $tipoUsuario = 'estagiario';
            } else {
                $id = verificarLogin($conn, $email, $senha, 'escola');
                if ($id !== false) {
                    $tipoUsuario = 'escola';
                } else {
                    $id = verificarLogin($conn, $email, $senha, 'empresa');
                    if ($id !== false) {
                        $tipoUsuario = 'empresa';
                    } else {
                        throw new Exception("E-mail ou senha incorretos.");
                    }
                }
            }

            // Inicializa a sessão
            session_start();
            session_unset();
            $_SESSION['tipoUsuarioLogin'] = $tipoUsuario;
            $_SESSION['statusLogin'] = 'autenticado';
            $_SESSION['idUsuarioLogin'] = $id;
            $_SESSION['emailUsuarioLogin'] = $email;

            // Redireciona para o dashboard
            header('Location: ../dashboard/index.php');
            exit;
        } catch (ParametrosException $e) {
            echo '<h3>Erro: ' . $e->getMessage() . '</h3>';
        } catch (Exception $e) {
            echo '<h3>Erro: ' . $e->getMessage() . '</h3>';
        }
        ?>
        <a href="../index.php?entrar">Voltar</a>
    </div>
</body>

</html>