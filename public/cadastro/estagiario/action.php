<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring.js"></script>
<link rel="stylesheet" href="../../../assets/css/cadastro/action.css">
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carregando...</title>
</head>

<body>
  <div>
    <h3>Carregando...</h3>
    <l-ring size="200" stroke="10" bg-opacity="0" speed="2" color="#4c4eba"></l-ring>
    <a href="../cadastro.php">Cancelar</a>
  </div>
</body>

</html>

<?php


session_start();

// Gere um token de sessão se ele ainda não existir
if (isset($_SESSION['statusCadastro']) && $_SESSION['statusCadastro'] == "confirmado") {

  header("location: insert.php");
  exit;
}

if (isset($_SESSION['statusCadastro']) && $_SESSION['statusCadastro'] == "andamento") {

  if (isset($_SESSION['etapaCadastro']) && $_SESSION['etapaCadastro'] != NULL) {

    header("location: etapa" . $_SESSION['etapaCadastro'] . ".php");
    exit;
  }
  header("location: ../cadastro.php");
  exit;
}

session_destroy();
session_start();
$_SESSION['statusCadastro'] = "andamento";
$_SESSION['etapaCadastro'] = 1;
header("location: etapa" . $_SESSION['etapaCadastro'] . ".php");
exit;



header("location: ../cadastro.php");

?>