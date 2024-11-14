<section id="sectionLogin">
    <link rel="stylesheet" href="assets/css/index/entrar.css">
    <div id="loginDiv1">
        <div>
            bagui do google
        </div>
        <hr>
        <form method="post" action="public/login.php">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" class="form-control" id="email" aria-describedby="email" name="email" required>
                <div id="emailHelp" class="form-text">Não compartilhe sua conta com ninguém!</div>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="senha" aria-describedby="senha" name="senha" required>
                    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
                    <label class="btn btn-outline-info" for="btn-check-outlined"><img id="checkPassLabelImg" src="assets/img/icons/eyeSlash.svg" alt="olho de senha"></label>
                </div>
            </div>
            <div class="mb-3">
                <a href="esqueci_senha.php" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Esqueceu sua senha?</a>
            </div>
            <div>
                <button type="submit" class="btn btn-success mb-3 w-100">Entrar</button>
            </div>
        </form>
    </div>
    <div id="loginDiv2"><img src="assets\img\loginImg.svg" alt="Imagem de login"></div>
</section>

<script src="assets/js/index/entrar.js"></script>