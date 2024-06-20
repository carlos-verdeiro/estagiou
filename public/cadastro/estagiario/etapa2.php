<?php
session_start();



if (isset($_POST['cpf']) && $_POST['cpf'] != NULL && isset($_POST['nome']) && $_POST['nome'] != NULL && isset($_POST['sobrenome']) && isset($_POST['email']) && $_POST['email'] != NULL) {

    if (validaEmail($_POST['email']) && validaCPF($_POST['cpf'])) {
        $_SESSION["cpfEstagiario"] = $_POST['cpf'];
        $_SESSION["nomeEstagiario"] = $_POST['nome'];
        $_SESSION["sobrenomeEstagiario"] = $_POST['sobrenome'];
        $_SESSION["emailEstagiario"] = $_POST['email'];
        $_SESSION['statusCadastro'] = "andamento";
        $_SESSION['etapaCadastro'] = 3;
        header("location: etapa" . $_SESSION['etapaCadastro'] . ".php");
        exit;
    } else {
        $_SESSION['etapaCadastro'] = 2;
    }


} else {
    $_SESSION['etapaCadastro'] = 2;
}

?>

<!DOCTYPE html>
<html lang="pt-be">

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
    
    $rg = (isset($_SESSION["rgEstagiario"]) && $_SESSION["rgEstagiario"] != NULL) ? $_SESSION["rgEstagiario"] : NULL;

    $orgaoEmissor = (isset($_SESSION["orgaoEmissorEstagiario"]) && $_SESSION["orgaoEmissorEstagiario"] != NULL) ? $_SESSION["orgaoEmissorEstagiario"] : NULL;

    $estadoEmissor = (isset($_SESSION["estadoEmissorEstagiario"]) && $_SESSION["estadoEmissorEstagiario"] != NULL) ? $_SESSION["estadoEmissorEstagiario"] : NULL;

    $genero = (isset($_SESSION["generoEstagiario"]) && $_SESSION["generoEstagiario"] != NULL) ? $_SESSION["generoEstagiario"] : NULL;

    $nomeSocial = (isset($_SESSION["nomeSocialEstagiario"]) && $_SESSION["nomeSocialEstagiario"] != NULL) ? $_SESSION["nomeSocialEstagiario"] : NULL;

    $estadoCivil = (isset($_SESSION["estadoCivilEstagiario"]) && $_SESSION["estadoCivilEstagiario"] != NULL) ? $_SESSION["estadoCivilEstagiario"] : NULL;


    ?>

    <section id="cadastro">
        <form class="formComponent row" method="post">
            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs ">
                <div class="form-floating m-1 row"><!--RG-->
                    <input type="text" id="rg" class="form-control w-100" placeholder="RG" aria-label="RG" name="rg"
                        value="<?php echo $rg; ?>" required>
                    <label for="rg">RG</label>
                    <div class="invalid-feedback" id="feedback-rg">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="m-1 row">
                    <div class="form-floating col p-0 me-1"><!--ÓRGÃO EMISSOR-->
                        <input type="text" id="orgaoEmissor" class="form-control w-100" placeholder="Órgão Emissor"
                            aria-label="Órgão Emissor" name="orgaoEmissor" value="<?php echo $orgaoEmissor; ?>"
                            required>
                        <label for="orgaoEmissor">Órgão Emissor</label>
                        <div class="invalid-feedback" id="feedback-orgaoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO EMISSOR-->
                        <select id="estadoEmissor" class="form-select w-100" aria-label="Estado Emissor"
                            value="<?php echo $estadoEmissor; ?>" name="estadoEmissor">
                            <option selected hidden disabled>Selecione</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                        <label for="estadoEmissor">Estado Emissor</label>
                        <div class="invalid-feedback" id="feedback-estadoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>

                <div class="form-floating m-1 row"><!--GENERO-->
                    <select id="genero" class="form-select w-100" placeholder="Gênero"
                        aria-label="Gênero" name="genero" value="<?php echo $genero; ?>" required>
                        <option selected hidden disabled>Selecione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outros</option>
                    </select>
                    <label for="genero">Gênero</label>
                    <div class="invalid-feedback" id="feedback-genero">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME SOCIAL-->
                    <input type="text" id="nomeSocial" class="form-control w-100" placeholder="Nome Social" aria-label="Nome Social" name="nomeSocial"
                        value="<?php echo $nomeSocial; ?>" required>
                    <label for="nomeSocial">Nome Social</label>
                    <div class="invalid-feedback" id="feedback-rg">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--ESTADO CIVIL-->
                    <select id="estadoCivil" class="form-select w-100" placeholder="Estado Civil"
                        aria-label="Estado Civil" name="estadoCivil" value="<?php echo $estadoCivil; ?>" required>
                        <option selected hidden disabled>Selecione</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="separado">Separado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Viúvo(a)</option>
                    </select>
                    <label for="estadoCivil">Estado Civil</label>
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