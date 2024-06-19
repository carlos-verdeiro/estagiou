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
if (isset($_SESSION['statusCadastro']) && $_SESSION['statusCadastro'] == "finalizado") {
  session_destroy();
  session_start();
  $_SESSION['statusCadastro'] = "andamento";
  $_SESSION['etapaCadastro'] = 1;
  header("location: etapa1.php");
  exit;
} else if (isset($_SESSION['statusCadastro']) && $_SESSION['statusCadastro'] == "andamento") {

  if (isset($_SESSION['etapaCadastro']) && $_SESSION['etapaCadastro'] != NULL) {

    header("location: etapa" . $_SESSION['etapaCadastro'] . ".php");
    exit;
  }

} else {
  $_SESSION['statusCadastro'] = "andamento";
  $_SESSION['etapaCadastro'] = 1;
  header("location: etapa" . $_SESSION['etapaCadastro'] . ".php");
  exit;
}


header("location: ../cadastro.php");

?>