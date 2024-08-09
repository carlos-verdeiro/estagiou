<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o estagiário está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        die("Erro: Usuário não autenticado.");
    }

    // Obtém dados do formulário
    $id = $_SESSION['idUsuarioLogin'];

    // Inclui o arquivo de conexão
    include_once '../../conexao.php';

    try {
        // Verifica se já existe um currículo para o estagiário
        $stmt0 = $conn->prepare("SELECT COUNT(*), caminho_arquivo FROM curriculo WHERE estagiario_id = ?");
        if (!$stmt0) {
            throw new Exception("Erro na preparação da consulta para verificação: " . $conn->error);
        }

        $stmt0->bind_param('i', $id);
        $stmt0->execute();
        $stmt0->bind_result($count, $caminho_arquivo);
        $stmt0->fetch();
        $stmt0->close();

        if ($count > 0) {
            // Remove o arquivo antigo
            $caminho_arquivo_antigo = "../curriculos/" . $caminho_arquivo;
            if (file_exists($caminho_arquivo_antigo)) {
                unlink($caminho_arquivo_antigo);
            }
        }

        // Inicia uma transação
        $conn->begin_transaction();

        if ($count > 0) {
            // Remove currículos antigos do banco de dados
            $stmt1 = $conn->prepare("DELETE FROM curriculo WHERE estagiario_id = ?");

            if (!$stmt1) {
                throw new Exception("Erro na preparação da consulta para remoção: " . $conn->error);
            }

            $stmt1->bind_param('i', $id);
            $stmt1->execute();
            $stmt1->close();

            // Remove currículos antigos da coluna do estagiario
            $stmt1 = $conn->prepare("UPDATE estagiario SET curriculo_id = null WHERE id = ?");

            if (!$stmt1) {
                throw new Exception("Erro na preparação da consulta para remoção: " . $conn->error);
            }

            $stmt1->bind_param('i', $id);
            $stmt1->execute();
            $stmt1->close();
        }

        // Commit da transação
        $conn->commit();

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
    echo "Método de requisição inválido.";
}
?>
