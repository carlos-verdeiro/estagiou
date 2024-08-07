<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o estagiário está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin'])) {
        die("Erro: Usuário não autenticado.");
    }

    // Obtém dados do formulário
    $id = $_SESSION['idUsuarioLogin'];

    try {

        // Conecta ao banco de dados para verificação
        $mysqliSelect = new mysqli('localhost', 'root', '', 'estagiou');
        if ($mysqliSelect->connect_error) {
            throw new Exception("Conexão falhou: " . $mysqliSelect->connect_error);
        }

        // Verifica se já existe um currículo para o estagiário
        $stmt0 = $mysqliSelect->prepare("SELECT COUNT(*), caminho_arquivo FROM curriculo WHERE estagiario_id = ?");
        if (!$stmt0) {
            throw new Exception("Erro na preparação da consulta para verificação: " . $mysqliSelect->error);
        }

        $stmt0->bind_param('i', $id);
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

        // Conecta ao banco de dados para delete
        $mysqli = new mysqli('localhost', 'root', '', 'estagiou');
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

            $stmt1->bind_param('i', $id);
            $stmt1->execute();
            $stmt1->close();
        }
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
    echo "Método de requisição inválido.";
}
