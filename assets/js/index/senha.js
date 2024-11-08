
function getParameterByName(name) {
    const url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

$(document).ready(function () {

    const parametro = getParameterByName('token');

    if (parametro) {

        $("#principal").html(`<form method="post" class="container d-flex justify-content-center row m-auto" id="formulario">
            <div id="successMessage">Confira sua caixa de entrada</div>
            <div id="errorMessage">Confira sua caixa de entrada</div>
            <h1 class="w-100 text-center">Redefinição de senha</h1>
            <div class="mb-3 wm-50">
                                <label for="senha" class="form-label">Digite a nova senha</label>

                <div class="input-group">
                    <input type="password" class="form-control" id="senha" name="senha"required>
                                            <input type="checkbox" class="btn-check" id="senha-Check" autocomplete="off">
                    <label class="btn btn-outline-info d-flex align-items-center justify-content-center rounded-end" for="senha-Check"><img id="checkPassLabelImgSenha" src="../../../assets/img/icons/eyeSlash.svg" alt="olho de senha"></label>
                    <div class="invalid-feedback" id="feedback-senha">
                                Preencha corretamente!
                    </div>
                </div>
            </div>
           <div class="mb-3 wm-50">
                <label for="confirmacaoSenha" class="form-label">Confirme a nova senha</label>
                <input type="password" class="form-control" id="confirmacaoSenha" name="confirmacaoSenha"required>
                <div class="invalid-feedback" id="feedback-confirmacaoSenha">
                            Preencha corretamente!
                </div>
            </div>
            <input type="hidden" id="token" name="token" value="${parametro}">
            <button type="submit" class="btn btn-primary wm-50">Salvar</button>
        </form>`);

        const senha = $("#senha");
        const feedbackSenha = $("#feedback-senha");
        const confirmacaoSenha = $("#confirmacaoSenha");
        const feedbackConfirmacaoSenha = $("#feedback-confirmacaoSenha");

        //Bloqueia colagem na senha
        senha.bind('cut copy paste', function (e) {
            e.preventDefault();
        });

        //Bloqueia colagem na confirmação de senha
        confirmacaoSenha.bind('cut copy paste', function (e) {
            e.preventDefault();
        });

        function validacaoSenha() {
            let valor = senha.val();
            if (valor.length < 8) {
                feedbackSenha.text('Deve conter no mínimo 8 caracteres *');
                senha.removeClass('is-valid');
                senha.addClass('is-invalid');
                return false;
            }

            if (!/[A-Z]/.test(valor)) {
                feedbackSenha.text('A senha deve conter pelo menos uma letra maiúscula *');
                senha.removeClass('is-valid');
                senha.addClass('is-invalid');
                return false;
            }

            if (!/[a-z]/.test(valor)) {
                feedbackSenha.text('A senha deve conter pelo menos uma letra minúscula *');
                senha.removeClass('is-valid');
                senha.addClass('is-invalid');
                return false;
            }

            if (!/[0-9]/.test(valor)) {
                feedbackSenha.text('A senha deve conter pelo menos um número *');
                senha.removeClass('is-valid');
                senha.addClass('is-invalid');
                return false;
            }

            if (!/[!@#$%^&*(),.?":{}|<>]/.test(valor)) {
                feedbackSenha.text('A senha deve conter pelo menos um caractere especial *');
                senha.removeClass('is-valid');
                senha.addClass('is-invalid');
                return false;
            }

            senha.removeClass('is-invalid');
            senha.addClass('is-valid');
            return true;

        }

        function validacaoConfirmacaoSenha() {
            if (!validacaoSenha()) {
                feedbackConfirmacaoSenha.text('A senha não atende os requisitos *');
                confirmacaoSenha.removeClass('is-valid');
                confirmacaoSenha.addClass('is-invalid');
                return false;
            }

            if (senha.val() === confirmacaoSenha.val()) {
                confirmacaoSenha.addClass('is-valid');
                confirmacaoSenha.removeClass('is-invalid');
                return true;
            } else {
                feedbackConfirmacaoSenha.text('As senhas são divergentes *');
                confirmacaoSenha.removeClass('is-valid');
                confirmacaoSenha.addClass('is-invalid');
                return false;
            }
        }

        senha.on("input", function () {
            validacaoSenha();
        });

        confirmacaoSenha.on("blur change input", function () {
            validacaoConfirmacaoSenha();
        });

        const senhaCheck = $("#senha-Check");
        const checkPassLabelImgSenha = $("#checkPassLabelImgSenha");

        senhaCheck.on('click', function () {
            if (checkPassLabelImgSenha.attr('src') === '../../../assets/img/icons/eyeSlash.svg') {
                checkPassLabelImgSenha.attr('src', '../../../assets/img/icons/eyeFill.svg');
                senha.attr('type', 'text');
                senha.focus();
            } else {
                checkPassLabelImgSenha.attr('src', '../../../assets/img/icons/eyeSlash.svg');
                senha.attr('type', 'password');
                senha.focus();
            }
        });


        $('#formulario').on('submit', function (e) {
            e.preventDefault(); // Previne o comportamento padrão do formulário
            if (validacaoSenha() && validacaoConfirmacaoSenha()) {

                $('#loading').show(); // Exibe o loader

                $.ajax({
                    url: 'server/api/redefinicao_senha.php/redefinicao', // URL do seu script PHP
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#loading').hide(); // Oculta o loader
                        if (response.status === "success") {
                            $('#successMessage').text(response.message);
                            $('#successMessage').show();
                            $('#errorMessage').hide();
                        } else {
                            $('#errorMessage').text(response.message); // Exibe a mensagem de erro
                            $('#errorMessage').show();
                            $('#successMessage').hide();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#loading').hide(); // Oculta o loader
                        console.error("Erro ao enviar a solicitação:", textStatus, errorThrown); // Log detalhado no console
                        console.log("Detalhes da resposta:", jqXHR.responseText); // Mostra a resposta do servidor em caso de erro
                        $('#errorMessage').text("Erro ao enviar sua solicitação. Tente novamente mais tarde."); // Mensagem genérica para o usuário
                        $('#errorMessage').show();
                    }
                });
            }
        });


    } else {//sem token

        $("#principal").html(`<form method="post" class="container d-flex flex-column align-items-center row m-auto" id="formulario">
    <div id="successMessage" class="d-none text-success text-center w-100">Confira sua caixa de entrada</div>
    <div id="errorMessage" class="d-none text-danger text-center w-100">Confira sua caixa de entrada</div>
    <h1 class="w-100 text-center mb-4">Redefinição de senha</h1>
    
    <!-- Campo de E-mail -->
    <div class="col-12 col-md-8 mb-3">
        <div class="row">
            <label for="dado" class="form-label" id="labelDado">Endereço de E-mail</label>
            <input type="email" class="form-control" id="dado" name="dado" placeholder="exemplo@email.com" required>
            <div class="form-text" id="dicaCampo">Digite o email referente à conta.</div>
        </div>
    </div>
    
    <!-- Método de Redefinição e Tipo de Usuário -->
    <div class="col-12 col-md-8 mb-3">
        <div class="row">
            <label for="metodo" class="form-label">Método de redefinição</label>
            <select name="metodo" id="metodo" class="form-select" required>
                <option value="email">Email</option>
                <option value="cpf">CPF</option>
                <option value="cnpj">CNPJ</option>
            </select>
        </div>
        <div class="row mt-3">
            <label for="tipo" class="form-label">Tipo de usuário</label>
            <select name="tipo" id="tipo" class="form-select" required>
                <option value="estagiario">Estagiário</option>
                <option value="empresa">Empresa</option>
                <option value="escola">Instituição de ensino</option>
            </select>
        </div>
    </div>
    
    <!-- Botão de Envio -->
    <button type="submit" class="btn btn-primary mt-4" style="max-width: 300px; width: 100%;">Enviar</button>
</form>


`);


        $('#formulario').on('submit', function (e) {
            e.preventDefault(); // Previne o comportamento padrão do formulário

            $('#loading').show(); // Exibe o loader

            $.ajax({
                url: 'server/api/redefinicao_senha.php', // URL do seu script PHP
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#loading').hide(); // Oculta o loader

                    if (response.status === "success") {
                        $('#successMessage').text(response.message);
                        $('#successMessage').show();
                        $('#errorMessage').hide();

                    } else {
                        $('#errorMessage').text(response.message); // Exibe a mensagem de sucesso
                        $('#errorMessage').show();
                        $('#successMessage').hide();
                    }
                },
                error: function (response) {
                    $('#loading').hide(); // Oculta o loader
                    $('#errorMessage').text("Erro ao enviar sua solicitação. Tente novamente mais tarde"); // Exibe a mensagem de sucesso
                    $('#errorMessage').show();
                    console.log(response.responseText);
                }
            });
        });

        const selectMetodo = $("#metodo");
        const dicaCampo = $("#dicaCampo");
        const labelDado = $("#labelDado");
        const dado = $("#dado");

        selectMetodo.on('change', function(){
            switch($(this).val()){
                case "email":
                default:
                    dicaCampo.text('Digite o email referente a conta.');
                    labelDado.text('Endereço de E-mail');
                    dado.attr('placeholder','exemplo@email.com');
                    dado.text('');
                    dado.attr('type','email');
                    dado.unmask();
                break;
                case "cpf":
                    dicaCampo.text('Digite o CPF referente a conta.');
                    labelDado.text('CPF');
                    dado.attr('placeholder','123.456.789-12');
                    dado.text('');
                    dado.attr('type','text');
                    dado.mask('000.000.000-00', { reverse: false });
                break;
                case "cnpj":
                    dicaCampo.text('Digite o CNPJ referente a conta.');
                    labelDado.text('CNPJ');
                    dado.attr('placeholder','12.345.678/9123-45');
                    dado.text('');
                    dado.attr('type','text');
                    dado.mask('99.999.999/9999-99', { reverse: false });

                break;
            };
        });
    }
});