<?php
$host = "localhost"; // Servidor onde o banco de dados está hospedado
$user = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco de dados
$database = "estagiou"; // Nome do banco de dados

// Criação da conexão
$conn = new mysqli($host, $user, $password, $database);

// Verificação da conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4'); // Define o charset para suportar caracteres especiais
?>