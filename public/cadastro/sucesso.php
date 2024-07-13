<link rel="stylesheet" href="../../assets/css/cadastro/action.css">
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucesso</title>
</head>

<body>
    <div>
        <h3>USUÁRIO CADASTRADO COM SUCESSO</h3>
        <h3>Redirecionando para Login em:</h3>
        <h3 id="timer">5</h3>
        <a href="../../index.php?entrar">Fazer Login</a>
    </div>

    <script>
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');

        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;

            if (timeLeft === 0) {
                clearInterval(countdown);
                timerElement.textContent = "Redirecionando...";
                // Redireciona para outra página após 1 segundo
                setTimeout(() => {
                    window.location.href = '../../?entrar'; // URL da página para redirecionar
                }, 1000);
            }
        }, 1000);
    </script>
</body>

</html>