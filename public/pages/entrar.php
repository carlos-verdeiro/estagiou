<section id="sectionLogin">
    <link rel="stylesheet" href="assets/css/index/entrar.css">
    <div id="loginDiv1">
        <div>
            bagui do google
        </div>
        <hr>
        <form>
            <div class="mb-3">
                <label for="userLogin" class="form-label">Usuário ou e-mail</label>
                <input type="text" class="form-control" id="userLogin" aria-describedby="User" name="userPass" required>
                <div id="userHelp" class="form-text">Não compartilhe sua conta com ninguém!</div>
            </div>
            <div class="mb-3">
                <label for="validationCustomPass" class="form-label">Senha</label>
                <div class="input-group has-validation">
                    <input type="password" class="form-control" id="validationCustomPass" aria-describedby="inputGroupPrepend" required>
                    <input type="checkbox" class="btn-check" id="btn-check-outlined" autocomplete="off">
                    <label class="btn btn-outline-info" for="btn-check-outlined"><img id="checkPassLabelImg" src="assets/img/icons/eyeSlash.svg" alt="olho de senha"></label>
                </div>
            </div>
            <div class="mb-3">
                <a href="#" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Esqueceu sua senha?</a>
            </div>
            <div>
                <button type="submit" class="btn btn-success mb-3 w-100">Entrar</button>
            </div>
        </form>
    </div>
    <div id="loginDiv2"><img src="assets\img\loginImg.svg" alt="Imagem de login"></div>
</section>

<script src="assets/js/index/entrar.js"></script>