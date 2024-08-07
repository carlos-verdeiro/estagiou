<header class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-custom-1 ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
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
                        <a class="nav-link btn active" aria-current="page" id="btnIndex">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" id="btnSobre">Sobre nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" id="btnObjetivos">Objetivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" id="btnSuporte">Suporte</a>
                    </li>
                </ul>
                <!--BOTÕES CADASTRO E LOGIN-->
                <ul class="navbar-nav mb-2 mb-lg-0 w-25 column-gap-3" id="loginEntrar">
                    <li class="nav-item" id="liEntrar">
                        <button class="btn nav-link"id="toastLoginBtn">Entrar</button>
                    </li>
                    <li class="nav-item center-h">
                        <a type="button" class="btn btn-success" aria-current="page" id="btnCadastro" href="public/cadastro/cadastro.php">Realizar Cadastro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--   TOAST DE LOGIN    -->
    <div class="toast-container position-fixed p-3" id="toastLogin" data-bs-theme="light">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-header">
                <img src="assets/img/logo/logo_transparente.png" class="rounded me-2" alt="Mini logo">
                <strong class="me-auto">Entrar</strong>
                <small>Login</small>
            </div>
            <div class="toast-body">
                <form class="form-floating" method="post" action="public/login.php">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Usuário ou e-mail" name="email" required>
                        <label for="floatingInput">E-mail</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="senha" required>
                        <label for="floatingPassword">Senha</label>
                    </div>
                    <div>
                        <a href="#" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Esqueceu sua senha?</a>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Acessar</button>
                </form>
            </div>
        </div>
    </div>
</header>