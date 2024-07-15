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

function validaCNPJ($cnpj)
{
    // Extrai somente os números
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    // Verifica se o CNPJ tem 14 dígitos
    if (strlen($cnpj) != 14) {
        return false;
    }

    // Verifica se foi informada uma sequência de dígitos repetidos. Ex: 11.111.111/1111-11
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    // Calcula os dígitos verificadores para verificar se o CNPJ é válido
    $weightFirstDigit = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $weightSecondDigit = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    // Calcula o primeiro dígito verificador
    $sum = 0;
    for ($i = 0; $i < 12; $i++) {
        $sum += $cnpj[$i] * $weightFirstDigit[$i];
    }
    $remainder = $sum % 11;
    $firstVerifierDigit = $remainder < 2 ? 0 : 11 - $remainder;

    // Verifica o primeiro dígito verificador
    if ($cnpj[12] != $firstVerifierDigit) {
        return false;
    }

    // Calcula o segundo dígito verificador
    $sum = 0;
    for ($i = 0; $i < 13; $i++) {
        $sum += $cnpj[$i] * $weightSecondDigit[$i];
    }
    $remainder = $sum % 11;
    $secondVerifierDigit = $remainder < 2 ? 0 : 11 - $remainder;

    // Verifica o segundo dígito verificador
    if ($cnpj[13] != $secondVerifierDigit) {
        return false;
    }

    return true;
}


if (
    isset($_POST['cnpj']) && !empty($_POST['cnpj']) &&
    isset($_POST['nomeEscola']) && !empty($_POST['nomeEscola']) &&
    isset($_POST['telefone']) && !empty($_POST['telefone']) &&
    isset($_POST['email']) && !empty($_POST['email'])

) {
    $cnpj = htmlspecialchars($_POST['cnpj'], ENT_QUOTES, 'UTF-8');
    $nomeEscola = htmlspecialchars($_POST['nomeEscola'], ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

    if (validaEmail($email) && validaCNPJ($cnpj)) {
        $_SESSION["cnpjEscola"] = $cnpj;
        $_SESSION["nomeEscola"] = $nomeEscola;
        $_SESSION["telefoneEscola"] = $telefone;
        $_SESSION["emailEscola"] = $email;
        $_SESSION['statusCadastroEscola'] = "andamento";
        $_SESSION['etapaCadastroEscola'] = 2;
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
    <link rel="shortcut icon" href="../../../assets/img/icons/favicontransparente.ico" type="image/x-icon">

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
    include_once "../../../assets/templates/cadastro/headerEtapa.php";
    //---------HEADER---------

    define('CNPJ_KEY', 'cnpjEscola');
    define('NOME_ESCOLA_KEY', 'nomeEscola');
    define('TELEFONE_KEY', 'telefoneEscola');
    define('EMAIL_KEY', 'emailEscola');

    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $cnpj = pegarSessao(CNPJ_KEY);
    $nomeEscola = pegarSessao(NOME_ESCOLA_KEY);
    $telefone = pegarSessao(TELEFONE_KEY);
    $email = pegarSessao(EMAIL_KEY);
    ?>

    <section id="cadastro">

        <form class="formComponent row" method="post" id="formEtapa1" novalidate>
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%;">0%</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>

            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--CNPJ-->
                    <input autofocus type="text" id="cnpj" class="form-control w-100" placeholder="CNPJ" aria-label="CNPJ" name="cnpj" value="<?php echo $cnpj; ?>" required>
                    <label for="cnpj">CNPJ *</label>
                    <div class="invalid-feedback" id="feedback-cnpj">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME DA ESCOLA-->
                    <input type="text" id="nomeEscola" class="form-control w-100" placeholder="Nome da Escola" aria-label="Nome da Escola" name="nomeEscola" value="<?php echo $nomeEscola; ?>" maxlength="255" required>
                    <label for="nomeEscola">Nome da Escola *</label>
                    <div class="invalid-feedback" id="feedback-nomeEscola">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--TELEFONE-->
                    <input type="text" id="telefone" class="form-control w-100" placeholder="Telefone" aria-label="Telefone" value="<?php echo $telefone; ?>" maxlength="50" name="telefone" required>
                    <label for="telefone">Telefone *</label>
                    <div class="invalid-feedback" id="feedback-telefone">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL CORPORATIVO-->
                    <input type="email" id="email" class="form-control w-100" placeholder="E-mail Corporativo" aria-label="E-mail Corporativo" name="email" value="<?php echo $email; ?>" maxlength="255" required>
                    <label for="email">E-mail Corporativo *</label>
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

    <script src="../../../assets/js/cadastro/validacaoEscola.js"></script>

</body>

</html>