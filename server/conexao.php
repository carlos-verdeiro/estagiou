<?php   
$confDB = 'mysql:host=localhost;dbname=estagiou;charset=utf8';

$optionsDB = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false, 
];

try {
    $pdo = new PDO($confDB, $usernameDB, $passwordDB, $optionsDB);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}


?>