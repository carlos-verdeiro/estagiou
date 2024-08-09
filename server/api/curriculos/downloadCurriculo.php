<?php
session_start();

include_once '../../conexao.php';

try {
    // Verificação no banco de dados para encontrar o currículo do estagiário
    $select_stmt = $conn->prepare("SELECT curriculo_id FROM estagiario WHERE id = ?");
    $select_stmt->bind_param('i', $_SESSION['idUsuarioLogin']);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row['curriculo_id']) {
        echo json_encode(['status' => 'notFound', 'message' => 'Você não possui nenhum currículo salvo.']);
    } else {
        // Verificação no banco de dados para encontrar os detalhes do currículo
        $select_stmt = $conn->prepare("SELECT * FROM curriculo WHERE estagiario_id = ?");
        $select_stmt->bind_param('i', $_SESSION['idUsuarioLogin']);
        $select_stmt->execute();
        $result = $select_stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $caminho = '../../curriculos/' . $row['caminho_arquivo'];
            $caminhoCliente = '../curriculos/' . $row['caminho_arquivo'];
            $nome = $row['nome_arquivo'];
            $observacoes = $row['observacoes'];
            $data_submissao = $row['data_submissao'];

            // Verifica se o arquivo existe
            if (file_exists($caminho)) {
                echo json_encode(['status' => 'success', 'file' => $caminhoCliente, 'nome' => $nome, 'observacoes' => $observacoes, 'data_submissao' => $data_submissao]);
            } else {
                echo json_encode(['status' => 'notFound', 'message' => 'Arquivo PDF não encontrado.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum registro encontrado.']);
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro na conexão: ' . $e->getMessage()]);
}
?>
