<section id="sectionLogin">
    <style>
        #sectionLogin {
            background: var(--color-custom-2);
            width: 100%;
            min-height: 85vh;
            max-height: max-content;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            flex-direction: row-reverse;
            flex-wrap: wrap;


            & #loginDiv1 {
                max-width: 50%;
                width: 600px;
                max-width: 90%;
                min-height: 50%;
                max-height: 100%;
                background-color: var(--color-custom-5);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                padding: 20px;
                border-radius: 50px;

                & form {
                    width: 85%;
                    height: 100%;
                }
            }

            & #loginDiv2 {
                width: 600px;
                max-width: 90%;
                max-height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;

                & img {
                    max-height: 85vh;
                    width: 100%;

                }
            }
        }
    </style>
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
                    <label class="btn btn-outline-warning" for="btn-check-outlined"><img id="checkPassLabelImg" src="assets/img/eyeSlash.svg" alt="olho de senha"></label>
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

<script>
    $(document).ready(function() {
        const checkPass = $("#btn-check-outlined");
        const checkPassLabelImg = $("#checkPassLabelImg");
        const inputPass = $("#validationCustomPass")

        checkPass.on('click', function() {
            if (checkPassLabelImg.attr('src') === 'assets/img/eyeSlash.svg') {
                checkPassLabelImg.attr('src', 'assets/img/eyeFill.svg');
                inputPass.attr('type', 'text');
                inputPass.focus();
            } else {
                checkPassLabelImg.attr('src', 'assets/img/eyeSlash.svg');
                inputPass.attr('type', 'password');
                inputPass.focus();
            }
        });
    });
</script>