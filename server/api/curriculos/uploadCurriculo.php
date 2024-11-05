<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o estagiário está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        die("Erro: Usuário não autenticado.");
    }

    // Obtém dados do formulário
    $estagiario_id = $_SESSION['idUsuarioLogin'];
    $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';
    $data_submissao = date('Y-m-d');

    // Verifica se o arquivo foi enviado sem erros
    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] == UPLOAD_ERR_OK) {
        $arquivo = $_FILES['curriculo'];
        $pasta = "../../curriculos/";
        $nome = $arquivo['name'];
        $tamanho = $arquivo['size'];
        $tipo = $arquivo['type'];
        $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
        $novoNome = uniqid() . '.' . $extensao;
        $path = $pasta . $novoNome;

        // Verifica se o diretório existe e o cria se necessário
        if (!is_dir($pasta)) {
            if (!mkdir($pasta, 0755, true)) {
                die("Erro ao criar o diretório de upload.");
            }
        }

        // Verifica se é um arquivo PDF
        if ($tipo == 'application/pdf') {
            include_once '../../conexao.php'; // Inclui o arquivo de conexão

            try {
                // Inicia a transação
                $conn->begin_transaction();

                // Verifica se já existe um currículo para o estagiário
                $stmt0 = $conn->prepare("SELECT id, caminho_arquivo FROM curriculo WHERE estagiario_id = ?");
                if (!$stmt0) {
                    throw new Exception("Erro na preparação da consulta para verificação: " . $conn->error);
                }

                $stmt0->bind_param('i', $estagiario_id);
                $stmt0->execute();
                $stmt0->bind_result($curriculo_id, $caminho_arquivo);
                $stmt0->fetch();
                $stmt0->close();

                // Se já existir currículo, faça a atualização, caso contrário insira um novo
                if (!empty($curriculo_id)) {
                    // Remove o arquivo antigo
                    $caminho_arquivo_antigo = "../../curriculos/" . $caminho_arquivo;
                    if (file_exists($caminho_arquivo_antigo)) {
                        unlink($caminho_arquivo_antigo);
                    }

                    // Faz o upload do novo arquivo
                    if (!move_uploaded_file($arquivo['tmp_name'], $path)) {
                        throw new Exception("Erro ao enviar o arquivo");
                    }

                    // Atualiza o currículo existente no banco de dados
                    $stmt2 = $conn->prepare("UPDATE curriculo SET data_submissao = ?, nome_arquivo = ?, tipo_arquivo = ?, tamanho_arquivo = ?, caminho_arquivo = ?, observacoes = ? WHERE id = ?");
                    if (!$stmt2) {
                        throw new Exception("Erro na preparação da consulta para atualização: " . $conn->error);
                    }

                    $stmt2->bind_param('sssissi', $data_submissao, $nome, $tipo, $tamanho, $novoNome, $observacoes, $curriculo_id);
                    $stmt2->execute();
                    $stmt2->close();
                } else {
                    // Faz o upload do novo arquivo
                    if (!move_uploaded_file($arquivo['tmp_name'], $path)) {
                        throw new Exception("Erro ao enviar o arquivo");
                    }

                    // Insere o novo currículo
                    $stmt2 = $conn->prepare("INSERT INTO curriculo (estagiario_id, data_submissao, nome_arquivo, tipo_arquivo, tamanho_arquivo, caminho_arquivo, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    if (!$stmt2) {
                        throw new Exception("Erro na preparação da consulta para inserção: " . $conn->error);
                    }

                    $stmt2->bind_param('isssiss', $estagiario_id, $data_submissao, $nome, $tipo, $tamanho, $novoNome, $observacoes);
                    $stmt2->execute();
                    $curriculo_id = $stmt2->insert_id;
                    $stmt2->close();

                    // Atualiza a tabela estagiario com o ID do novo currículo
                    $stmt3 = $conn->prepare("UPDATE estagiario SET curriculo_id = ? WHERE id = ?");
                    if (!$stmt3) {
                        throw new Exception("Erro na preparação da consulta para atualização: " . $conn->error);
                    }

                    $stmt3->bind_param('ii', $curriculo_id, $estagiario_id);
                    $stmt3->execute();
                    $stmt3->close();
                }

                // Commit da transação
                $conn->commit();

                echo "Currículo enviado com sucesso!";
            } catch (Exception $e) {
                // Rollback em caso de exceção
                if (isset($conn)) {
                    $conn->rollback();
                }
                echo "Erro ao enviar currículo: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }
        } else {
            echo "Erro: Somente arquivos PDF são permitidos.";
        }
    } else {
        echo "Erro ao enviar o arquivo.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
