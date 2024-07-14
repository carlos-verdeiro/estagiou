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
        $stmt_estagiario = $conn->prepare("SELECT senha FROM estagiario WHERE email = :email");
        $stmt_estagiario->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt_estagiario->execute();
        $row_estagiario = $stmt_estagiario->fetch(PDO::FETCH_ASSOC);

        // Verificação de senha para estagiário
        if ($row_estagiario && password_verify($senha, $row_estagiario['senha'])) {
            $mensagem = "Login bem-sucedido como estagiário!";
        } else {
            // Consulta preparada para escola
            $stmt_escola = $conn->prepare("SELECT senha FROM escola WHERE email = :email");
            $stmt_escola->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt_escola->execute();
            $row_escola = $stmt_escola->fetch(PDO::FETCH_ASSOC);

            // Verificação de senha para escola
            if ($row_escola && password_verify($senha, $row_escola['senha'])) {
                $mensagem = "Login bem-sucedido como escola!";
            } else {
                // Consulta preparada para empresa
                $stmt_empresa = $conn->prepare("SELECT senha FROM empresa WHERE email = :email");
                $stmt_empresa->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt_empresa->execute();
                $row_empresa = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

                // Verificação de senha para empresa
                if ($row_empresa && password_verify($senha, $row_empresa['senha'])) {
                    $mensagem = "Login bem-sucedido como empresa!";
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
