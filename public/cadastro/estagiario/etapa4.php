<?php
session_start();

if ($_SESSION['statusCadastroEstagiario'] != "andamento" || $_SESSION['etapaCadastroEstagiario'] < 4) {
    header("Location: action.php");
}


if (
    isset($_POST['endereco']) && !empty($_POST['endereco']) &&
    isset($_POST['bairro']) && !empty($_POST['bairro']) &&
    isset($_POST['numero']) && !empty($_POST['numero']) &&
    isset($_POST['cidade']) && !empty($_POST['cidade']) &&
    isset($_POST['estado']) && !empty($_POST['estado']) &&
    isset($_POST['cep']) && !empty($_POST['cep']) &&
    isset($_POST['pais']) && !empty($_POST['pais'])

) {

    $_SESSION["enderecoEstagiario"] = htmlspecialchars($_POST['endereco'], ENT_QUOTES, 'UTF-8');
    $_SESSION["bairroEstagiario"] = htmlspecialchars($_POST['bairro'], ENT_QUOTES, 'UTF-8');
    $_SESSION["numeroEstagiario"] = htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8');
    if (isset($_POST['complemento']) && $_POST['complemento'] != NULL) {
        $_SESSION["complementoEstagiario"] = htmlspecialchars($_POST['complemento'], ENT_QUOTES, 'UTF-8');
    }
    $_SESSION["cidadeEstagiario"] = htmlspecialchars($_POST['cidade'], ENT_QUOTES, 'UTF-8');
    $_SESSION["estadoEstagiario"] = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');
    $_SESSION["cepEstagiario"] = htmlspecialchars($_POST['cep'], ENT_QUOTES, 'UTF-8');
    $_SESSION["paisEstagiario"] = htmlspecialchars($_POST['pais'], ENT_QUOTES, 'UTF-8');


    $_SESSION['statusCadastroEstagiario'] = "andamento";
    $_SESSION['etapaCadastroEstagiario'] = 5;
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

    define('ENDERECO_KEY', 'enderecoEstagiario');
    define('BAIRRO_KEY', 'bairroEstagiario');
    define('NUMERO_KEY', 'numeroEstagiario');
    define('COMPLEMENTO_KEY', 'complementoEstagiario');
    define('CIDADE_KEY', 'cidadeEstagiario');
    define('ESTADO_KEY', 'estadoEstagiario');
    define('CEP_KEY', 'cepEstagiario');
    define('PAIS_KEY', 'paisEstagiario');


    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $endereco = pegarSessao(ENDERECO_KEY);
    $bairro = pegarSessao(BAIRRO_KEY);
    $numero = pegarSessao(NUMERO_KEY);
    $complemento = pegarSessao(COMPLEMENTO_KEY);
    $cidade = pegarSessao(CIDADE_KEY);
    $estado = pegarSessao(ESTADO_KEY);
    $cep = pegarSessao(CEP_KEY);
    $pais = pegarSessao(PAIS_KEY);

    ?>

    <section id="cadastro">
        <form class="formComponent row" method="post" id="formEtapa4" novalidate>
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 60%;">60%</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs">
                <div class="form-floating m-1 row">
                    <div  class="form-floating col p-0 me-1"><!--CEP-->
                        <input autofocus type="text" id="cep" class="form-control w-100" placeholder="CEP" aria-label="CEP" name="cep" value="<?php echo $cep; ?>" required>
                        <label for="cep">CEP *</label>
                        <div class="invalid-feedback" id="feedback-cep">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--PAÍS-->
                        <input type="text" id="pais" class="form-control w-100" placeholder="País" aria-label="País" name="pais" value="<?php echo ($pais != NULL) ? $pais : 'Brasil'; ?>" maxlength="40" required>
                        <label for="pais">País *</label>
                        <div class="invalid-feedback" id="feedback-pais">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>


                <div class="form-floating m-1 row">
                    <div class="form-floating col p-0 me-1"><!--CIDADE-->
                        <input type="text" id="cidade" class="form-control w-100" placeholder="Cidade" aria-label="Cidade" value="<?php echo $cidade; ?>" maxlength="50" name="cidade" required>
                        <label for="cidade">Cidade *</label>
                        <div class="invalid-feedback" id="feedback-cidade">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO-->
                        <select id="estado" class="form-select w-100" aria-label="Estado" name="estado" required>
                            <option <?php echo ($estado == 'NA' || $estado == NULL || $estado == '') ? 'selected' : ''; ?> disabled hidden value="NA">Selecione</option>
                            <option <?php echo ($estado == 'AC') ? 'selected' : ''; ?> value="AC">Acre</option>
                            <option <?php echo ($estado == 'AL') ? 'selected' : ''; ?> value="AL">Alagoas</option>
                            <option <?php echo ($estado == 'AP') ? 'selected' : ''; ?> value="AP">Amapá</option>
                            <option <?php echo ($estado == 'AM') ? 'selected' : ''; ?> value="AM">Amazonas</option>
                            <option <?php echo ($estado == 'BA') ? 'selected' : ''; ?> value="BA">Bahia</option>
                            <option <?php echo ($estado == 'CE') ? 'selected' : ''; ?> value="CE">Ceará</option>
                            <option <?php echo ($estado == 'DF') ? 'selected' : ''; ?> value="DF">Distrito Federal</option>
                            <option <?php echo ($estado == 'ES') ? 'selected' : ''; ?> value="ES">Espírito Santo</option>
                            <option <?php echo ($estado == 'GO') ? 'selected' : ''; ?> value="GO">Goiás</option>
                            <option <?php echo ($estado == 'MA') ? 'selected' : ''; ?> value="MA">Maranhão</option>
                            <option <?php echo ($estado == 'MT') ? 'selected' : ''; ?> value="MT">Mato Grosso</option>
                            <option <?php echo ($estado == 'MS') ? 'selected' : ''; ?> value="MS">Mato Grosso do Sul</option>
                            <option <?php echo ($estado == 'MG') ? 'selected' : ''; ?> value="MG">Minas Gerais</option>
                            <option <?php echo ($estado == 'PA') ? 'selected' : ''; ?> value="PA">Pará</option>
                            <option <?php echo ($estado == 'PB') ? 'selected' : ''; ?> value="PB">Paraíba</option>
                            <option <?php echo ($estado == 'PR') ? 'selected' : ''; ?> value="PR">Paraná</option>
                            <option <?php echo ($estado == 'PE') ? 'selected' : ''; ?> value="PE">Pernambuco</option>
                            <option <?php echo ($estado == 'PI') ? 'selected' : ''; ?> value="PI">Piauí</option>
                            <option <?php echo ($estado == 'RJ') ? 'selected' : ''; ?> value="RJ">Rio de Janeiro</option>
                            <option <?php echo ($estado == 'RN') ? 'selected' : ''; ?> value="RN">Rio Grande do Norte</option>
                            <option <?php echo ($estado == 'RS') ? 'selected' : ''; ?> value="RS">Rio Grande do Sul</option>
                            <option <?php echo ($estado == 'RO') ? 'selected' : ''; ?> value="RO">Rondônia</option>
                            <option <?php echo ($estado == 'RR') ? 'selected' : ''; ?> value="RR">Roraima</option>
                            <option <?php echo ($estado == 'SC') ? 'selected' : ''; ?> value="SC">Santa Catarina</option>
                            <option <?php echo ($estado == 'SP') ? 'selected' : ''; ?> value="SP">São Paulo</option>
                            <option <?php echo ($estado == 'SE') ? 'selected' : ''; ?> value="SE">Sergipe</option>
                            <option <?php echo ($estado == 'TO') ? 'selected' : ''; ?> value="TO">Tocantins</option>

                        </select> <label for="estado">Estado *</label>
                        <div class="invalid-feedback" id="feedback-estado">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row">

                    <div class="form-floating col p-0 me-1"><!--ENDEREÇO-->
                        <input type="text" id="endereco" class="form-control w-100" placeholder="Endereço" aria-label="Endereço" value="<?php echo $endereco; ?>" maxlength="255" name="endereco" required>
                        <label for="endereco">Endereço *</label>
                        <div class="invalid-feedback" id="feedback-endereco">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--BAIRRO-->
                        <input type="text" id="bairro" class="form-control w-100" placeholder="Bairro" aria-label="Bairro" value="<?php echo $bairro; ?>" maxlength="70" name="bairro" required>
                        <label for="bairro">Bairro *</label>
                        <div class="invalid-feedback" id="feedback-bairro">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NÚMERO-->
                    <input type="text" id="numero" class="form-control w-100" placeholder="Número" aria-label="Número" name="numero" value="<?php echo $numero; ?>" maxlength="10" required>
                    <label for="numero">Número *</label>
                    <div class="invalid-feedback" id="feedback-numero">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--COMPLEMENTO-->
                    <input type="text" id="complemento" class="form-control w-100" placeholder="Complemento" aria-label="Complemento" name="complemento" value="<?php echo $complemento; ?>">
                    <label for="complemento">Complemento</label>
                    <div class="invalid-feedback" id="feedback-complemento">
                        Preencha corretamente!
                    </div>
                </div>
            </div>

            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="etapa3.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">PRÓXIMO</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacaoEstagiario.js"></script>

</body>

</html>