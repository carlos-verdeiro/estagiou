

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/icons/favicontransparente.ico" type="image/x-icon">
    <title>Estagiou - Esqueci Senha</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.js"></script>
    <script src="assets/js/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="assets/css/index/senha.css">
</head>

<body>
    <?php include_once "assets/templates/index/header_fora.php"; ?>
    <main class="d-flex justify-content-center" id="principal">
        <form method="post" class="container d-flex justify-content-center row m-auto" id="formulario">
            <div id="successMessage">Confira sua caixa de entrada</div>
            <div id="errorMessage">Confira sua caixa de entrada</div>
            <h1 class="w-100 text-center">Redefinição de senha</h1>
            <div class="mb-3 wm-50">
                <label for="email" class="form-label">Endereço de E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@email.com" required>
                <div class="form-text">Digite o email referente a conta.</div>
            </div>
            <div class="mb-3 wm-50">
                <label for="tipo" class="form-label">Tipo de usuário</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="estagiario">Estagiário</option>
                    <option value="empresa">Empresa</option>
                    <option value="escola">Instituição de ensino</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary wm-50">Enviar</button>
        </form>
    </main>
    <div id="loading">
        <p>Carregando...</p>
    </div>
    <script src="assets/js/index/senha.js"></script>
</body>

</html>