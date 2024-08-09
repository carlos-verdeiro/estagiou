<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se a empresa está autenticada
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
        // Inclui o arquivo de conexão
        include_once '../../conexao.php';

        // Conecta ao banco de dados para inserção
        $stmt = $conn->prepare("INSERT INTO vaga (empresa_id, titulo, descricao, requisitos, data_encerramento) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param('issss', $empresa_id, $titulo, $descricao, $requisitos, $data_encerramento);
        $stmt->execute();
        $stmt->close();

        echo "Vaga criada com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao criar vaga: " . $e->getMessage();
    } finally {
        // Fechar a conexão
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
?>
