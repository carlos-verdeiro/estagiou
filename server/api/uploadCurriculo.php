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
        $pasta = "../curriculos/";
        $nome = $arquivo['name'];
        $tamanho = $arquivo['size'];
        $tipo = $arquivo['type'];
        $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
        $novoNome = uniqid() .'.'. $extensao;
        $path = $pasta . $novoNome;

        // Verifica se é um arquivo PDF
        if ($tipo == 'application/pdf') {
            try {
                // Conecta ao banco de dados para verificação
                $mysqliSelect = new mysqli('localhost', 'curriculoSelectEstagiario', '123', 'estagiou');
                if ($mysqliSelect->connect_error) {
                    throw new Exception("Conexão falhou: " . $mysqliSelect->connect_error);
                }

                // Verifica se já existe um currículo para o estagiário
                $stmt0 = $mysqliSelect->prepare("SELECT COUNT(*), caminho_arquivo FROM curriculo WHERE estagiario_id = ?");
                if (!$stmt0) {
                    throw new Exception("Erro na preparação da consulta para verificação: " . $mysqliSelect->error);
                }

                $stmt0->bind_param('i', $estagiario_id);
                $stmt0->execute();
                $stmt0->bind_result($count, $caminho_arquivo);
                $stmt0->fetch();
                $stmt0->close();
                $mysqliSelect->close();

                if ($count > 0) {
                    // Remove o arquivo antigo
                    $caminho_arquivo_antigo = "../curriculos/" . $caminho_arquivo;
                    if (file_exists($caminho_arquivo_antigo)) {
                        unlink($caminho_arquivo_antigo);
                    }
                }

                // Faz o upload do novo arquivo
                $uploadResposta = move_uploaded_file($arquivo['tmp_name'], $path);

                // Conecta ao banco de dados para inserção
                $mysqli = new mysqli('localhost', 'curriculoInsertEstagiario', '123', 'estagiou');
                if ($mysqli->connect_error) {
                    throw new Exception("Conexão falhou: " . $mysqli->connect_error);
                }

                // Inicia uma transação
                $mysqli->begin_transaction();

                if ($count > 0) {
                    // Remove currículos antigos do banco de dados
                    $stmt1 = $mysqli->prepare("DELETE FROM curriculo WHERE estagiario_id = ?");
                    if (!$stmt1) {
                        throw new Exception("Erro na preparação da consulta para remoção: " . $mysqli->error);
                    }

                    $stmt1->bind_param('i', $estagiario_id);
                    $stmt1->execute();
                    $stmt1->close();
                }

                // Insere o novo currículo
                $stmt2 = $mysqli->prepare("INSERT INTO curriculo (estagiario_id, data_submissao, nome_arquivo, tipo_arquivo, tamanho_arquivo, caminho_arquivo, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt2) {
                    throw new Exception("Erro na preparação da consulta para inserção: " . $mysqli->error);
                }

                $stmt2->bind_param('isssiss', $estagiario_id, $data_submissao, $nome, $tipo, $tamanho, $novoNome, $observacoes);
                $stmt2->execute();

                // Atualiza a tabela estagiario com o ID do novo currículo
                $curriculo_id = $stmt2->insert_id;
                $stmt2->close();

                $stmt3 = $mysqli->prepare("UPDATE estagiario SET curriculo_id = ? WHERE id = ?");
                if (!$stmt3) {
                    throw new Exception("Erro na preparação da consulta para atualização: " . $mysqli->error);
                }

                if (!$uploadResposta) {
                    throw new Exception("Erro ao enviar o arquivo");
                }

                $stmt3->bind_param('ii', $curriculo_id, $estagiario_id);
                $stmt3->execute();
                $stmt3->close();

                // Commit da transação
                $mysqli->commit();
                echo "Currículo enviado com sucesso!";
            } catch (Exception $e) {
                // Rollback em caso de exceção
                if (isset($mysqli)) {
                    $mysqli->rollback();
                }
                echo "Erro ao enviar currículo: " . $e->getMessage();
            } finally {
                // Fechar as conexões
                if (isset($mysqli)) $mysqli->close();
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
