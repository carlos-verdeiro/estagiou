<header class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-custom-1 ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <div class="" id="divLogo">
                    <img src="assets/img/logo/logo.svg" alt="Logo Estagiou">
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
                        <a class="nav-link" href="#" id="toastLoginBtn">Entrar</a>
                    </li>
                    <li class="nav-item center-h">
                        <button type="button" class="btn btn-success" aria-current="page">Realizar Cadastro</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--   TOAST DE LOGIN    -->
    <div class="toast-container position-fixed p-3" id="toastLogin">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header">
                <img src="assets/img/logo/logo_transparente.png" class="rounded me-2" alt="Mini logo">
                <strong class="me-auto">Entrar</strong>
                <small>Login</small>
            </div>
            <div class="toast-body">
                <form class="form-floating">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Usuário ou e-mail">
                        <label for="floatingInput">Usuário ou e-mail</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Senha</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Acessar</button>
                </form>
            </div>
        </div>
    </div>
</header>