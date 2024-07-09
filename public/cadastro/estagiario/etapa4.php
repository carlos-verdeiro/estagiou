<?php
session_start();

if ($_SESSION['statusCadastro'] != "andamento" || $_SESSION['etapaCadastro'] < 4) {
    header("Location: action.php");
}


if (
    isset($_POST['senha']) && !empty($_POST['senha']) &&
    isset($_POST['confirmacaoSenha']) && !empty($_POST['confirmacaoSenha']) &&
    $_POST['senha'] === $_POST['confirmacaoSenha']

) {

    $_SESSION["senhaEstagiario"] = htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8');


    $_SESSION['statusCadastro'] = "concluido";
    unset($_SESSION['etapaCadastro']);
    header("Location: confirmacao.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 4</title>

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

    // Definindo constantes para as chaves da sessão
    define('SENHA_KEY', 'senhaEstagiario');
    define('CONFIRMACAO_SENHA_KEY', 'confirmacaoSenhaEstagiario');


    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $senha = pegarSessao(SENHA_KEY);
    $confirmacaoSenha = pegarSessao(CONFIRMACAO_SENHA_KEY);



    ?>


    <section id="cadastro">
        <form class="formComponent row" method="post" id="formEtapa4">
            <h1 id='tituloCadastro'>CRIE UMA SENHA</h1>
            <div class="row divInputs ">
                <div class="m-1 row">
                    <label for="senha" class="form-label">Senha:</label><!--SENHA-->
                    <div class="input-group">
                        <input type="password" class="form-control p-3" placeholder="Senha" id="senha" placeholder="Senha" aria-label="Senha" name="senha" value="<?php echo $senha; ?>" required maxlength="50" onpaste="return false" ondrop="return false">
                        <input type="checkbox" class="btn-check" id="senha-Check" autocomplete="off">
                        <label class="btn btn-outline-info d-flex align-items-center justify-content-center rounded-end" for="senha-Check"><img id="checkPassLabelImgSenha" src="../../../assets/img/icons/eyeSlash.svg" alt="olho de senha"></label>
                        <div class="invalid-feedback" id="feedback-senha">
                            Preencha corretamente!
                        </div>
                    </div>

                </div>
                <div class="m-1 row">
                    <label for="confirmacaoSenha" class="form-label">Confirme a senha:</label><!--CONFIRMAÇÃO SENHA-->
                    <div class="form-group">
                        <input type="password" class="form-control p-3" placeholder="Confirmação de Senha" id="confirmacaoSenha" placeholder="Confirmação de Senha" aria-label="Confirmação de Senha" name="confirmacaoSenha" value="<?php echo $confirmacaoSenha; ?>" required maxlength="50" onpaste="return false" ondrop="return false">
                        <input type="checkbox" class="btn-check" id="confirmacaoSenha-Check" autocomplete="off">
                        <div class="invalid-feedback" id="feedback-confirmacaoSenha">
                            Preencha corretamente!
                        </div>
                    </div>

                </div>

            </div>



            </div>

            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="etapa3.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">PRÓXIMO</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacao1.js"></script>
    <script>
        const senhaCheck = $("#senha-Check");
        const checkPassLabelImgSenha = $("#checkPassLabelImgSenha");
        const senha = $("#senha");

        const confirmacaoSenhaCheck = $("#confirmacaoSenha-Check");
        const checkPassLabelImgConfirmacaoSenha = $("#checkPassLabelImgConfirmacaoSenha");
        const confirmacaoSenha = $("#confirmacaoSenha");

        confirmacaoSenhaCheck.on('click', function() {
            if (checkPassLabelImgConfirmacaoSenha.attr('src') === '../../../assets/img/icons/eyeSlash.svg') {
                checkPassLabelImgConfirmacaoSenha.attr('src', '../../../assets/img/icons/eyeFill.svg');
                confirmacaoSenha.attr('type', 'text');
                confirmacaoSenha.focus();
            } else {
                checkPassLabelImgConfirmacaoSenha.attr('src', '../../../assets/img/icons/eyeSlash.svg');
                confirmacaoSenha.attr('type', 'password');
                confirmacaoSenha.focus();
            }
        });

        senhaCheck.on('click', function() {
            if (checkPassLabelImgSenha.attr('src') === '../../../assets/img/icons/eyeSlash.svg') {
                checkPassLabelImgSenha.attr('src', '../../../assets/img/icons/eyeFill.svg');
                senha.attr('type', 'text');
                senha.focus();
            } else {
                checkPassLabelImgSenha.attr('src', '../../../assets/img/icons/eyeSlash.svg');
                senha.attr('type', 'password');
                senha.focus();
            }
        });
    </script>

</body>

</html>