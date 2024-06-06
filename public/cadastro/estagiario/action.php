<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring.js"></script>
<link rel="stylesheet" href="../../../assets/css/cadastro/action.css">
<!DOCTYPE html>
<html lang="pt-be">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carregando...</title>
</head>

<body>
  <div>
    <l-ring size="2a00" stroke="10" bg-opacity="0" speed="2" color="#4c4eba"></l-ring>
    <h3>Carregando...</h3>
    <a href="../cadastro.php">Cancelar</a>
  </div>
</body>

</html>

<?php

session_start();

// Gere um token de sessão se ele ainda não existir
if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32)); // Gera um token aleatório seguro
}

$token = $_SESSION['token'];

header("location: etapa1.php");

?>