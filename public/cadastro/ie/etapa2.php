<?php
session_start();

if ($_SESSION['statusCadastroEscola'] != "andamento") {
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




if (
    isset($_POST['nomeResponsavel']) && !empty($_POST['nomeResponsavel']) &&
    isset($_POST['cargoResponsavel']) && !empty($_POST['cargoResponsavel']) &&
    isset($_POST['telefoneResponsavel']) && !empty($_POST['telefoneResponsavel']) &&
    isset($_POST['emailResponsavel']) && !empty($_POST['emailResponsavel'])

) {
    $nome = htmlspecialchars($_POST['nomeResponsavel'], ENT_QUOTES, 'UTF-8');
    $cargo = htmlspecialchars($_POST['cargoResponsavel'], ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars($_POST['telefoneResponsavel'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['emailResponsavel'], ENT_QUOTES, 'UTF-8');

    if (validaEmail($email)) {
        $_SESSION["nomeResponsavelEscola"] = $nome;
        $_SESSION["cargoResponsavelEscola"] = $cargo;
        $_SESSION["telefoneResponsavelEscola"] = $telefone;
        $_SESSION["emailResponsavelEscola"] = $email;
        $_SESSION['statusCadastroEscola'] = "andamento";
        $_SESSION['etapaCadastroEscola'] = 3;
        header("Location: etapa3.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 2</title>

    <link rel="stylesheet" href="../../../assets/css/cadastro/etapas.css">
    <link rel="shortcut icon" href="../../../assets/img/icons/favicontransparente.ico" type="image/x-icon">

    <!--BIBLIOTECAS-->

    <!--BOOTSTRAP-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../../assets/js/bootstrap.bundle.js"></script>
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
    include_once "../../../assets/templates/cadastro/headerEtapa.php";
    //---------HEADER---------

    define('NOME_KEY', 'nomeResponsavelEscola');
    define('CARGO_KEY', 'cargoResponsavelEscola');
    define('TELEFONE_KEY', 'telefoneResponsavelEscola');
    define('EMAIL_KEY', 'emailResponsavelEscola');

    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $nomeResponsavel = pegarSessao(NOME_KEY);
    $cargoResponsavel = pegarSessao(CARGO_KEY);
    $telefoneResponsavel = pegarSessao(TELEFONE_KEY);
    $emailResponsavel = pegarSessao(EMAIL_KEY);
    ?>

    <section id="cadastro">

        <form class="formComponent row" method="post" id="formEtapa2" novalidate>
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 20%;">20%</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>

            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--NOME RESPONSÁVEL-->
                    <input autofocus type="text" id="nomeResponsavel" class="form-control w-100" maxlength="255" placeholder="Nome do Responsável" aria-label="Nome do Responsável" name="nomeResponsavel" value="<?php echo $nomeResponsavel; ?>" required>
                    <label for="nomeResponsavel">Nome Completo do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-nomeResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--CARGO RESPONSÁVEL-->
                    <input type="text" id="cargoResponsavel" class="form-control w-100" placeholder="Cargo do Responsável" aria-label="Cargo do Responsável" name="cargoResponsavel" value="<?php echo $cargoResponsavel; ?>" maxlength="100" required>
                    <label for="cargoResponsavel">Cargo do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-cargoResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--TELEFONE RESPONSAVEL-->
                    <input type="text" id="telefoneResponsavel" class="form-control w-100" placeholder="Telefone do Responsável" aria-label="Telefone do Responsável" value="<?php echo $telefoneResponsavel; ?>" maxlength="25" name="telefoneResponsavel" required>
                    <label for="telefoneResponsavel">Telefone do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-telefoneResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL RESPONSAVEL-->
                    <input type="email" id="emailResponsavel" class="form-control w-100" placeholder="E-mail do Responsável" aria-label="E-mail do Responsável" name="emailResponsavel" value="<?php echo $emailResponsavel; ?>" maxlength="255" required>
                    <label for="emailResponsavel">E-mail do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-emailResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
            </div>

            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="etapa1.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">PRÓXIMO</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacaoEscola.js"></script>

</body>

</html>