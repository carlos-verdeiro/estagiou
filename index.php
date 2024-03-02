<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/logo/favicontransparente.ico" type="image/x-icon">
    <title>Estagiou</title>

    <link rel="stylesheet" href="assets/css/index.css">

    <!--BIBLIOTECAS-->


    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!--FIM BOOTSTRAP-->

    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!--FIM JQUERY-->


    <!--FIM BIBLIOTECAS-->
</head>

<body>
    <header class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-custom-1">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <div class="" id="divLogo">
                        <img src="assets/img/logo/logo.png" alt="Logo Estagiou">
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    MENU
                </button>
                <div class="collapse navbar-collapse " id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Sobre nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Objetivos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Suporte</a>
                        </li>
                    </ul>
                    <!--BOTÕES CADASTRO E LOGIN-->
                    <ul class="navbar-nav mb-2 mb-lg-0 w-25 column-gap-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Entrar</a>
                        </li>
                        <li class="nav-item center-h">
                            <button type="button" class="btn btn-success" aria-current="page">Realizar Cadastro</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="container-fluid" id="sectionBanner">
        <img src="assets/img/logo/logo.svg" alt="Banner da empresa" id="logoSVG">
        <img src="assets/img/logo/titulo.svg" alt="Título da empresa" id="tituloSVG">

    </section>
</body>

</html>