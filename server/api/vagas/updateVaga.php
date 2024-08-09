<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400); // Bad Request
    echo json_encode(['mensagem' => 'Método de requisição inválido.', 'code' => 1]);
    exit;
}

// Verifica se a empresa está autenticada
if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== 'empresa') {
    http_response_code(401); // Unauthorized
    echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
    exit;
}

// Obtém dados do formulário
$empresa_id = $_SESSION['idUsuarioLogin'];
$titulo = $_POST['tituloEditarVaga'];
$descricao = isset($_POST['descricaoEditarVaga']) ? $_POST['descricaoEditarVaga'] : '';
$requisitos = isset($_POST['requisitosEditarVaga']) ? $_POST['requisitosEditarVaga'] : '';
$data_encerramento = isset($_POST['dataEncerramentoEditarVaga']) ? $_POST['dataEncerramentoEditarVaga'] : null;
$idVagaEditar = $_POST['idVagaEditar'];

try {
    // Inclui o arquivo de conexão
    include_once '../../conexao.php';

    // Prepara a consulta para atualizar a vaga
    $stmt = $conn->prepare("UPDATE vaga SET titulo=?, descricao=?, requisitos=?, data_encerramento=? WHERE id = ? AND empresa_id = ?");
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conn->error);
    }

    // Faz o binding dos parâmetros e executa a consulta
    $stmt->bind_param('ssssii', $titulo, $descricao, $requisitos, $data_encerramento, $idVagaEditar, $empresa_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Nenhuma vaga foi atualizada. Verifique se a vaga e a empresa estão corretos.");
    }

    $stmt->close();
    echo json_encode(['mensagem' => 'Vaga atualizada com sucesso.']);
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
} finally {
    // Fecha a conexão
    if (isset($conn)) $conn->close();
}
