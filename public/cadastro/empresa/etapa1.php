<?php
session_start();

if ($_SESSION['statusCadastro'] != "andamento") {
    header("Location: action.php");
}

function validaEmail($email)
{
    $conta = "/^[a-zA-Z0-9\._-]+@";
    $dominio = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$/";
    $pattern = $conta . $dominio . $extensao;
    return preg_match($pattern, $email);
}

function validaCPF($cpf)
{
    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os dígitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de dígitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o cálculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

if (
    isset($_POST['cpf']) && !empty($_POST['cpf']) &&
    isset($_POST['nome']) && !empty($_POST['nome']) &&
    isset($_POST['email']) && !empty($_POST['email'])
) {
    $cpf = htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8');
    $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
    $sobrenome = htmlspecialchars($_POST['sobrenome'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    if (validaEmail($email) && validaCPF($cpf)) {
        $_SESSION["cpfEstagiario"] = $cpf;
        $_SESSION["nomeEstagiario"] = $nome;
        $_SESSION["sobrenomeEstagiario"] = $sobrenome;
        $_SESSION["emailEstagiario"] = $email;
        $_SESSION['statusCadastro'] = "andamento";
        $_SESSION['etapaCadastro'] = 2;
        header("Location: etapa2.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 1</title>

    <link rel="stylesheet" href="../../../assets/css/cadastro/etapas.css">

    <!--BIBLIOTECAS-->

    <!--BOOTSTRAP-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../../assets/js/bootstrap.js"></script>
    <!--FIM BOOTSTRAP-->

    <!--JQUERY-->
    <script src="../../../assets/js/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="../../../assets/js/jquery.mask.js"></script><!--PLUGIN JQUERY MASK-->

    <!--FIM JQUERY-->

    <!--FIM BIBLIOTECAS-->

</head>

<body>

    <?php

    //---------HEADER---------
    include_once "../../templates/cadastro/headerEtapa.php";
    //---------HEADER---------

    define('CPF_KEY', 'cpfEstagiario');
    define('NOME_KEY', 'nomeEstagiario');
    define('SOBRENOME_KEY', 'sobrenomeEstagiario');
    define('EMAIL_KEY', 'emailEstagiario');

    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $cpf = pegarSessao(CPF_KEY);
    $nome = pegarSessao(NOME_KEY);
    $sobrenome = pegarSessao(SOBRENOME_KEY);
    $email = pegarSessao(EMAIL_KEY);
    ?>

    <section id="cadastro">

        <form class="formComponent row" method="post" id="formEtapa1" novalidate>
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%;">0%</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>
            
            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--CPF-->
                    <input autofocus type="text" id="cpf" class="form-control w-100" placeholder="CPF" aria-label="CPF" name="cpf" value="<?php echo $cpf; ?>" required>
                    <label for="cpf">CPF *</label>
                    <div class="invalid-feedback" id="feedback-cpf">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME-->
                    <input type="text" id="nome" class="form-control w-100" placeholder="Nome" aria-label="Nome" name="nome" value="<?php echo $nome; ?>" maxlength="50" required>
                    <label for="nome">Nome *</label>
                    <div class="invalid-feedback" id="feedback-nome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--SOBRENOME-->
                    <input type="text" id="sobrenome" class="form-control w-100" placeholder="Sobrenome" aria-label="Sobrenome" value="<?php echo $sobrenome; ?>" maxlength="50" name="sobrenome">
                    <label for="sobrenome">Sobrenome</label>
                    <div class="invalid-feedback" id="feedback-sobrenome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL-->
                    <input type="email" id="email" class="form-control w-100" placeholder="Email" aria-label="Email" name="email" value="<?php echo $email; ?>" required>
                    <label for="email">E-mail *</label>
                    <div class="invalid-feedback" id="feedback-email">
                        Preencha corretamente!
                    </div>
                </div>
            </div>

            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="../cadastro.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">PRÓXIMO</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacao1.js"></script>

</body>

</html>