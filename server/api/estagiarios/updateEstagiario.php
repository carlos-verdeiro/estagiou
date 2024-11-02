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

function atualizarDadosPessoais($conn, $id) {
    if (empty($_POST['nome']) || empty($_POST['data_nascimento']) || empty($_POST['estado_civil']) || empty($_POST['genero']) || empty($_POST['nacionalidade'])) {
        echo json_encode(['mensagem' => 'Dados obrigatórios ausentes.', 'code' => 4, 'post' => $_POST]);
        exit;
    }

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'] ?? null;
    $data_nascimento = $_POST['data_nascimento'];
    $estado_civil = $_POST['estado_civil'];
    $genero = $_POST['genero'];
    $nacionalidade = $_POST['nacionalidade'];

    $stmt = $conn->prepare("UPDATE estagiario SET nome = ?, sobrenome = ?, data_nascimento = ?, estado_civil = ?, genero = ?, nacionalidade = ? WHERE id = ?");
    $stmt->bind_param('ssssssi', $nome, $sobrenome, $data_nascimento, $estado_civil, $genero, $nacionalidade, $id);
    $stmt->execute();

    echo json_encode(['mensagem' => 'Dados pessoais atualizados com sucesso.']);
}

function atualizarContato($conn, $id) {
    $celular = $_POST['celular'] ?? '';
    $telefone = $_POST['telefone'] ?? null;
    $stmt = $conn->prepare("UPDATE estagiario SET celular = ?, telefone = ? WHERE id = ?");
    $stmt->bind_param('ssi', $celular, $telefone, $id);
    $stmt->execute();
    echo json_encode(['mensagem' => 'Dados de contato atualizados com sucesso.']);
}

function atualizarEndereco($conn, $id) {
    $endereco = $_POST['endereco'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $complemento = $_POST['complemento'] ?? null;
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $pais = $_POST['pais'] ?? '';

    $stmt = $conn->prepare("UPDATE estagiario SET endereco = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, estado = ?, cep = ?, pais = ? WHERE id = ?");
    $stmt->bind_param('ssssssssi', $endereco, $numero, $complemento, $bairro, $cidade, $estado, $cep, $pais, $id);
    $stmt->execute();
    echo json_encode(['mensagem' => 'Dados de endereço atualizados com sucesso.']);
}
