<script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring.js"></script>
<link rel="stylesheet" href="../../../assets/css/cadastro/action.css">
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando...</title>
</head>

<body>
    <div>
        <h3>Carregando...</h3>
        <l-ring size="200" stroke="10" bg-opacity="0" speed="2" color="#4c4eba"></l-ring>
        <a href="../cadastro.php">Cancelar</a>
    </div>
</body>

</html>

<?php
session_start();

if (
    isset($_SESSION['statusCadastroEmpresa']) && $_SESSION['statusCadastroEmpresa'] == "confirmado" &&
    isset($_SESSION['etapaCadastroEmpresa']) && $_SESSION['etapaCadastroEmpresa'] == 6
) {

    class variavelNaoExiste extends Exception
    {
    }
    class validacaoVariaveis extends Exception
    {
    }


    try {

        if (!isset( //etapa 1
            $_SESSION['cpfEstagiario'],
            $_SESSION['nomeEstagiario'],
            $_SESSION['emailEstagiario']
        )) {
            throw new variavelNaoExiste("Variável da etapa 1 não existe ou é nulo.");
        }
        if (!isset( //etapa 2
            $_SESSION['rgEstagiario'],
            $_SESSION['orgaoEmissorEstagiario'],
            $_SESSION['estadoEmissorEstagiario'],
            $_SESSION['generoEstagiario'],
            $_SESSION['estadoCivilEstagiario']
        )) {
            throw new variavelNaoExiste("Variável da etapa 2 não existe ou é nulo.");
        }
        if (!isset( //etapa 3
            $_SESSION['dataNascimentoEstagiario'],
            $_SESSION['nacionalidadeEstagiario'],
            $_SESSION['celularEstagiario'],
            $_SESSION['dependentesEstagiario']
        )) {
            throw new variavelNaoExiste("Variável da etapa 3 não existe ou é nulo.");
        }
        if (!isset( //etapa 4
            $_SESSION['enderecoEstagiario'],
            $_SESSION['bairroEstagiario'],
            $_SESSION['numeroEstagiario'],
            $_SESSION['cidadeEstagiario'],
            $_SESSION['estadoEstagiario'],
            $_SESSION['cepEstagiario'],
            $_SESSION['paisEstagiario']

        )) {
            throw new variavelNaoExiste("Variável da etapa 4 não existe ou é nulo.");
        }
        if (!isset( //etapa 5
            $_SESSION['senhaEstagiario']

        )) {
            throw new variavelNaoExiste("Variável da etapa 5 não existe ou é nulo.");
        }

        // Função para obter valor da sessão
        function pegarSessao($key)
        {
            if ($key === 'dependentesEstagiario') {
                return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : 0;
            }
            return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
        }



        define('CPF_KEY', 'cpfEstagiario');
        define('NOME_KEY', 'nomeEstagiario');
        define('SOBRENOME_KEY', 'sobrenomeEstagiario');
        define('EMAIL_KEY', 'emailEstagiario');
        define('RG_KEY', 'rgEstagiario');
        define('ORGAO_EMISSOR_KEY', 'orgaoEmissorEstagiario');
        define('ESTADO_EMISSOR_KEY', 'estadoEmissorEstagiario');
        define('GENERO_KEY', 'generoEstagiario');
        define('NOME_SOCIAL_KEY', 'nomeSocialEstagiario');
        define('ESTADO_CIVIL_KEY', 'estadoCivilEstagiario');
        define('DATA_NASCIMENTO_KEY', 'dataNascimentoEstagiario');
        define('NACIONALIDADE_KEY', 'nacionalidadeEstagiario');
        define('CELULAR_KEY', 'celularEstagiario');
        define('TELEFONE_KEY', 'telefoneEstagiario');
        define('CNH_KEY', 'cnhEstagiario');
        define('DEPENDENTES_KEY', 'dependentesEstagiario');
        define('ENDERECO_KEY', 'enderecoEstagiario');
        define('BAIRRO_KEY', 'bairroEstagiario');
        define('NUMERO_KEY', 'numeroEstagiario');
        define('COMPLEMENTO_KEY', 'complementoEstagiario');
        define('CIDADE_KEY', 'cidadeEstagiario');
        define('ESTADO_KEY', 'estadoEstagiario');
        define('CEP_KEY', 'cepEstagiario');
        define('PAIS_KEY', 'paisEstagiario');
        define('SENHA_KEY', 'senhaEstagiario');

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



                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }


                    break;

                case 'endereco':

                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }
                    if (!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -.,:]+$/", $texto)) {
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

        if ($erros > 0) {
            $_SESSION['statusCadastroEmpresa'] = "andamento";
            $_SESSION['etapaCadastroEmpresa'] = 6;
            header("Location: etapa6.php?erro");
            exit;
        }

        //BANCO DE DADOS

        require_once '../../../server/conexao.php';

        class Usuario
        {
            private $conn;
            private $table;

            public function __construct($db, $table)
            {
                $this->conn = $db;
                $this->table = $table;
            }

            public function inserirUsuario($dados)
            {
                $sql = "INSERT INTO " . $this->table . " (
                    cpf, nome, sobrenome, email, rg, rg_org_emissor, rg_estado_emissor, genero, nome_social, estado_civil, data_nascimento,
                    nacionalidade, celular, telefone, cnh, dependentes, endereco, bairro, numero, complemento, cidade, estado,
                    cep, pais, senha, status
                ) VALUES (
                    :cpf, :nome, :sobrenome, :email, :rg, :orgaoEmissor, :estadoEmissor, :genero, :nomeSocial, :estadoCivil, :dataNascimento,
                    :nacionalidade, :celular, :telefone, :cnh, :dependentes, :endereco, :bairro, :numero, :complemento, :cidade, :estado,
                    :cep, :pais, :senha, :status
                )";

                $stmt = $this->conn->prepare($sql);

                // Bind dos parâmetros
                foreach ($dados as $chave => $valor) {
                    $stmt->bindValue(':' . $chave, htmlspecialchars(strip_tags($valor)));
                }

                if ($stmt->execute()) {
                    return true;
                }
                return false;
            }
        }

        // Dados de conexão ao banco de dados
        $db_name = 'estagiou';
        $username = 'estagiarioInsert';
        $password = '123';
        $table = 'estagiario';

        $database = new Database($db_name, $username, $password);
        $db = $database->connect();

        $usuario = new Usuario($db, $table);

        // Dados do usuário tratados previamente
        $dependentes = preg_replace('/[^0-9]/', '', $dependentes);


        $dados = [
            'cpf' => $cpf,
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'email' => $email,
            'rg' => $rg,
            'orgaoEmissor' => $orgaoEmissor,
            'estadoEmissor' => $estadoEmissor,
            'genero' => $genero,
            'nomeSocial' => $nomeSocial,
            'estadoCivil' => $estadoCivil,
            'dataNascimento' => $dataNascimento,
            'nacionalidade' => $nacionalidade,
            'celular' => $celular,
            'telefone' => $telefone,
            'cnh' => $cnh,
            'dependentes' => $dependentes,
            'endereco' => $endereco,
            'bairro' => $bairro,
            'numero' => $numero,
            'complemento' => $complemento,
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $cep,
            'pais' => $pais,
            'senha' => password_hash($senha, PASSWORD_DEFAULT), // Hash da senha
            'status' => 1

        ];

        if ($usuario->inserirUsuario($dados)) {
            session_unset();
            session_destroy();
            header("location: ../sucesso.php");
        } else {
            echo "Erro ao inserir usuário.";
        }
    } catch (variavelNaoExiste $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    } catch (validacaoVariaveis $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    } catch (Exception $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    }
} else {
    header("location: action.php");
}
?>