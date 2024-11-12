<?php
session_start();
header('Content-Type: application/json');

class variavelNaoExiste extends Exception {}


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

        case 'edicaoEscolar':

            try {
                function sanitizar($campo, $padrao = NULL, $regex = '/[^a-zA-ZÀ-ÖØ-öø-ÿ0-9\' -]/')
                {
                    return isset($_POST[$campo]) && $_POST[$campo] !== NULL ? preg_replace($regex, '', $_POST[$campo]) : $padrao;
                }

                function validar($valor, $tipo, $min, $max)
                {
                    $valor = trim($valor);
                    if (strlen($valor) < $min || strlen($valor) > $max) return false;

                    $validacoes = [
                        'texto' => "/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/",
                        'numero' => "/^[0-9]+$/",
                        'data' => "/^(\d{4})-(\d{2})-(\d{2})$/"
                    ];

                    if (!preg_match($validacoes[$tipo], $valor, $matches)) return false;

                    if ($tipo === 'data' && !checkdate($matches[2], $matches[3], $matches[1])) return false;

                    return true;
                }

                // Dados pessoais
                $nome = sanitizar('nome');
                $sobrenome = sanitizar('sobrenome');
                $genero = sanitizar('genero');
                $nomeSocial = sanitizar('nomeSocial');
                $estadoCivil = sanitizar('estadoCivil');
                $dataNascimento = sanitizar('dataNascimento');
                $nacionalidade = sanitizar('nacionalidade');
                $celular = sanitizar('celular', NULL, '/[^0-9]/');
                $telefone = sanitizar('telefone', NULL, '/[^0-9]/');
                if (isset($_POST['cnhSem'])) {
                    $cnh = 'N';
                } elseif (isset($_POST['cnh'])) {
                    $cnhzin = implode('', $_POST['cnh']);
                    $cnh = htmlspecialchars($cnhzin, ENT_QUOTES, 'UTF-8');
                } else {
                    $cnh = 'N';
                }
                $dependentes = sanitizar('dependentes', 0, '/[^0-9]/');

                // Endereço
                $endereco = sanitizar('endereco');
                $bairro = sanitizar('bairro');
                $numero = sanitizar('numero');
                $complemento = sanitizar('complemento');
                $cidade = sanitizar('cidade');
                $estado = sanitizar('estado');
                $cep = sanitizar('cep', NULL, '/[^0-9]/');
                $pais = sanitizar('pais');

                // Disponibilidade
                $opcoesDisponibilidade = ['integral', 'meio', 'remoto', 'presencial'];
                $disponibilidade = array_filter($opcoesDisponibilidade, fn($opt) => isset($_POST[$opt]));
                $disponibilidade = implode('/', $disponibilidade);

                // Outras Informações
                $escolaridade = sanitizar('escolaridade');
                $formacoes = sanitizar('formacoes');
                $experiencias = sanitizar('experiencias');
                $habilidades = sanitizar('habilidades');
                $certificacoes = sanitizar('certificacoes');
                $proIngles = isset($_POST['idiomaIngles']) ? (int)$_POST['nivelIngles'] : 0;
                $proEspanhol = isset($_POST['idiomaEspanhol']) ? (int)$_POST['nivelEspanhol'] : 0;
                $proFrances = isset($_POST['idiomaFrances']) ? (int)$_POST['nivelFrances'] : 0;

                // Validações
                $erros = 0;
                $camposParaValidar = [
                    'nome' => ['tipo' => 'texto', 'min' => 1, 'max' => 100],
                    'sobrenome' => ['tipo' => 'texto', 'min' => 0, 'max' => 100],
                    'genero' => ['tipo' => 'texto', 'min' => 1, 'max' => 50],
                    'dataNascimento' => ['tipo' => 'data', 'min' => 0, 'max' => 100],
                    'celular' => ['tipo' => 'numero', 'min' => 11, 'max' => 11],
                    'cep' => ['tipo' => 'numero', 'min' => 8, 'max' => 8]
                ];

                foreach ($camposParaValidar as $campo => $regra) {
                    if (!validar($$campo, $regra['tipo'], $regra['min'], $regra['max'])) {
                        throw new Exception("$campo inválido.");
                        $erros++;
                    }
                }

                if ($erros != 0) {
                    echo json_encode(['mensagem' => "Foram encontrados $erros erro(s) de validação.", 'code' => 1]);
                }
            } catch (Exception $e) {
                echo json_encode(['mensagem' => "Erro: " . $e->getMessage(), 'code' => 1]);
            }


            $id_estagiario = $_POST['id_estagiario'];

            $stmt = $conn->prepare("SELECT * FROM aluno WHERE id_escola = ? AND id_estagiario = ?");
            $stmt->bind_param('ii', $id, $id_estagiario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $stmt2 = $conn->prepare("UPDATE estagiario
                                SET
                                    nome = ?,
                                    sobrenome = ?,
                                    genero = ?,
                                    nome_social = ?,
                                    estado_civil = ?,
                                    data_nascimento = ?,
                                    nacionalidade = ?,
                                    celular = ?,
                                    telefone = ?,
                                    cnh = ?,
                                    dependentes = ?,
                                    endereco = ?,
                                    bairro = ?,
                                    numero = ?,
                                    complemento = ?,
                                    cidade = ?,
                                    estado = ?,
                                    cep = ?,
                                    pais = ?,
                                    formacoes = ?,
                                    experiencias = ?,
                                    habilidades = ?,
                                    proIngles = ?,
                                    proEspanhol = ?,
                                    proFrances = ?,
                                    certificacoes = ?,
                                    escolaridade = ?,
                                    disponibilidade = ?
                                WHERE id = ?;
                                ");


                $stmt2->bind_param(
                    'sssssssssssssssssssssssssssss',
                    $nome,
                    $sobrenome,
                    $genero,
                    $nomeSocial,
                    $estadoCivil,
                    $dataNascimento,
                    $nacionalidade,
                    $celular,
                    $telefone,
                    $cnh,
                    $dependentes,
                    $endereco,
                    $bairro,
                    $numero,
                    $complemento,
                    $cidade,
                    $estado,
                    $cep,
                    $pais,
                    $formacoes,
                    $experiencias,
                    $habilidades,
                    $proIngles,
                    $proEspanhol,
                    $proFrances,
                    $certificacoes,
                    $escolaridade,
                    $disponibilidade,
                    $id_estagiario
                );



                // Execute a consulta
                if ($stmt2->execute()) {
                    // Verifica se alguma linha foi afetada
                    if ($stmt2->affected_rows > 0) {
                        echo json_encode(['mensagem' => "Usuário editado com sucesso.", 'code' => 5]);
                    } else {
                        echo json_encode(['mensagem' => "Nenhuma alteração foi feita. Usuário não encontrado ou dados já estão atualizados.", 'code' => 1]);
                    }
                } else {
                    $error = $stmt2->error;

                    if (is_array($error)) {
                        echo json_encode(['mensagem' => "Erro ao editar usuário.", 'code' => 1]);
                    } else {
                        echo json_encode(['mensagem' => "Erro ao editar usuário: $error", 'code' => 1]);
                    }
                }
            } else {
                echo json_encode(['mensagem' => "Usuário não encontrado.", 'code' => 1]);
            }
            break;


        default:
            echo json_encode(['mensagem' => "Parâmetros incorretos.", 'code' => 1]);
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo 'Erro interno: ' . $e->getMessage();
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
