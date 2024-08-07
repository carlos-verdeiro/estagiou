<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o estagiário está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        die("Erro: Usuário não autenticado.");
    }

    // Obtém dados do formulário
    $empresa_id = $_SESSION['idUsuarioLogin'];
    $titulo = $_POST['tituloVaga'];
    $descricao = isset($_POST['descricaoVaga']) ? $_POST['descricaoVaga'] : '';
    $requisitos = isset($_POST['requisitosVaga']) ? $_POST['requisitosVaga'] : '';
    $data_encerramento = isset($_POST['dataEncerramentoVaga']) ? $_POST['dataEncerramentoVaga'] : null;

    try {

        // Conecta ao banco de dados para verificação
        $mysqli = new mysqli('localhost', 'root', '', 'estagiou');
        if ($mysqli->connect_error) {
            throw new Exception("Conexão falhou: " . $mysqliSelect->connect_error);
        }

        // Verifica se já existe um currículo para o estagiário
        $stmt = $mysqli->prepare("INSERT INTO vaga(empresa_id,titulo,descricao,requisitos,data_encerramento) VALUES(?,?,?,?,?)");
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta para verificação: " . $mysqliSelect->error);
        }

        $stmt->bind_param('issss', $empresa_id, $titulo, $descricao, $requisitos, $data_encerramento);
        $stmt->execute();
        $stmt->close();

        echo "Criado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao criar vaga: " . $e->getMessage();
    } finally {
        // Fechar as conexões
        if (isset($mysqli)) $mysqli->close();
    }
} else {
    echo "Método de requisição inválido.";
}
