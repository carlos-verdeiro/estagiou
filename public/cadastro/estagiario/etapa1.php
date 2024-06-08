<!DOCTYPE html>
<html lang="pt-be">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 1</title>

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

    ?>
    <section id="cadastro">
        <form class="formComponent row">
            <h1 id='tituloCadastro'>CADASTRO</h1>
            <div class="row divInputs">
                <div class="form-floating m-1 row"><!--CPF-->
                    <input type="text" id="cpf" class="form-control w-100" placeholder="CPF" aria-label="CPF" name="cpf" required>
                    <label for="cpf">CPF</label>
                    <div class="invalid-feedback" id="feedback-cpf">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME-->
                    <input type="text" id="nome" class="form-control w-100" placeholder="Nome" aria-label="Nome" name="nome" required>
                    <label for="nome">Nome</label>
                    <div class="invalid-feedback" id="feedback-nome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--SOBRENOME-->
                    <input type="text" id="sobrenome" class="form-control w-100" placeholder="Sobrenome" aria-label="Sobrenome" name="sobrenome">
                    <label for="sobrenome">Sobrenome</label>
                    <div class="invalid-feedback" id="feedback-sobrenome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL-->
                    <input type="email" id="email" class="form-control w-100" placeholder="Email" aria-label="Email" name="email" required>
                    <label for="email">E-mail</label>
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

    <script src="../../../assets/js/cadastro/validacao1.js"></script>

</body>

</html>