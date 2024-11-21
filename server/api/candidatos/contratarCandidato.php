<?php
session_start();
$hoje = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== "empresa") {
        die("Erro: Usuário não autenticado.");
    }

    $id_empresa = $_SESSION['idUsuarioLogin'];
    $id_candidatura = $_POST['idCand'];

    $data_contrato = !empty($_POST['iniContra']) ? $_POST['iniContra'] : $hoje;
    $data_termino = !empty($_POST['fimContra']) ? $_POST['fimContra'] : null;
    $observacao = !empty($_POST['obsContra']) ? $_POST['obsContra'] : null;

    if (isset($_FILES['fileContra'])) {
        $arquivo = $_FILES['fileContra'];

        // Verifique se o arquivo foi carregado corretamente
        if ($arquivo['error'] === UPLOAD_ERR_OK) {
            $pasta = "../../contratos/";
            $nome = $arquivo['name'];
            $tamanho = $arquivo['size'];
            $tipo = $arquivo['type'];
            $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
            $novoNome = uniqid() . '.' . $extensao;
            $path = $pasta . $novoNome;

            // Verifique o tipo de arquivo
            if ($tipo == 'application/pdf') {
                // Verifique se o diretório de uploads existe, senão crie
                if (!is_dir($pasta)) {
                    mkdir($pasta, 0777, true);
                }
            } else {
                die("Somente arquivos PDF são permitidos.");
            }
        } else {
            if (isset($conn)) {
                $conn->rollback();
            }
            die("Erro ao carregar o arquivo. Código de erro: " . $arquivo['error']);
        }
    } else {
        $path = null;
        $nome = null;
        $novoNome = null;
    }

    if (!is_numeric($id_candidatura) || $id_candidatura <= 0) {
        die("Erro: ID do candidato inválido.");
    }

    try {
        include_once '../../conexao.php';

        $conn->begin_transaction();

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
                if (isset($conn)) {
                    $conn->rollback();
                }
                echo "Já existe um contrato para este estagiário nesta vaga.";
            } else {
                // Inserir o novo contrato
                $query = "INSERT INTO contratos (id_estagiario, id_empresa, id_vaga, data_contratacao, caminho_anexo, nome_anexo, observacoes, data_termino) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta de inserção: " . $conn->error);
                }

                $stmt->bind_param('iiisssss', $id_estagiario, $id_empresa, $id_vaga, $data_contrato, $novoNome, $nome, $observacao, $data_termino);

                if ($stmt->execute()) {
                    // Deletar a candidatura após a inserção do contrato
                    $query = "DELETE FROM candidatura WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    if (!$stmt) {
                        throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
                    }

                    if (!move_uploaded_file($arquivo['tmp_name'], $path)) {
                        throw new Exception("Erro ao enviar o arquivo");
                    }

                    $stmt->bind_param('i', $id_candidatura);
                    $stmt->execute();

                    echo "Contratação realizada com sucesso";
                } else {
                    if (isset($conn)) {
                        $conn->rollback();
                    }
                    echo "Erro ao realizar contratação: " . $stmt->error;
                }
                $conn->commit();
                $stmt->close();
            }
        }
    } catch (Exception $e) {
        if (isset($conn)) {
            $conn->rollback();
        }
        echo "Erro ao processar a contratação: " . $e->getMessage();
    } finally {
        if (isset($conn)) $conn->close();
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
