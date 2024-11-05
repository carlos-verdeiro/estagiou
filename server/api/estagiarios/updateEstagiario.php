<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['mensagem' => 'Método de requisição inválido.', 'code' => 1]);
    exit;
}

if (!isset($_POST['formulario_id'])) {
    echo json_encode(['mensagem' => 'Tipo de formulário não especificado.', 'code' => 1]);
    exit;
}

if (!isset($_SESSION['idUsuarioLogin'])) {
    http_response_code(401);
    echo json_encode(['mensagem' => 'Usuário não autenticado.', 'code' => 2]);
    exit;
}

include_once '../../conexao.php';

$tipo = $_POST['formulario_id'];
$id = $_SESSION['idUsuarioLogin'];

try {
    switch ($tipo) {
        case '#formDadosPessoais':
            atualizarDadosPessoais($conn, $id);
            break;

        case '#formContato':
            atualizarContato($conn, $id);
            break;

        case '#formEndereco':
            atualizarEndereco($conn, $id);
            break;

        case '#formTrocaSenha':
            trocarSenha($conn, $id);
            break;

        default:
            echo json_encode(['mensagem' => 'Parâmetros incorretos.', 'code' => 1]);
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['mensagem' => 'Erro interno: ' . $e->getMessage(), 'code' => 3]);
} finally {
    if (isset($conn)) $conn->close();
}

function atualizarDadosPessoais($conn, $id)
{
    if (empty($_POST['nome']) || empty($_POST['estado_civil']) || empty($_POST['genero']) || empty($_POST['nacionalidade'])) {
        echo json_encode(['mensagem' => 'Dados obrigatórios ausentes.', 'code' => 4, 'post' => $_POST]);
        exit;
    }

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'] ?? null;
    $estado_civil = $_POST['estado_civil'];
    $genero = $_POST['genero'];
    $nacionalidade = $_POST['nacionalidade'];

    $stmt = $conn->prepare("UPDATE estagiario SET nome = ?, sobrenome = ?, estado_civil = ?, genero = ?, nacionalidade = ? WHERE id = ?");
    $stmt->bind_param('sssssi', $nome, $sobrenome, $estado_civil, $genero, $nacionalidade, $id);
    $stmt->execute();

    echo json_encode(['mensagem' => 'Dados pessoais atualizados com sucesso.']);
}

function atualizarContato($conn, $id)
{
    if (empty($_POST['celular'])) {
        echo json_encode(['mensagem' => 'Dados obrigatórios ausentes.', 'code' => 4, 'post' => $_POST]);
        exit;
    }
    // Limpar caracteres especiais
    $celular = limparNumero($_POST['celular']);
    $telefone = limparNumero($_POST['telefone'] ?? null);

    $stmt = $conn->prepare("UPDATE estagiario SET celular = ?, telefone = ? WHERE id = ?");
    $stmt->bind_param('ssi', $celular, $telefone, $id);
    $stmt->execute();
    echo json_encode(['mensagem' => 'Dados de contato atualizados com sucesso.']);
}

function atualizarEndereco($conn, $id)
{
    if (empty($_POST['endereco']) || empty($_POST['numero']) || empty($_POST['bairro']) || empty($_POST['cidade']) || empty($_POST['estado']) || empty($_POST['cep']) || empty($_POST['pais'])) {
        echo json_encode(['mensagem' => 'Dados obrigatórios ausentes.', 'code' => 4, 'post' => $_POST]);
        exit;
    }

    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? null;
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $pais = $_POST['pais'];

    $stmt = $conn->prepare("UPDATE estagiario SET endereco = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, cep = ?, pais = ? WHERE id = ?");
    $stmt->bind_param('ssssssssi', $endereco, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pais, $id);
    $stmt->execute();
    echo json_encode(['mensagem' => 'Dados de endereço atualizados com sucesso.']);
}

function trocarSenha($conn, $id)
{
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];

    // Prepara a consulta para obter a senha atual
    $stmt = $conn->prepare("SELECT senha FROM estagiario WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se a consulta retornou um resultado
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $senha_armazenada = $row['senha'];

        // Verifica se a senha atual está correta
        if (password_verify($senha_atual, $senha_armazenada)) {
            $senhaCrip = password_hash($nova_senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE estagiario SET senha = ? WHERE id = ?");
            $stmt->bind_param('si', $senhaCrip, $id);

            // Tenta executar a atualização da senha
            if ($stmt->execute()) {
                echo json_encode(['mensagem' => 'Senha atualizada com sucesso.']);
            } else {
                echo json_encode(['mensagem' => 'Falha ao atualizar a senha.']);
            }
        } else {
            echo json_encode(['mensagem' => 'Senha atual incorreta.']);
        }
    } else {
        echo json_encode(['mensagem' => 'Usuário não encontrado.']);
    }
}


// Função para limpar caracteres especiais de números
function limparNumero($numero)
{
    return preg_replace('/[^0-9]/', '', $numero); // Remove tudo que não for número
}
exit;
