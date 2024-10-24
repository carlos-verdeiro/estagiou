<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== "empresa") {
        die("Erro: Usuário não autenticado.");
    }

    $id_empresa = $_SESSION['idUsuarioLogin'];
    $id_candidatura = $_POST['idCand'];

    if (!is_numeric($id_candidatura) || $id_candidatura <= 0) {
        die("Erro: ID do candidato inválido.");
    }

    try {
        include_once '../../conexao.php';

        $query = "SELECT candidatura.*, vaga.empresa_id 
                  FROM candidatura
                  INNER JOIN vaga ON candidatura.id_vaga = vaga.id
                  WHERE candidatura.id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param('i', $id_candidatura);
        $stmt->execute();
        $result = $stmt->get_result();
        $candidatura = $result->fetch_assoc();
        $stmt->close();

        if ($candidatura && $candidatura['empresa_id'] == $id_empresa) {
            $id_vaga = $candidatura['id_vaga'];
            $id_estagiario = $candidatura['id_estagiario'];

            // Verificar se já existe um contrato para o mesmo estagiário na mesma vaga
            $query = "SELECT COUNT(*) as total FROM contratos WHERE id_estagiario = ? AND id_vaga = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta de verificação: " . $conn->error);
            }

            $stmt->bind_param('ii', $id_estagiario, $id_vaga);
            $stmt->execute();
            $result = $stmt->get_result();
            $verificacao = $result->fetch_assoc();
            $stmt->close();

            if ($verificacao['total'] > 0) {
                echo "Erro: Já existe um contrato para este estagiário nesta vaga.";
            } else {
                // Inserir o novo contrato
                $query = "INSERT INTO contratos (id_estagiario, id_empresa, id_vaga) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta de inserção: " . $conn->error);
                }

                $stmt->bind_param('iii', $id_estagiario, $id_empresa, $id_vaga);

                if ($stmt->execute()) {
                    // Deletar a candidatura após a inserção do contrato
                    $query = "DELETE FROM candidatura WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    if (!$stmt) {
                        throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
                    }

                    $stmt->bind_param('i', $id_candidatura);
                    $stmt->execute();

                    echo "Contratação realizada com sucesso";
                } else {
                    echo "Erro ao realizar contratação: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    } catch (Exception $e) {
        echo "Erro ao processar a contratação: " . $e->getMessage();
    } finally {
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
