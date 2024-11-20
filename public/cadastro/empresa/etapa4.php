<?php
session_start();

if ($_SESSION['statusCadastroEmpresa'] != "andamento" || $_SESSION['etapaCadastroEmpresa'] < 4) {
    header("Location: action.php");
}


if (
    isset($_POST['atuacao']) && !empty($_POST['atuacao']) &&
    isset($_POST['descricao']) && !empty($_POST['descricao'])
) {

    $_SESSION["atuacaoEmpresa"] = htmlspecialchars($_POST['atuacao'], ENT_QUOTES, 'UTF-8');
    $_SESSION["descricaoEmpresa"] = htmlspecialchars($_POST['descricao'], ENT_QUOTES, 'UTF-8');

    if (isset($_POST['website']) && !empty($_POST['website'])) {
        $_SESSION["websiteEmpresa"] = htmlspecialchars($_POST['website'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['linkedin']) && !empty($_POST['linkedin'])) {
        $_SESSION["linkedinEmpresa"] = htmlspecialchars($_POST['linkedin'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['instagram']) && !empty($_POST['instagram'])) {
        $_SESSION["instagramEmpresa"] = htmlspecialchars($_POST['instagram'], ENT_QUOTES, 'UTF-8');
    }
    if (isset($_POST['facebook']) && !empty($_POST['facebook'])) {
        $_SESSION["facebookEmpresa"] = htmlspecialchars($_POST['facebook'], ENT_QUOTES, 'UTF-8');
    }
    $_SESSION['statusCadastroEmpresa'] = "andamento";
    $_SESSION['etapaCadastroEmpresa'] = 5;
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
    <link rel="shortcut icon" href="../../../assets/img/logo/logo.svg" type="image/x-icon">

    <!--BIBLIOTECAS-->

    <!--BOOTSTRAP-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../../assets/js/bootstrap.bundle.js"></script>
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
    define('ATUACAO_KEY', 'atuacaoEmpresa');
    define('DESCRICAO_KEY', 'descricaoEmpresa');
    define('WEBSITE_KEY', 'websiteEmpresa');
    define('LINKEDIN_KEY', 'linkedinEmpresa');
    define('INSTAGRAM_KEY', 'instagramEmpresa');
    define('FACEBOOK_KEY', 'facebookEmpresa');



    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $atuacao = pegarSessao(ATUACAO_KEY);
    $descricao = pegarSessao(DESCRICAO_KEY);
    $website = pegarSessao(WEBSITE_KEY);
    $linkedin = pegarSessao(LINKEDIN_KEY);
    $instagram = pegarSessao(INSTAGRAM_KEY);
    $facebook = pegarSessao(FACEBOOK_KEY);

    ?>


    <section id="cadastro">

        <form class="formComponent row" method="post" id="formEtapa4" novalidate>
        <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 80%;">4/6</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>

            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--ÁREA DE ATUAÇÃO-->
                    <input autofocus type="text" id="atuacao" class="form-control w-100" maxlength="100" placeholder="Área de Atuação Empresarial" aria-label="Área de Atuação Empresarial" name="atuacao" value="<?php echo $atuacao; ?>" required>
                    <label for="atuacao">Área de Atuação Empresarial *</label>
                    <div class="invalid-feedback" id="feedback-atuacao">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--DESCRIÇÃO-->
                    <textarea id="descricao" class="form-control w-100" placeholder="Descrição da Empresa" aria-label="Descrição da Empresa" name="descricao" maxlength="500" required><?php echo $descricao; ?></textarea>
                    <label for="descricao">Descrição da Empresa *</label>
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

    <script src="../../../assets/js/cadastro/validacaoEmpresa.js"></script>
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