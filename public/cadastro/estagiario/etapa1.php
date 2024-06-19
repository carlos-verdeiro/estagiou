<?php
session_start();

function validaEmail($email)
{
    $conta = "/^[a-zA-Z0-9\._-]+@";
    $domino = "[a-zA-Z0-9\._-]+.";
    $extensao = "([a-zA-Z]{2,4})$/";
    $pattern = $conta . $domino . $extensao;
    if (preg_match($pattern, $email, $check))
        return true;
    else
        return false;
}

function validaCPF($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
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



if (isset($_POST['cpf']) && $_POST['cpf'] != NULL && isset($_POST['nome']) && $_POST['nome'] != NULL && isset($_POST['sobrenome']) && isset($_POST['email']) && $_POST['email'] != NULL) {

    if (validaEmail($_POST['email']) && validaCPF($_POST['cpf'])) {
        $_SESSION["cpfEstagiario"] = $_POST['cpf'];
        $_SESSION["nomeEstagiario"] = $_POST['nome'];
        $_SESSION["sobrenomeEstagiario"] = $_POST['sobrenome'];
        $_SESSION["emailEstagiario"] = $_POST['email'];
        $_SESSION['statusCadastro'] = "andamento";
        $_SESSION['etapaCadastro'] = 2;
        header("location: etapa" . $_SESSION['etapaCadastro'] . ".php");
        exit;
    } else {
        $_SESSION['etapaCadastro'] = 1;
    }


} else {
    $_SESSION['etapaCadastro'] = 1;
}

?>

<!DOCTYPE html>
<html lang="pt-be">

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

    $cpf = (isset($_SESSION["cpfEstagiario"]) && $_SESSION["cpfEstagiario"] != NULL) ? $_SESSION["cpfEstagiario"] : NULL ;
    $nome = (isset($_SESSION["nomeEstagiario"]) && $_SESSION["nomeEstagiario"] != NULL) ? $_SESSION["nomeEstagiario"] : NULL ;
    $sobrenome = (isset($_SESSION["sobrenomeEstagiario"]) && $_SESSION["sobrenomeEstagiario"] != NULL) ? $_SESSION["sobrenomeEstagiario"] : NULL ;
    $email = (isset($_SESSION["emailEstagiario"]) && $_SESSION["emailEstagiario"] != NULL) ? $_SESSION["emailEstagiario"] : NULL ;

    ?>
    <section id="cadastro">
        <form class="formComponent row" method="post">
            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--CPF-->
                    <input type="text" id="cpf" class="form-control w-100" placeholder="CPF" aria-label="CPF" name="cpf" value="<?php echo $cpf;?>" required>
                    <label for="cpf">CPF</label>
                    <div class="invalid-feedback" id="feedback-cpf">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME-->
                    <input type="text" id="nome" class="form-control w-100" placeholder="Nome" aria-label="Nome" name="nome" value="<?php echo $nome;?>" required>
                    <label for="nome">Nome</label>
                    <div class="invalid-feedback" id="feedback-nome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--SOBRENOME-->
                    <input type="text" id="sobrenome" class="form-control w-100" placeholder="Sobrenome" aria-label="Sobrenome" value="<?php echo $sobrenome;?>" name="sobrenome">
                    <label for="sobrenome">Sobrenome</label>
                    <div class="invalid-feedback" id="feedback-sobrenome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL-->
                    <input type="email" id="email" class="form-control w-100" placeholder="Email" aria-label="Email" name="email" value="<?php echo $email;?>" required>
                    <label for="email">E-mail</label>
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