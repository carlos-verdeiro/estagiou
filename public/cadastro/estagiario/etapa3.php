<?php
session_start();

if ($_SESSION['statusCadastroEstagiario'] != "andamento" || $_SESSION['etapaCadastroEstagiario'] < 3) {
    header("Location: action.php");
    exit;
}

if (
    isset($_POST['dataNascimento']) && !empty($_POST['dataNascimento']) &&
    isset($_POST['nacionalidade']) && !empty($_POST['nacionalidade']) &&
    isset($_POST['celular']) && !empty($_POST['celular'])
) {
    $_SESSION["dataNascimentoEstagiario"] = htmlspecialchars($_POST['dataNascimento'], ENT_QUOTES, 'UTF-8');
    $_SESSION["nacionalidadeEstagiario"] = htmlspecialchars($_POST['nacionalidade'], ENT_QUOTES, 'UTF-8');
    $_SESSION["celularEstagiario"] = htmlspecialchars($_POST['celular'], ENT_QUOTES, 'UTF-8');
    if (isset($_POST['telefone']) && !empty($_POST['telefone'])) {
        $_SESSION["telefoneEstagiario"] = htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8');
    } else {
        $_SESSION["telefoneEstagiario"] = NULL;
    }

    if (isset($_POST['cnhSem'])) {
        $_SESSION["cnhEstagiario"] = 'N';
    } elseif (isset($_POST['cnh'])) {
        $cnhzin = implode('', $_POST['cnh']);
        $_SESSION["cnhEstagiario"] = htmlspecialchars($cnhzin, ENT_QUOTES, 'UTF-8');
    } else {
        $_SESSION["cnhEstagiario"] = 'N';
    }

    if (isset($_POST['dependentes']) && is_numeric($_POST['dependentes'])) {
        $_SESSION["dependentesEstagiario"] = htmlspecialchars($_POST['dependentes'], ENT_QUOTES, 'UTF-8');
    } else {
        $_SESSION["dependentesEstagiario"] = 0;
    }

    $_SESSION['statusCadastroEstagiario'] = "andamento";
    $_SESSION['etapaCadastroEstagiario'] = 4;
    header("Location: etapa4.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 3</title>

    <link rel="stylesheet" href="../../../assets/css/cadastro/etapas.css">
    <link rel="shortcut icon" href="../../../assets/img/logo/logo.svg" type="image/x-icon">

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

    // Definindo constantes para as chaves da sessão
    define('DATA_NASCIMENTO_KEY', 'dataNascimentoEstagiario');
    define('NACIONALIDADE_KEY', 'nacionalidadeEstagiario');
    define('CELULAR_KEY', 'celularEstagiario');
    define('TELEFONE_KEY', 'telefoneEstagiario');
    define('CNH_KEY', 'cnhEstagiario');
    define('DEPENDENTES_KEY', 'dependentesEstagiario');


    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }

    $dataNascimento = pegarSessao(DATA_NASCIMENTO_KEY);
    $nacionalidade = pegarSessao(NACIONALIDADE_KEY);
    $celular = pegarSessao(CELULAR_KEY);
    $telefone = pegarSessao(TELEFONE_KEY);
    $cnh = pegarSessao(CNH_KEY);
    $dependentes = pegarSessao(DEPENDENTES_KEY);


    ?>


    <section id="cadastro">
        <form class="formComponent row" method="post" id="formEtapa3">
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 60%;">3/6</div>
            </div>
            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs ">
                <div class="m-1 row">
                    <div class="form-floating col p-0 me-1">
                        <input autofocus type="date" id="dataNascimento" min="1924-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control w-100" placeholder="Data de nascimento" aria-label="Data de nascimento" name="dataNascimento" value="<?php echo $dataNascimento; ?>" required>
                        <label for="dataNascimento">Data de nascimento *</label>
                        <div class="invalid-feedback" id="feedback-dataNascimento">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO EMISSOR-->
                        <input type="text" id="nacionalidade" list="listaNacionalidade" class="form-control w-100" placeholder="Nacionalidade" aria-label="Nacionalidade" name="nacionalidade" value="<?php echo $nacionalidade; ?>" maxlength="20" required>
                        <label for="nacionalidade">Nacionalidade *</label>
                        <datalist id="listaNacionalidade">
                            <option value="Brasileira"></option>
                            <option value="Americana"></option>
                            <option value="Portuguesa"></option>
                            <option value="Italiana"></option>
                            <option value="Japonesa"></option>
                            <option value="Alemã"></option>
                            <option value="Argentina"></option>
                            <option value="Francesa"></option>
                            <option value="Espanhola"></option>
                            <option value="Chinesa"></option>
                        </datalist>
                        <div class="invalid-feedback" id="feedback-nacionalidade">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row">
                    <div class="form-floating col p-0 me-1"><!--CELULAR-->
                        <input type="text" id="celular" class="form-control w-100" placeholder="Celular" aria-label="Celular" name="celular" value="<?php echo $celular; ?>" required maxlength="15">
                        <label for="celular">Celular *</label>
                        <div class="invalid-feedback" id="feedback-celular">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--TELEFONE-->
                        <input type="text" id="telefone" class="form-control w-100" placeholder="Telefone" aria-label="Telefone" name="telefone" value="<?php echo $telefone; ?>" maxlength="14">
                        <label for="telefone">Telefone</label>
                        <div class="invalid-feedback" id="feedback-telefone">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="m-1 row">
                    <div class=" form-floating col p-0 me-1"><!--CNH-->
                        <h6>Categoria de CNH que possui: </h6>
                        <div class=" m-1 form-floating row p-0 me-1">
                            <div class="form-floating col p-0 me-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="A" id="cnhA" name="cnh[]" <?php echo $c = (in_array("A", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhA">
                                        A
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="B" id="cnhB" name="cnh[]" <?php echo $c = (in_array("B", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhB">
                                        B
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="C" id="cnhC" name="cnh[]" <?php echo $c = (in_array("C", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhC">
                                        C
                                    </label>
                                </div>
                            </div>
                            <div class="form-floating col p-0 me-1"><!--CNH-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="D" id="cnhD" name="cnh[]" <?php echo $c = (in_array("D", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhD">
                                        D
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="E" id="cnhE" name="cnh[]" <?php echo $c = (in_array("E", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhE">
                                        E
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="cnhSem" id="cnhSem" name="cnhSem" <?php echo $c = (isset($_SESSION['cnhEstagiario']) && $_SESSION['cnhEstagiario'] === 'N') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhSem">
                                        Não Possuo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--DEPENDENTES-->
                        <input type="number" id="dependentes" min=0 class="form-control w-100" placeholder="Dependentes" aria-label="Dependentes" name="dependentes" value="<?php echo $dependentes; ?>" maxlength="10">
                        <label for="dependentes">Dependentes</label>
                        <div class="invalid-feedback" id="feedback-dependentes">
                            Preencha corretamente!
                        </div>
                        <p class="text-secondary text-end">Digite 0 caso não haja!</p>
                    </div>
                </div>

            </div>

            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="etapa2.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">PRÓXIMO</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacaoEstagiario.js"></script>

</body>

</html>