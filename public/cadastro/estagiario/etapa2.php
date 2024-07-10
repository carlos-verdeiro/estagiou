<?php
session_start();

if ($_SESSION['statusCadastro'] != "andamento" || $_SESSION['etapaCadastro'] < 2) {
    header("Location: action.php");
}


if (
    isset($_POST['rg']) && !empty($_POST['rg']) &&
    isset($_POST['orgaoEmissor']) && !empty($_POST['orgaoEmissor']) &&
    isset($_POST['estadoEmissor']) && $_POST['estadoEmissor'] != 'NA' &&
    isset($_POST['genero']) && $_POST['genero'] != 'NA' &&
    isset($_POST['estadoCivil']) && $_POST['estadoCivil'] != 'NA'
) {
    $_SESSION["rgEstagiario"] = htmlspecialchars($_POST['rg'], ENT_QUOTES, 'UTF-8');
    $_SESSION["orgaoEmissorEstagiario"] = htmlspecialchars($_POST['orgaoEmissor'], ENT_QUOTES, 'UTF-8');
    $_SESSION["estadoEmissorEstagiario"] = htmlspecialchars($_POST['estadoEmissor'], ENT_QUOTES, 'UTF-8');
    $_SESSION["generoEstagiario"] = htmlspecialchars($_POST['genero'], ENT_QUOTES, 'UTF-8');

    if (isset($_POST['nomeSocial']) && !empty($_POST['nomeSocial'])) {
        $_SESSION["nomeSocialEstagiario"] = htmlspecialchars($_POST['nomeSocial'], ENT_QUOTES, 'UTF-8');
    } else {
        $_SESSION["nomeSocialEstagiario"] = '';
    }

    $_SESSION["estadoCivilEstagiario"] = htmlspecialchars($_POST['estadoCivil'], ENT_QUOTES, 'UTF-8');
    $_SESSION['statusCadastro'] = "andamento";
    $_SESSION['etapaCadastro'] = 3;
    header("Location: etapa3.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 2</title>

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
    define('RG_KEY', 'rgEstagiario');
    define('ORGAO_EMISSOR_KEY', 'orgaoEmissorEstagiario');
    define('ESTADO_EMISSOR_KEY', 'estadoEmissorEstagiario');
    define('GENERO_KEY', 'generoEstagiario');
    define('NOME_SOCIAL_KEY', 'nomeSocialEstagiario');
    define('ESTADO_CIVIL_KEY', 'estadoCivilEstagiario');

    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $rg = pegarSessao(RG_KEY);
    $orgaoEmissor = pegarSessao(ORGAO_EMISSOR_KEY);
    $estadoEmissor = pegarSessao(ESTADO_EMISSOR_KEY);
    $genero = pegarSessao(GENERO_KEY);
    $nomeSocial = pegarSessao(NOME_SOCIAL_KEY);
    $estadoCivil = pegarSessao(ESTADO_CIVIL_KEY);

    ?>


    <section id="cadastro">
        <form class="formComponent row" method="post" id="formEtapa2">
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 20%;">20%</div>
            </div>

            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs ">
                <div class="form-floating m-1 row"><!--RG-->
                    <input type="text" id="rg" class="form-control w-100" placeholder="RG" aria-label="RG" name="rg" value="<?php echo $rg; ?>" required>
                    <label for="rg">RG *</label>
                    <div class="invalid-feedback" id="feedback-rg">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="m-1 row">
                    <div class="form-floating col p-0 me-1"><!--ÓRGÃO EMISSOR-->
                        <input type="text" id="orgaoEmissor" list="orgaos" class="form-control w-100" placeholder="Órgão Emissor" aria-label="Órgão Emissor" name="orgaoEmissor" value="<?php echo $orgaoEmissor; ?>" maxlength="10" required>
                        <label for="orgaoEmissor">Órgão Emissor *</label>
                        <datalist id="orgaos">
                            <option value="SSP">Secretaria de Segurança Pública</option>
                            <option value="PC">Polícia Civil</option>
                            <option value="IIF">Instituto de Identificação Forense</option>
                            <option value="PAC">Postos de Atendimento ao Cidadão</option>

                        </datalist>
                        <div class="invalid-feedback" id="feedback-orgaoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO EMISSOR-->
                        <select id="estadoEmissor" class="form-select w-100" aria-label="Estado Emissor" name="estadoEmissor" required>
                            <option <?php echo ($estadoEmissor == 'NA') ? 'selected' : ''; ?> hidden value="NA">Selecione</option>
                            <option <?php echo ($estadoEmissor == 'AC') ? 'selected' : ''; ?> value="AC">Acre</option>
                            <option <?php echo ($estadoEmissor == 'AL') ? 'selected' : ''; ?> value="AL">Alagoas</option>
                            <option <?php echo ($estadoEmissor == 'AP') ? 'selected' : ''; ?> value="AP">Amapá</option>
                            <option <?php echo ($estadoEmissor == 'AM') ? 'selected' : ''; ?> value="AM">Amazonas</option>
                            <option <?php echo ($estadoEmissor == 'BA') ? 'selected' : ''; ?> value="BA">Bahia</option>
                            <option <?php echo ($estadoEmissor == 'CE') ? 'selected' : ''; ?> value="CE">Ceará</option>
                            <option <?php echo ($estadoEmissor == 'DF') ? 'selected' : ''; ?> value="DF">Distrito Federal</option>
                            <option <?php echo ($estadoEmissor == 'ES') ? 'selected' : ''; ?> value="ES">Espírito Santo</option>
                            <option <?php echo ($estadoEmissor == 'GO') ? 'selected' : ''; ?> value="GO">Goiás</option>
                            <option <?php echo ($estadoEmissor == 'MA') ? 'selected' : ''; ?> value="MA">Maranhão</option>
                            <option <?php echo ($estadoEmissor == 'MT') ? 'selected' : ''; ?> value="MT">Mato Grosso</option>
                            <option <?php echo ($estadoEmissor == 'MS') ? 'selected' : ''; ?> value="MS">Mato Grosso do Sul</option>
                            <option <?php echo ($estadoEmissor == 'MG') ? 'selected' : ''; ?> value="MG">Minas Gerais</option>
                            <option <?php echo ($estadoEmissor == 'PA') ? 'selected' : ''; ?> value="PA">Pará</option>
                            <option <?php echo ($estadoEmissor == 'PB') ? 'selected' : ''; ?> value="PB">Paraíba</option>
                            <option <?php echo ($estadoEmissor == 'PR') ? 'selected' : ''; ?> value="PR">Paraná</option>
                            <option <?php echo ($estadoEmissor == 'PE') ? 'selected' : ''; ?> value="PE">Pernambuco</option>
                            <option <?php echo ($estadoEmissor == 'PI') ? 'selected' : ''; ?> value="PI">Piauí</option>
                            <option <?php echo ($estadoEmissor == 'RJ') ? 'selected' : ''; ?> value="RJ">Rio de Janeiro</option>
                            <option <?php echo ($estadoEmissor == 'RN') ? 'selected' : ''; ?> value="RN">Rio Grande do Norte</option>
                            <option <?php echo ($estadoEmissor == 'RS') ? 'selected' : ''; ?> value="RS">Rio Grande do Sul</option>
                            <option <?php echo ($estadoEmissor == 'RO') ? 'selected' : ''; ?> value="RO">Rondônia</option>
                            <option <?php echo ($estadoEmissor == 'RR') ? 'selected' : ''; ?> value="RR">Roraima</option>
                            <option <?php echo ($estadoEmissor == 'SC') ? 'selected' : ''; ?> value="SC">Santa Catarina</option>
                            <option <?php echo ($estadoEmissor == 'SP') ? 'selected' : ''; ?> value="SP">São Paulo</option>
                            <option <?php echo ($estadoEmissor == 'SE') ? 'selected' : ''; ?> value="SE">Sergipe</option>
                            <option <?php echo ($estadoEmissor == 'TO') ? 'selected' : ''; ?> value="TO">Tocantins</option>

                        </select>
                        <label for="estadoEmissor">Estado Emissor *</label>
                        <div class="invalid-feedback" id="feedback-estadoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>

                <div class="form-floating m-1 row"><!--GENERO-->
                    <select id="genero" class="form-select w-100" placeholder="Gênero" aria-label="Gênero" name="genero" value="<?php echo $genero; ?>" required>
                        <option <?php echo ($estadoEmissor == 'NA') ? 'selected' : ''; ?> hidden disabled value="NA">Selecione</option>
                        <option <?php echo ($estadoEmissor == 'M') ? 'selected' : ''; ?> value="M">Masculino</option>
                        <option <?php echo ($estadoEmissor == 'F') ? 'selected' : ''; ?> value="F">Feminino</option>
                        <option <?php echo ($estadoEmissor == 'O') ? 'selected' : ''; ?> value="O">Outros</option>

                    </select>
                    <label for="genero">Gênero *</label>
                    <div class="invalid-feedback" id="feedback-genero">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME SOCIAL-->
                    <input type="text" id="nomeSocial" class="form-control w-100" placeholder="Nome Social" aria-label="Nome Social" name="nomeSocial" value="<?php echo $nomeSocial; ?>">
                    <label for="nomeSocial">Nome Social</label>
                    <div class="invalid-feedback" id="feedback-rg">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--ESTADO CIVIL-->
                    <select id="estadoCivil" class="form-select w-100" placeholder="Estado Civil" aria-label="Estado Civil" name="estadoCivil" value="<?php echo $estadoCivil; ?>" required>
                        <option <?php echo ($estadoCivil == 'NA') ? 'selected' : ''; ?> hidden disabled value="NA">Selecione</option>
                        <option <?php echo ($estadoCivil == 'solteiro') ? 'selected' : ''; ?> value="solteiro">Solteiro(a)</option>
                        <option <?php echo ($estadoCivil == 'casado') ? 'selected' : ''; ?> value="casado">Casado(a)</option>
                        <option <?php echo ($estadoCivil == 'separado') ? 'selected' : ''; ?> value="separado">Separado(a)</option>
                        <option <?php echo ($estadoCivil == 'divorciado') ? 'selected' : ''; ?> value="divorciado">Divorciado(a)</option>
                        <option <?php echo ($estadoCivil == 'viuvo') ? 'selected' : ''; ?> value="viuvo">Viúvo(a)</option>

                    </select>
                    <label for="estadoCivil">Estado Civil *</label>
                    <div class="invalid-feedback" id="feedback-estadoCivil">
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

    <script src="../../../assets/js/cadastro/validacao1.js"></script>

</body>

</html>