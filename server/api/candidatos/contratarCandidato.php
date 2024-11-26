<?php
session_start();
$hoje = date('Y-m-d');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] !== "empresa") {
        die("Erro: Usuário não autenticado.");
    }

    $id_empresa = $_SESSION['idUsuarioLogin'];

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    $busca = isset($uri[5]) ? $uri[5] : null;

    switch ($busca) {
        case 'contratar':
            $id_candidatura = $_POST['idCand'];

            $data_contrato = !empty($_POST['iniContra']) ? $_POST['iniContra'] : $hoje;
            $data_termino = !empty($_POST['fimContra']) ? $_POST['fimContra'] : null;
            $observacao = !empty($_POST['obsContra']) ? $_POST['obsContra'] : null;

            if (isset($_FILES['fileContra']) && $_FILES['fileContra']['error'] !== UPLOAD_ERR_NO_FILE) {
                $arquivo = $_FILES['fileContra'];

                if ($arquivo['error'] === UPLOAD_ERR_OK) {
                    $pasta = "../../contratos/";
                    $nome = $arquivo['name'];
                    $tamanho = $arquivo['size'];
                    $tipo = $arquivo['type'];
                    $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
                    $novoNome = uniqid() . '.' . $extensao;
                    $path = $pasta . $novoNome;

                    if ($tipo == 'application/pdf') {
                        if (!is_dir($pasta)) {
                            mkdir($pasta, 0777, true);
                        }
                    } else {
                        die("Somente arquivos PDF são permitidos.");
                    }
                } else {
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
                        echo "Já existe um contrato para este estagiário nesta vaga.";
                    } else {
                        $query = "INSERT INTO contratos (id_estagiario, id_empresa, id_vaga, data_contratacao, caminho_anexo, nome_anexo, observacoes, data_termino) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        if (!$stmt) {
                            throw new Exception("Erro na preparação da consulta de inserção: " . $conn->error);
                        }

                        $stmt->bind_param('iiisssss', $id_estagiario, $id_empresa, $id_vaga, $data_contrato, $novoNome, $nome, $observacao, $data_termino);

                        if ($stmt->execute()) {
                            if ($novoNome) {
                                if (!move_uploaded_file($arquivo['tmp_name'], $path)) {
                                    throw new Exception("Erro ao mover o arquivo.");
                                }
                            }

                            $query = "DELETE FROM candidatura WHERE id = ?";
                            $stmt = $conn->prepare($query);
                            if (!$stmt) {
                                throw new Exception("Erro na preparação da consulta de exclusão: " . $conn->error);
                            }

                            $stmt->bind_param('i', $id_candidatura);
                            $stmt->execute();

                            echo "Contratação realizada com sucesso.";
                            $conn->commit();
                        } else {
                            throw new Exception("Erro ao realizar contratação: " . $stmt->error);
                        }

                        $stmt->close();
                    }
                } else {
                    echo "Candidatura não encontrada ou você não tem permissão para contratar.";
                }
            } catch (Exception $e) {
                if (isset($conn)) {
                    $conn->rollback();
                }
                echo "Erro ao processar a contratação: " . $e->getMessage();
            } finally {
                if (isset($conn)) $conn->close();
            }
            break;

        case 'editar':
            $id_contrato = $_POST['idContrato'];
            $data_termino = !empty($_POST['modalFimContratoEditar']) ? $_POST['modalFimContratoEditar'] : null;
            $observacao = !empty($_POST['modalObservacoesEditar']) ? $_POST['modalObservacoesEditar'] : null;
            $rmAnexo = isset($_POST['rmAnexo']) && $_POST['rmAnexo'] ? true : false;
            try {
                include_once '../../conexao.php';

                $stmt = $conn->prepare("UPDATE contratos SET observacoes = ?, data_termino = ? WHERE id = ?");
                $stmt->bind_param('ssi', $observacao, $data_termino, $id_contrato);
                if (!$stmt->execute()) {
                    throw new Exception("Erro ao atualizar contrato: " . $stmt->error);
                }

                if ($rmAnexo || !empty($_FILES['anexoEditarContrato']['tmp_name'])) {
                    $novoNome = $nome = null;

                    if (!empty($_FILES['anexoEditarContrato']['tmp_name'])) {
                        $arquivo = $_FILES['anexoEditarContrato'];
                        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                        $rmAnexo = true;
                        if ($extensao !== 'pdf' || mime_content_type($arquivo['tmp_name']) !== 'application/pdf') {
                            throw new Exception("Somente arquivos PDF são permitidos.");
                        }

                        $novoNome = uniqid() . '.' . $extensao;
                        $path = "../../contratos/" . $novoNome;
                        $nome = $arquivo['name'];

                        if (!is_dir('../../contratos/')) {
                            mkdir('../../contratos/', 0755, true);
                        }

                        move_uploaded_file($arquivo['tmp_name'], $path);
                    }


                    $stmt = $conn->prepare("SELECT caminho_anexo FROM contratos WHERE id = ?");
                    $stmt->bind_param('i', $id_contrato);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $contrato = $result->fetch_assoc();

                    if ($contrato && isset($contrato['caminho_anexo'])) {
                        $caminho_arquivo_antigo = '../../contratos/' . $contrato['caminho_anexo'];
                        if (file_exists($caminho_arquivo_antigo)) {
                            if (!unlink($caminho_arquivo_antigo)) {
                                throw new Exception("Erro ao excluir o anexo antigo.");
                            }
                        }
                    }



                    $stmt = $conn->prepare("UPDATE contratos SET caminho_anexo = ?, nome_anexo = ? WHERE id = ?");
                    $stmt->bind_param('ssi', $novoNome, $nome, $id_contrato);
                    if (!$stmt->execute()) {
                        throw new Exception("Erro ao atualizar anexo: " . $stmt->error);
                    }
                }

                echo "Contrato editado com sucesso.";
            } catch (Exception $e) {
                error_log("Erro ao editar contrato: " . $e->getMessage());
                echo "Ocorreu um erro ao editar o contrato. Por favor, tente novamente mais tarde.";
            } finally {
                $conn->close();
            }

            break;

        default:
            echo "Requisição inválida.";
            break;
    }
} else {
    echo "Método de requisição inválido.";
}
exit;
