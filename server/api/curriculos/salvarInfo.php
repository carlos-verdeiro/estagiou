<?php
session_start();

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o estagiario está autenticado
    if (!isset($_SESSION['statusLogin']) || $_SESSION['statusLogin'] !== 'autenticado' || !isset($_SESSION['tipoUsuarioLogin']) || $_SESSION['tipoUsuarioLogin'] != 'estagiario' || !isset($_SESSION['idUsuarioLogin'])) {
        http_response_code(401); // Código de resposta para não autorizado
        $response['message'] = "Erro: Usuário não autenticado.";
        echo json_encode($response);
        exit;
    }

    // Obtém dados do formulário
    $estagiario_id = $_SESSION['idUsuarioLogin'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    $campo = isset($uri[5]) ? (string)$uri[5] : null; // Campo para ser alterado

    if (!$campo) {
        http_response_code(400); // Código de resposta para requisição ruim
        $response['message'] = "Falha: Sem parâmetro.";
        echo json_encode($response);
        exit;
    }

    switch ($campo) {
        case 'formacao':
            $escolaridade = isset($_POST['escolaridade']) ? (int)$_POST['escolaridade'] : null;
            $formacao = isset($_POST['formacao']) ? $_POST['formacao'] : null;

            if ($escolaridade === null || $escolaridade > 8 || $escolaridade < 1 || !is_numeric($escolaridade)) {
                http_response_code(400); // Código de resposta para requisição ruim
                $response['message'] = 'Valores incorretos para escolaridade.';
                echo json_encode($response);
                exit;
            }

            if ($formacao === null || strlen($formacao) > 1000) {
                http_response_code(400); // Código de resposta para requisição ruim
                $response['message'] = 'Formação excedeu 1000 caracteres.';
                echo json_encode($response);
                exit;
            }

            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Conecta ao banco de dados para inserção
                $stmt = $conn->prepare("UPDATE estagiario SET escolaridade=?, formacoes=? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('isi', $escolaridade, $formacao, $estagiario_id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Atualizado com sucesso!";
                } else {
                    $response['message'] = "Nenhuma alteração realizada.";
                }
                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao atualizar informações: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }

            break;

        case 'experiencias':
            $experiencias = isset($_POST['experiencias']) ? $_POST['experiencias'] : null;

            if ($experiencias === null || strlen($experiencias) > 1000) {
                http_response_code(400); // Código de resposta para requisição ruim
                $response['message'] = 'Campo excedeu 1000 caracteres.';
                echo json_encode($response);
                exit;
            }

            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Conecta ao banco de dados para inserção
                $stmt = $conn->prepare("UPDATE estagiario SET experiencias=? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('si', $experiencias, $estagiario_id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Atualizado com sucesso!";
                } else {
                    $response['message'] = "Nenhuma alteração realizada.";
                }
                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao atualizar informações: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }
            break;
        case 'idiomas':
            $proIngles = isset($_POST['idiomaIngles']) && $_POST['nivelIngles'] != 0 && is_numeric($_POST['nivelIngles']) ? $_POST['nivelIngles'] : 0;
            $proEspanhol = isset($_POST['idiomaEspanhol']) && $_POST['nivelEspanhol'] != 0 && is_numeric($_POST['nivelEspanhol']) ? $_POST['nivelEspanhol'] : 0;
            $proFrances = isset($_POST['idiomaFrances']) && $_POST['nivelFrances'] != 0 && is_numeric($_POST['nivelFrances']) ? $_POST['nivelFrances'] : 0;

            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Conecta ao banco de dados para inserção
                $stmt = $conn->prepare("UPDATE estagiario SET proIngles = ?, proEspanhol = ?, proFrances = ? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                // Supondo que $estagiario_id seja definido em algum lugar no código
                $stmt->bind_param('iiii', $proIngles, $proEspanhol, $proFrances, $estagiario_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Atualizado com sucesso!";
                } else {
                    $response['message'] = "Nenhuma alteração realizada.";
                }

                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao atualizar informações: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }
            break;

        case 'certificacoes':

            $certificacoes = isset($_POST['certificacoes']) ? $_POST['certificacoes'] : null;

            if ($certificacoes === null || strlen($certificacoes) > 1000) {
                http_response_code(400); // Código de resposta para requisição ruim
                $response['message'] = 'Campo excedeu 1000 caracteres.';
                echo json_encode($response);
                exit;
            }

            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Conecta ao banco de dados para inserção
                $stmt = $conn->prepare("UPDATE estagiario SET certificacoes=? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('si', $certificacoes, $estagiario_id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Atualizado com sucesso!";
                } else {
                    $response['message'] = "Nenhuma alteração realizada.";
                }
                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao atualizar informações: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }
            break;
        case 'habilidades':

            $habilidades = isset($_POST['habilidades']) ? $_POST['habilidades'] : null;

            if ($habilidades === null || strlen($habilidades) > 1000) {
                http_response_code(400); // Código de resposta para requisição ruim
                $response['message'] = 'Campo excedeu 1000 caracteres.';
                echo json_encode($response);
                exit;
            }

            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Conecta ao banco de dados para inserção
                $stmt = $conn->prepare("UPDATE estagiario SET habilidades=? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('si', $habilidades, $estagiario_id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Atualizado com sucesso!";
                } else {
                    $response['message'] = "Nenhuma alteração realizada.";
                }
                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao atualizar informações: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }
            break;
        case 'disponibilidade':
            $result = [];
            if (isset($_POST['integral'])) {
                $result[] = 'integral';
            }
            if (isset($_POST['meio'])) {
                $result[] = 'meio';
            }
            if (isset($_POST['remoto'])) {
                $result[] = 'remoto';
            }
            if (isset($_POST['presencial'])) {
                $result[] = 'presencial';
            }

            $disponibilidade = !empty($result) ? implode('/', $result) : '';


            try {
                // Inclui o arquivo de conexão
                include_once '../../conexao.php';

                // Conecta ao banco de dados para inserção
                $stmt = $conn->prepare("UPDATE estagiario SET disponibilidade=? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Erro na preparação da consulta: " . $conn->error);
                }

                $stmt->bind_param('si', $disponibilidade, $estagiario_id);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Atualizado com sucesso!";
                } else {
                    $response['message'] = "Nenhuma alteração realizada.";
                }
                $stmt->close();
            } catch (Exception $e) {
                http_response_code(500); // Código de resposta para erro interno do servidor
                $response['message'] = "Erro ao atualizar informações: " . $e->getMessage();
            } finally {
                // Fechar a conexão
                if (isset($conn)) $conn->close();
            }
            break;


        default:
            http_response_code(400); // Código de resposta para requisição ruim
            $response['message'] = "Falha: Parâmetro desconhecido.";
            break;
    }
} else {
    http_response_code(405); // Código de resposta para método não permitido
    $response['message'] = "Método de requisição inválido.";
}

echo json_encode($response);
exit;
