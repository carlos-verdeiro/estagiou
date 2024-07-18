<?php
session_start();

try {
    // Conectar com usuário e senha específicos para atualização
    $dsn = 'mysql:host=localhost;dbname=estagiou;charset=utf8mb4';
    $selectUser = 'curriculoSelectEstagiario';
    $selectPassword = '123';

    $conn = new PDO($dsn, $selectUser, $selectPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificação no banco de dados para encontrar o currículo do estagiário
    $select_stmt = $conn->prepare("SELECT curriculo_id FROM estagiario WHERE id = :id");
    $select_stmt->bindValue(':id', $_SESSION['idUsuarioLogin'], PDO::PARAM_INT);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row['curriculo_id']) {
        echo json_encode(['status' => 'notFound', 'message' => 'Você não possui nenhum currículo salvo.']);
    } else {
        // Verificação no banco de dados para encontrar os detalhes do currículo
        $select_stmt = $conn->prepare("SELECT * FROM curriculo WHERE estagiario_id = :id");
        $select_stmt->bindValue(':id', $_SESSION['idUsuarioLogin'], PDO::PARAM_INT);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $caminho = '../curriculos/' . $row['caminho_arquivo'];
            $nome = $row['nome_arquivo'];
            $observacoes = $row['observacoes'];
            $data_submissao = $row['data_submissao'];

            // Verifica se o arquivo existe
            if (file_exists($caminho)) {
                echo json_encode(['status' => 'success', 'file' => $caminho, 'nome' => $nome, 'observacoes' => $observacoes, 'data_submissao' => $data_submissao]);
            } else {
                echo json_encode(['status' => 'notFound', 'message' => 'Arquivo PDF não encontrado.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum registro encontrado.']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro na conexão: ' . $e->getMessage()]);
}
