<?php
session_start();

if ($_SESSION['statusCadastroEscola'] != "andamento" || $_SESSION['etapaCadastroEscola'] < 4) {
    header("Location: action.php");
}


if (
    isset($_POST['niveisEnsino']) && !empty($_POST['niveisEnsino']) &&
    isset($_POST['descricao']) && !empty($_POST['descricao'])
) {

    $_SESSION["niveisEnsinoEscola"] = htmlspecialchars($_POST['niveisEnsino'], ENT_QUOTES, 'UTF-8');
    $_SESSION["descricaoEscola"] = htmlspecialchars($_POST['descricao'], ENT_QUOTES, 'UTF-8');

    if (isset($_POST['website']) && !empty($_POST['website'])) {
        $_SESSION["websiteEscola"] = htmlspecialchars($_POST['website'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['linkedin']) && !empty($_POST['linkedin'])) {
        $_SESSION["linkedinEscola"] = htmlspecialchars($_POST['linkedin'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['instagram']) && !empty($_POST['instagram'])) {
        $_SESSION["instagramEscola"] = htmlspecialchars($_POST['instagram'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['facebook']) && !empty($_POST['facebook'])) {
        $_SESSION["facebookEscola"] = htmlspecialchars($_POST['facebook'], ENT_QUOTES, 'UTF-8');
    }
    $_SESSION['statusCadastroEscola'] = "andamento";
    $_SESSION['etapaCadastroEscola'] = 5;
    header("Location: etapa5.php");
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
    <link rel="shortcut icon" href="../../../assets/img/icons/favicontransparente.ico" type="image/x-icon">

    <!--BIBLIOTECAS-->

    <!--BOOTSTRAP-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../../assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!--ICONES-->
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

    // Definindo constantes para as chaves da sessão
    define('niveisEnsino_KEY', 'niveisEnsinoEscola');
    define('DESCRICAO_KEY', 'descricaoEscola');
    define('WEBSITE_KEY', 'websiteEscola');
    define('LINKEDIN_KEY', 'linkedinEscola');
    define('INSTAGRAM_KEY', 'instagramEscola');
    define('FACEBOOK_KEY', 'facebookEscola');



    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $niveisEnsino = pegarSessao(niveisEnsino_KEY);
    $descricao = pegarSessao(DESCRICAO_KEY);
    $website = pegarSessao(WEBSITE_KEY);
    $linkedin = pegarSessao(LINKEDIN_KEY);
    $instagram = pegarSessao(INSTAGRAM_KEY);
    $facebook = pegarSessao(FACEBOOK_KEY);

    ?>


    <section id="cadastro">

        <form class="formComponent row" method="post" id="formEtapa4" novalidate>
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 70%;">70%</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>

            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--NIVEIS DE ENSINO-->
                    <input autofocus type="text" id="niveisEnsino" class="form-control w-100" maxlength="100" placeholder="Níveis de Ensino Oferecidos" aria-label="Níveis de Ensino Oferecidos" name="niveisEnsino" value="<?php echo $niveisEnsino; ?>" required>
                    <label for="niveisEnsino">Níveis de Ensino Oferecidos *</label>
                    <div class="invalid-feedback" id="feedback-niveisEnsino">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--DESCRIÇÃO-->
                    <textarea id="descricao" class="form-control w-100" placeholder="Descrição da Escola" aria-label="Descrição da Escola" name="descricao" maxlength="500" required><?php echo $descricao; ?></textarea>
                    <label for="descricao">Descrição da Escola *</label>
                    <div class="invalid-feedback" id="feedback-descricao">
                        Preencha corretamente!
                    </div>
                </div>
                <p class="text-dark text-start m-1 mt-3 ">Redes sociais:</p>

                <div class="input-group  m-1"><!--WEBSITE-->
                    <span class="input-group-text" id="websiteSpan"><i class="bi bi-globe2"></i></span>
                    <input type="text" class="form-control" placeholder="Website" aria-label="Website" aria-describedby="Website-link" maxlength="100"  value="<?php echo $website; ?>"  name="website">
                </div>
                <div class="input-group  m-1"><!--LINKEDIN-->
                    <span class="input-group-text" id="linkedinSpan"><i class="bi bi-linkedin"></i></span>
                    <input type="text" class="form-control" placeholder="Linkedin" aria-label="Linkedin" aria-describedby="Linkedin-link" maxlength="100"  value="<?php echo $linkedin; ?>"  name="linkedin">
                </div>
                <div class="input-group  m-1"><!--INSTAGRAM-->
                    <span class="input-group-text" id="instagramSpan"><i class="bi bi-instagram"></i></span>
                    <input type="text" class="form-control" placeholder="Instagram" aria-label="Instagram" aria-describedby="Instagram-link" maxlength="100"  value="<?php echo $instagram; ?>"  name="instagram">
                </div>
                <div class="input-group  m-1"><!--FACEBOOK-->
                    <span class="input-group-text" id="facebookSpan"><i class="bi bi-facebook"></i></span>
                    <input type="text" class="form-control" placeholder="Facebook" aria-label="Facebook" aria-describedby="Facebook-link" maxlength="100"  value="<?php echo $facebook; ?>"  name="facebook">
                </div>
            </div>

            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="etapa3.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">PRÓXIMO</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacaoEscola.js"></script>
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