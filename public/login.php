<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring.js"></script>
<link rel="stylesheet" href="../assets/css/cadastro/action.css">
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando...</title>
</head>

<body>
    <div>
        <h3>Carregando...</h3>
        <l-ring size="200" stroke="10" bg-opacity="0" speed="2" color="#4c4eba"></l-ring>
        <a href="../index.php">Cancelar</a>
    </div>
</body>

</html>

<?php

class BancoDadosException extends Exception
{
}
class ParametrosException extends Exception
{
}

try {
    // Verifica se os parâmetros foram passados via POST
    if (isset($_POST['email'], $_POST['senha'])) {

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Conectar ao banco de dados usando PDO
        $dsn = 'mysql:host=localhost;dbname=estagiou;charset=utf8mb4';
        $username = 'loginAll';
        $password = '123';

        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta preparada para estagiário
        $stmt_estagiario = $conn->prepare("SELECT senha, id FROM estagiario WHERE email = :email");
        $stmt_estagiario->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_estagiario->execute();
        $row_estagiario = $stmt_estagiario->fetch(PDO::FETCH_ASSOC);

        // Verificação de senha para estagiário
        if ($row_estagiario && password_verify($senha, $row_estagiario['senha'])) {
            $mensagem = "Login bem-sucedido como estagiário!";
            session_start();
            session_unset();
            $_SESSION['tipoUsuarioLogin'] = 'estagiario';
            $_SESSION['statusLogin'] = 'autenticado';
            $_SESSION['idUsuarioLogin'] = $row_estagiario['id'];
            header('location: ../dashboard/index.php');
            exit;
        } else {
            // Consulta preparada para escola
            $stmt_escola = $conn->prepare("SELECT senha, id FROM escola WHERE email = :email");
            $stmt_escola->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt_escola->execute();
            $row_escola = $stmt_escola->fetch(PDO::FETCH_ASSOC);

            // Verificação de senha para escola
            if ($row_escola && password_verify($senha, $row_escola['senha'])) {
                $mensagem = "Login bem-sucedido como escola!";

                session_start();
                session_unset();
                $_SESSION['tipoUsuarioLogin'] = 'escola';
                $_SESSION['statusLogin'] = 'autenticado';
                $_SESSION['idUsuarioLogin'] = $row_escola['id'];
                header('location: ../dashboard/index.php');
                exit;
            } else {
                // Consulta preparada para empresa
                $stmt_empresa = $conn->prepare("SELECT senha, id FROM empresa WHERE email = :email");
                $stmt_empresa->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt_empresa->execute();
                $row_empresa = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

                // Verificação de senha para empresa
                if ($row_empresa && password_verify($senha, $row_empresa['senha'])) {
                    $mensagem = "Login bem-sucedido como empresa!";

                    session_start();
                    session_unset();
                    $_SESSION['tipoUsuarioLogin'] = 'empresa';
                    $_SESSION['statusLogin'] = 'autenticado';
                    $_SESSION['idUsuarioLogin'] = $row_empresa['id'];
                    header('location: ../dashboard/index.php');
                    exit;
                } else {
                    $mensagem = "E-mail ou senha incorretos.";
                }
            }
        }

        echo $mensagem;
        exit;
    } else {
        throw new ParametrosException("Não foram passados os parâmetros de forma correta.");
    }
} catch (PDOException $e) {
    echo 'Erro capturado: ' . $e->getMessage() . "\n";
} catch (BancoDadosException $e) {
    echo 'Erro capturado: ' . $e->getMessage() . "\n";
} catch (ParametrosException $e) {
    echo 'Erro capturado: ' . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo 'Erro capturado: ' . $e->getMessage() . "\n";
}
