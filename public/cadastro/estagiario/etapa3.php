<?php
session_start();


if (
    isset($_POST['dataNascimento']) && !empty($_POST['dataNascimento']) &&
    isset($_POST['nacionalidade']) && !empty($_POST['nacionalidade']) &&
    isset($_POST['celular']) && !empty($_POST['celular']) &&
    isset($_POST['cnhSem']) || isset($_POST['cnh']) &&
    isset($_POST['dependentes']) && !empty($_POST['dependentes']) || isset($_POST['semDependentes'])

) {
    $_SESSION["dataNascimentoEstagiario"] = htmlspecialchars($_POST['dataNascimento'], ENT_QUOTES, 'UTF-8');
    $_SESSION["nacionalidadeEstagiario"] = htmlspecialchars($_POST['nacionalidade'], ENT_QUOTES, 'UTF-8');
    $_SESSION["celularEstagiario"] = htmlspecialchars($_POST['celular'], ENT_QUOTES, 'UTF-8');
    $_SESSION["generoEstagiario"] = htmlspecialchars($_POST['genero'], ENT_QUOTES, 'UTF-8');

    if (isset($_POST['nomeSocial']) && !empty($_POST['nomeSocial'])) {
        $_SESSION["nomeSocialEstagiario"] = htmlspecialchars($_POST['nomeSocial'], ENT_QUOTES, 'UTF-8');
    } else {
        $_SESSION["nomeSocialEstagiario"] = '';
    }

    $_SESSION["estadoCivilEstagiario"] = htmlspecialchars($_POST['estadoCivil'], ENT_QUOTES, 'UTF-8');
    $_SESSION['statusCadastro'] = "andamento";
    $_SESSION['etapaCadastro'] = 4;
    header("Location: etapa" . $_SESSION['etapaCadastro'] . ".php");
    exit;
} else {
    $_SESSION['etapaCadastro'] = 3;
}


?>


<!DOCTYPE html>
<html lang="pt-be">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 3</title>

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
    define('DATA_NASCIMENTO_KEY', 'dataNascimentoEstagiario');
    define('NACIONALIDADE_KEY', 'nacionalidadeEstagiario');
    define('CNH_KEY', 'cnhEstagiario');
    define('DEPENDENTES_KEY', 'dependentesEstagiario');
    define('CELULAR_KEY', 'celularEstagiario');
    define('TELEFONE_KEY', 'telefoneEstagiario');

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
        <form class="formComponent row" method="post" id="formEtapa2">
            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs ">
                <div class="m-1 row">
                    <div class="form-floating col p-0 me-1"><!--ÓRGÃO EMISSOR-->
                        <input type="date" id="dataNascimento" min="1924-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control w-100" placeholder="Data de nascimento" aria-label="Data de nascimento" name="dataNascimento" value="<?php echo $dataNascimento; ?>" required>
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
                        <div class="invalid-feedback" id="feedback-orgaoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row">
                    <div class="form-floating col p-0 me-1"><!--CELULAR-->
                        <input type="text" id="celular" class="form-control w-100" placeholder="Celular" aria-label="Celular" name="celular" value="<?php echo $celular; ?>" required>
                        <label for="celular">Celular *</label>
                        <div class="invalid-feedback" id="feedback-celular">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--TELEFONE-->
                        <input type="text" id="telefone" class="form-control w-100" placeholder="Telefone" aria-label="Telefone" name="telefone" value="<?php echo $telefone; ?>">
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
                                    <input class="form-check-input" type="checkbox" value="A" id="cnhA" name="cnh">
                                    <label class="form-check-label" for="cnhA">
                                        A
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="B" id="cnhB" name="cnh">
                                    <label class="form-check-label" for="cnhB">
                                        B
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="C" id="cnhC" name="cnh">
                                    <label class="form-check-label" for="cnhC">
                                        C
                                    </label>
                                </div>
                            </div>
                            <div class="form-floating col p-0 me-1"><!--CNH-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="D" id="cnhD" name="cnh">
                                    <label class="form-check-label" for="cnhD">
                                        D
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="E" id="cnhE" name="cnh">
                                    <label class="form-check-label" for="cnhE">
                                        E
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="cnhSem" id="cnhSem" name="cnhSem">
                                    <label class="form-check-label" for="cnhSem">
                                        Não Possuo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--DEPENDENTES-->
                        <input type="number" id="dependentes" min=0 class="form-control w-100" placeholder="Dependentes" aria-label="Dependentes" name="dependentes" value="<?php echo $dependentes; ?>" maxlength="10" required>
                        <label for="dependentes">Dependentes *</label>
                        <div class="invalid-feedback" id="feedback-dependentes">
                            Preencha corretamente!
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="semDependentes" id="semDependentes" name="semDependentes">
                            <label class="form-check-label" for="semDependentes">
                                Sem dependentes
                            </label>
                        </div>
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