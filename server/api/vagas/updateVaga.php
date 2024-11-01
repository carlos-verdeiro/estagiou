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


// Sanitização e processamento da URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

// Validação do segmento da URI
if (!isset($uri[5]) || empty($uri[5])) {
    http_response_code(404); // Não encontrado
    echo json_encode(['mensagem' => 'Recurso não especificado.', 'code' => 4]);
    exit;
}

switch ($uri[5]) {
    case "editar":
        $titulo = $_POST['tituloEditarVaga'];
        $descricao = isset($_POST['descricaoEditarVaga']) ? $_POST['descricaoEditarVaga'] : '';
        $requisitos = isset($_POST['requisitosEditarVaga']) ? $_POST['requisitosEditarVaga'] : '';
        $data_encerramento = isset($_POST['dataEncerramentoEditarVaga']) ? $_POST['dataEncerramentoEditarVaga'] : null;
        $idVagaEditar = $_POST['idVagaEditar'];

        try {
            // Inclui o arquivo de conexão
            include_once '../../conexao.php';

            // Prepara a consulta para atualizar a vaga
            $stmt = $conn->prepare("UPDATE vaga 
                                    SET 
                                        titulo = ?, 
                                        descricao = ?, 
                                        requisitos = ?, 
                                        data_encerramento = ?, 
                                        encerrado = IF(data_encerramento IS NOT NULL, 0, 1)
                                    WHERE 
                                        id = ? AND 
                                        empresa_id = ?;
                                    ");
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
        break;

    case "encerramento":
        $idVagaEditar = $_POST['idVaga'];

        try {
            include_once '../../conexao.php';
            header('Content-Type: application/json'); // Define o cabeçalho como JSON

            $stmt = $conn->prepare("
                        UPDATE vaga 
                        SET 
                            encerrado = CASE 
                                WHEN encerrado = 0 THEN 1 
                                ELSE 0 
                            END,
                            data_encerramento = NULL
                        WHERE id = ? AND empresa_id = ?;
                        ");

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $conn->error);
            }

            $stmt->bind_param('ii', $idVagaEditar, $empresa_id);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                throw new Exception("Nenhuma vaga foi atualizada. Verifique se a vaga e a empresa estão corretos.");
            }

            $stmt->close();
            echo json_encode(['mensagem' => 'Vaga atualizada com sucesso.', 'code' => 1]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
        } finally {
            if (isset($conn)) $conn->close();
        }
        break;
};
