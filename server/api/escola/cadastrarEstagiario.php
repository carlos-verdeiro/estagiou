<?php
session_start();

class variavelNaoExiste extends Exception {}


try {

    if (!isset( //etapa 1
        $_POST['cpf'],
        $_POST['nome'],
        $_POST['email']
    )) {
        throw new variavelNaoExiste("Variável da etapa 1 não existe ou é nulo.");
    }
    if (!isset( //etapa 2
        $_POST['rg'],
        $_POST['orgaoEmissor'],
        $_POST['estadoEmissor'],
        $_POST['genero'],
        $_POST['estadoCivil']
    )) {
        throw new variavelNaoExiste("Variável da etapa 2 não existe ou é nulo.");
    }
    if (!isset( //etapa 3
        $_POST['dataNascimento'],
        $_POST['nacionalidade'],
        $_POST['celular'],
        $_POST['dependentes']
    )) {
        throw new variavelNaoExiste("Variável da etapa 3 não existe ou é nulo.");
    }
    if (!isset( //etapa 4
        $_POST['endereco'],
        $_POST['bairro'],
        $_POST['numero'],
        $_POST['cidade'],
        $_POST['estado'],
        $_POST['cep'],
        $_POST['pais']

    )) {
        throw new variavelNaoExiste("Variável da etapa 4 não existe ou é nulo.");
    }
    if (!isset( //etapa 5
        $_POST['senha']

    )) {
        throw new variavelNaoExiste("Variável da etapa 5 não existe ou é nulo.");
    }

    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        if ($key === 'dependentesEstagiario') {
            return isset($_POST[$key]) && $_POST[$key] != NULL ? $_POST[$key] : 0;
        }
        return isset($_POST[$key]) && $_POST[$key] != NULL ? $_POST[$key] : NULL;
    }



    define('CPF_KEY', 'cpf');
    define('SENHA_KEY', 'senha');
    define('NOME_KEY', 'nome');
    define('SOBRENOME_KEY', 'sobrenome');
    define('EMAIL_KEY', 'email');
    define('RG_KEY', 'rg');
    define('ORGAO_EMISSOR_KEY', 'orgaoEmissor');
    define('ESTADO_EMISSOR_KEY', 'estadoEmissor');
    define('GENERO_KEY', 'genero');
    define('NOME_SOCIAL_KEY', 'nomeSocial');
    define('ESTADO_CIVIL_KEY', 'estadoCivil');
    define('DATA_NASCIMENTO_KEY', 'dataNascimento');
    define('NACIONALIDADE_KEY', 'nacionalidade');
    define('CELULAR_KEY', 'celular');
    define('TELEFONE_KEY', 'telefone');
    define('CNH_KEY', 'cnh');
    define('DEPENDENTES_KEY', 'dependentes');
    define('ENDERECO_KEY', 'endereco');
    define('BAIRRO_KEY', 'bairro');
    define('NUMERO_KEY', 'numero');
    define('COMPLEMENTO_KEY', 'complemento');
    define('CIDADE_KEY', 'cidade');
    define('ESTADO_KEY', 'estado');
    define('CEP_KEY', 'cep');
    define('PAIS_KEY', 'pais');
    define('ESCOLARIDADE_KEY', 'escolaridade');
    define('FORMACOES_KEY', 'formacoes');
    define('EXPERIENCIAS_KEY', 'experiencias');
    define('HABILIDADES_KEY', 'habilidades');
    define('CERTIFICACOES_KEY', 'certificacoes');


    $cpf = preg_replace('/[^0-9]/', '', pegarSessao(CPF_KEY));
    $nome = pegarSessao(NOME_KEY);
    $sobrenome = pegarSessao(SOBRENOME_KEY);
    $email = pegarSessao(EMAIL_KEY);
    $rg = preg_replace('/[^0-9]/', '', pegarSessao(RG_KEY));
    $orgaoEmissor = pegarSessao(ORGAO_EMISSOR_KEY);
    $estadoEmissor = pegarSessao(ESTADO_EMISSOR_KEY);
    $genero = pegarSessao(GENERO_KEY);
    $nomeSocial = pegarSessao(NOME_SOCIAL_KEY);
    $estadoCivil = pegarSessao(ESTADO_CIVIL_KEY);
    $dataNascimento = pegarSessao(DATA_NASCIMENTO_KEY);
    $nacionalidade = pegarSessao(NACIONALIDADE_KEY);
    $celular = preg_replace('/[^0-9]/', '', pegarSessao(CELULAR_KEY));
    $telefone = preg_replace('/[^0-9]/', '', pegarSessao(TELEFONE_KEY));
    $cnh = pegarSessao(CNH_KEY);
    $dependentes = pegarSessao(DEPENDENTES_KEY);
    $endereco = pegarSessao(ENDERECO_KEY);
    $bairro = pegarSessao(BAIRRO_KEY);
    $numero = pegarSessao(NUMERO_KEY);
    $complemento = pegarSessao(COMPLEMENTO_KEY);
    $cidade = pegarSessao(CIDADE_KEY);
    $estado = pegarSessao(ESTADO_KEY);
    $cep = preg_replace('/[^0-9]/', '', pegarSessao(CEP_KEY));
    $pais = pegarSessao(PAIS_KEY);
    $senha = pegarSessao(SENHA_KEY);
    //disponibilidade
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
    //disponibilidade
    $escolaridade = pegarSessao(ESCOLARIDADE_KEY);
    $formacoes = pegarSessao(FORMACOES_KEY);
    $experiencias = pegarSessao(EXPERIENCIAS_KEY);
    $habilidades = pegarSessao(HABILIDADES_KEY);
    $certificacoes = pegarSessao(CERTIFICACOES_KEY);
    $proIngles = isset($_POST['idiomaIngles']) && $_POST['nivelIngles'] != 0 && is_numeric($_POST['nivelIngles']) ? $_POST['nivelIngles'] : 0;
    $proEspanhol = isset($_POST['idiomaEspanhol']) && $_POST['nivelEspanhol'] != 0 && is_numeric($_POST['nivelEspanhol']) ? $_POST['nivelEspanhol'] : 0;
    $proFrances = isset($_POST['idiomaFrances']) && $_POST['nivelFrances'] != 0 && is_numeric($_POST['nivelFrances']) ? $_POST['nivelFrances'] : 0;

    $erros = 0;



    function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    function validar($texto, $tipo, $min, $max)
    {
        $texto = trim($texto);

        switch ($tipo) {
            case 'nome':
            case 'bairro':
            case 'cidade':
            case 'pais':
            case 'nacionalidade':
            case 'orgaoEmissor':
            case 'genero':
            case 'estadoEmissor':
            case 'estado':
            case 'estadoCivil':
            case 'cnh':


                if (strlen($texto) < $min || strlen($texto) > $max) {
                    return false;
                }
                if (!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $texto)) {
                    return false;
                }
                break;

            case 'cpf':
            case 'rg':
            case 'dependentes':
            case 'celular':
            case 'cep':
            case 'numero':

                if (strlen($texto) < $min || strlen($texto) > $max) {
                    return false;
                }
                if (!preg_match("/^[0-9]+$/", $texto)) {
                    return false;
                }
                break;

            case 'dataNascimento':


                if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $texto, $matches)) {
                    // Checa se é uma data válida
                    $ano = intval($matches[1]);
                    $mes = intval($matches[2]);
                    $dia = intval($matches[3]);

                    if (checkdate($mes, $dia, $ano)) {
                        return true;
                    }
                }

                return false;
                break;

            case 'nomeSocial':
            case 'sobrenome':



                if ($texto != NULL || $texto != '') {
                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }
                    if (!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $texto)) {
                        return false;
                    }
                }

                break;
            case 'telefone':
            case 'escolaridade':

                if ($texto != NULL || $texto != '') {
                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }
                    if (!preg_match("/^[0-9]+$/", $texto)) {
                        return false;
                    }
                }

                break;

            case 'senha':
            case 'email':
            case 'complemento':
            case 'endereco':
            case 'formacoes':
            case 'experiencias':
            case 'habilidades':
            case 'proIngles':
            case 'proEspanhol':
            case 'proFrances':
            case 'certificacoes':




                if (strlen($texto) < $min || strlen($texto) > $max) {
                    return false;
                }


                break;

            default:
                return false;
        }

        return true;
    }

    if (!validar($cpf, 'cpf', 11, 11)) {
        throw new variavelNaoExiste("CPF ERRO\n");
        $erros++;
    }
    if (!validar($nome, 'nome', 1, 100)) {
        throw new variavelNaoExiste("Nome ERRO\n");
        $erros++;
    }
    if (!validar($sobrenome, 'sobrenome', 0, 100)) {
        throw new variavelNaoExiste("Sobrenome ERRO\n");
        $erros++;
    }
    if (!validar($email, 'email', 3, 100)) {
        throw new variavelNaoExiste("Email ERRO\n");
        $erros++;
    }
    if (!validar($rg, 'rg', 9, 9)) {
        throw new variavelNaoExiste("RG ERRO\n");
        $erros++;
    }
    if (!validar($orgaoEmissor, 'orgaoEmissor', 1, 50)) {
        throw new variavelNaoExiste("Órgão Emissor ERRO\n");
        $erros++;
    }
    if (!validar($estadoEmissor, 'estadoEmissor', 2, 2)) {
        throw new variavelNaoExiste("Estado Emissor ERRO\n");
        $erros++;
    }
    if (!validar($genero, 'genero', 1, 50)) {
        throw new variavelNaoExiste("Gênero ERRO\n");
        $erros++;
    }
    if (!validar($nomeSocial, 'nomeSocial', 0, 255)) {
        throw new variavelNaoExiste("Nome Social ERRO\n");
        $erros++;
    }
    if (!validar($estadoCivil, 'estadoCivil', 2, 255)) {
        throw new variavelNaoExiste("Estado Civil ERRO\n");
        $erros++;
    }
    if (!validar($dataNascimento, 'dataNascimento', 0, 100)) {
        throw new variavelNaoExiste("Data de Nascimento ERRO\n");
        $erros++;
    }
    if (!validar($nacionalidade, 'nacionalidade', 0, 100)) {
        throw new variavelNaoExiste("Nacionalidade ERRO\n");
        $erros++;
    }
    if (!validar($celular, 'celular', 11, 11)) {
        throw new variavelNaoExiste("Celular ERRO\n");
        $erros++;
    }
    if (!validar($telefone, 'telefone', 0, 10)) {
        throw new variavelNaoExiste("Telefone ERRO\n");
        $erros++;
    }
    if (isset($_POST['cnhSem'])) {
        $cnh = 'N';
    } elseif (isset($_POST['cnh'])) {
        $cnhzin = implode('', $_POST['cnh']);
        $cnh = htmlspecialchars($cnhzin, ENT_QUOTES, 'UTF-8');
    } else {
        $cnh = 'N';
    }
    if (!validar($cnh, 'cnh', 1, 50)) {
        throw new variavelNaoExiste("CNH ERRO\n");
        $erros++;
    }
    if (!validar($dependentes, 'dependentes', 0, 11)) {
        throw new variavelNaoExiste("Dependentes ERRO\n");
        $erros++;
    }
    if (!validar($endereco, 'endereco', 0, 255)) {
        throw new variavelNaoExiste("Endereço ERRO\n");
        $erros++;
    }
    if (!validar($bairro, 'bairro', 0, 100)) {
        throw new variavelNaoExiste("Bairro ERRO\n");
        $erros++;
    }
    if (!validar($numero, 'numero', 0, 50)) {
        throw new variavelNaoExiste("Número ERRO\n");
        $erros++;
    }
    if (!validar($complemento, 'complemento', 0, 255)) {
        throw new variavelNaoExiste("Complemento ERRO\n");
        $erros++;
    }
    if (!validar($cidade, 'cidade', 0, 100)) {
        throw new variavelNaoExiste("Cidade ERRO\n");
        $erros++;
    }
    if (!validar($estado, 'estado', 0, 100)) {
        throw new variavelNaoExiste("Estado ERRO\n");
        $erros++;
    }
    if (!validar($cep, 'cep', 8, 8)) {
        throw new variavelNaoExiste("CEP ERRO\n");
        $erros++;
    }
    if (!validar($pais, 'pais', 2, 100)) {
        throw new variavelNaoExiste("País ERRO\n");
        $erros++;
    }
    if (!validar($senha, 'senha', 0, 100)) {
        throw new variavelNaoExiste("Senha ERRO\n");
        $erros++;
    }
    if (!validar($formacoes, 'formacoes', 0, 1000)) {
        throw new variavelNaoExiste("Formações ERRO\n");
        $erros++;
    }
    if (!validar($experiencias, 'experiencias', 0, 1000)) {
        throw new variavelNaoExiste("Experiencias ERRO\n");
        $erros++;
    }
    if (!validar($habilidades, 'habilidades', 0, 1000)) {
        throw new variavelNaoExiste("Habilidades ERRO\n");
        $erros++;
    }
    if (!validar($proIngles, 'proIngles', 0, 1)) {
        throw new variavelNaoExiste("Inglês ERRO\n");
        $erros++;
    }
    if (!validar($proEspanhol, 'proEspanhol', 0, 1)) {
        throw new variavelNaoExiste("Espanhol ERRO\n");
        $erros++;
    }
    if (!validar($proFrances, 'proFrances', 0, 1)) {
        throw new variavelNaoExiste("Francês ERRO\n");
        $erros++;
    }
    if (!validar($certificacoes, 'certificacoes', 0, 1000)) {
        throw new variavelNaoExiste("Francês ERRO\n");
        $erros++;
    }
    if (!validar($escolaridade, 'escolaridade', 0, 11)) {
        throw new variavelNaoExiste("Francês ERRO\n");
        $erros++;
    }


    if ($erros > 0) {
        http_response_code(500);
        echo "Ocorreu um erro";
        exit;
    }
} catch (variavelNaoExiste $e) {
    http_response_code(500);
    echo 'Erro capturado: ',  $e->getMessage(), "\n";
} catch (Exception $e) {
    http_response_code(500);
    echo 'Erro capturado: ',  $e->getMessage(), "\n";
}

require_once '../../../server/conexao.php';
$conn->begin_transaction();

try {

    //BANCO DE DADOS


    $dados = [
        'cpf' => $cpf,
        'nome' => $nome,
        'sobrenome' => $sobrenome,
        'email' => $email,
        'rg' => $rg,
        'rg_org_emissor' => $orgaoEmissor,
        'rg_estado_emissor' => $estadoEmissor,
        'genero' => $genero,
        'nome_social' => $nomeSocial,
        'estado_civil' => $estadoCivil,
        'data_nascimento' => $dataNascimento,
        'nacionalidade' => $nacionalidade,
        'celular' => $celular,
        'telefone' => $telefone,
        'cnh' => $cnh,
        'dependentes' => preg_replace('/[^0-9]/', '', $dependentes),
        'endereco' => $endereco,
        'bairro' => $bairro,
        'numero' => $numero,
        'complemento' => $complemento,
        'cidade' => $cidade,
        'estado' => $estado,
        'cep' => $cep,
        'pais' => $pais,
        'senha' => password_hash($senha, PASSWORD_DEFAULT), // Hash da senha
        'formacoes' => $formacoes,
        'experiencias' => $experiencias,
        'habilidades' => $habilidades,
        'proIngles' => $proIngles,
        'proEspanhol' => $proEspanhol,
        'proFrances' => $proFrances,
        'certificacoes' => $certificacoes,
        'escolaridade' => $escolaridade,
        'disponibilidade' => $disponibilidade
    ];
    $sql = "INSERT INTO estagiario (
    cpf, nome, sobrenome, email, rg, rg_org_emissor, rg_estado_emissor, genero, nome_social, estado_civil, data_nascimento,
    nacionalidade, celular, telefone, cnh, dependentes, endereco, bairro, numero, complemento, cidade, estado,
    cep, pais, senha, formacoes, experiencias, habilidades, proIngles, proEspanhol, proFrances, certificacoes, escolaridade, disponibilidade
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";

    // Preparando a consulta
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        http_response_code(500);
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $param_types = str_repeat('s', count($dados));
    $param_values = array_values($dados);

    $stmt->bind_param($param_types, ...$param_values);

    if ($stmt->execute()) {
        $estagiario_id = $conn->insert_id;

        $sql2 = "INSERT INTO aluno (id_estagiario, id_escola) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);

        if ($stmt2 === false) {
            http_response_code(500);
            die("Erro ao preparar a segunda consulta: " . $conn->error);
        }

        $id_escola = $_SESSION['idUsuarioLogin'];

        $param_types2 = 'is';
        $param_values2 = [$estagiario_id, $id_escola];

        $stmt2->bind_param($param_types2, ...$param_values2);

        if ($stmt2->execute()) {

            $conn->commit();
            echo "Usuário inseridos com sucesso!";
        } else {
            $conn->rollback();
            http_response_code(500);
            echo "Erro ao inserir dados na segunda tabela: " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        $conn->rollback();
        http_response_code(500);
        echo "Erro ao inserir estagiário: " . $stmt->error;
    }
} catch (variavelNaoExiste $e) {
    $conn->rollback();
    http_response_code(500);
    echo 'Erro capturado: ',  $e->getMessage(), "\n";
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo 'Erro capturado: ',  $e->getMessage(), "\n";
}

exit;
