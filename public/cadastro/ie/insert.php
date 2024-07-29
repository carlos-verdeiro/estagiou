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
    isset($_SESSION['statusCadastroEscola']) && $_SESSION['statusCadastroEscola'] == "confirmado" &&
    isset($_SESSION['etapaCadastroEscola']) && $_SESSION['etapaCadastroEscola'] == 6
) {

    class variavelNaoExiste extends Exception
    {
    }
    class validacaoVariaveis extends Exception
    {
    }


    try {

        if (!isset( //etapa 1
            $_SESSION['cnpjEscola'],
            $_SESSION['nomeEscola'],
            $_SESSION['telefoneEscola'],
            $_SESSION['emailEscola']
        )) {
            throw new variavelNaoExiste("Variável da etapa 1 não existe ou é nulo.");
        }
        if (!isset( //etapa 2
            $_SESSION['nomeResponsavelEscola'],
            $_SESSION['cargoResponsavelEscola'],
            $_SESSION['telefoneResponsavelEscola'],
            $_SESSION['emailResponsavelEscola']
        )) {
            throw new variavelNaoExiste("Variável da etapa 2 não existe ou é nulo.");
        }
        if (!isset( //etapa 3
            $_SESSION['enderecoEscola'],
            $_SESSION['bairroEscola'],
            $_SESSION['numeroEscola'],
            $_SESSION['cidadeEscola'],
            $_SESSION['estadoEscola'],
            $_SESSION['cepEscola'],
            $_SESSION['paisEscola']
        )) {
            throw new variavelNaoExiste("Variável da etapa 3 não existe ou é nulo.");
        }
        if (!isset( //etapa 4

            $_SESSION['niveisEnsinoEscola'],
            $_SESSION['descricaoEscola']

        )) {
            throw new variavelNaoExiste("Variável da etapa 4 não existe ou é nulo.");
        }
        if (!isset( //etapa 5
            $_SESSION['senhaEscola']

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



        // Definindo constantes para as chaves da sessão
        define('CNPJ_KEY', 'cnpjEscola');
        define('NOME_ESCOLA_KEY', 'nomeEscola');
        define('TELEFONE_KEY', 'telefoneEscola');
        define('EMAIL_KEY', 'emailEscola');
        define('NOME_RESPONSAVEL_KEY', 'nomeResponsavelEscola');
        define('CARGO_RESPONSAVEL_KEY', 'cargoResponsavelEscola');
        define('TELEFONE_RESPONSAVEL_KEY', 'telefoneResponsavelEscola');
        define('EMAIL_RESPONSAVEL_KEY', 'emailResponsavelEscola');
        define('ENDERECO_KEY', 'enderecoEscola');
        define('BAIRRO_KEY', 'bairroEscola');
        define('NUMERO_KEY', 'numeroEscola');
        define('COMPLEMENTO_KEY', 'complementoEscola');
        define('CIDADE_KEY', 'cidadeEscola');
        define('ESTADO_KEY', 'estadoEscola');
        define('CEP_KEY', 'cepEscola');
        define('PAIS_KEY', 'paisEscola');
        define('NIVEIS_ENSINO_KEY', 'niveisEnsinoEscola');
        define('DESCRICAO_KEY', 'descricaoEscola');
        define('WEBSITE_KEY', 'websiteEscola');
        define('LINKEDIN_KEY', 'linkedinEscola');
        define('INSTAGRAM_KEY', 'instagramEscola');
        define('FACEBOOK_KEY', 'facebookEscola');
        define('SENHA_KEY', 'senhaEscola');

        $cnpj = preg_replace('/[^0-9]/', '', pegarSessao(CNPJ_KEY));
        $nome = pegarSessao(NOME_ESCOLA_KEY);
        $telefone = preg_replace('/[^0-9]/', '', pegarSessao(TELEFONE_KEY));
        $email = pegarSessao(EMAIL_KEY);
        $nomeResponsavel = pegarSessao(NOME_RESPONSAVEL_KEY);
        $cargoResponsavel = pegarSessao(CARGO_RESPONSAVEL_KEY);
        $telefoneResponsavel = preg_replace('/[^0-9]/', '', pegarSessao(TELEFONE_RESPONSAVEL_KEY));
        $emailResponsavel = pegarSessao(EMAIL_RESPONSAVEL_KEY);
        $endereco = pegarSessao(ENDERECO_KEY);
        $bairro = pegarSessao(BAIRRO_KEY);
        $numero = pegarSessao(NUMERO_KEY);
        $complemento = pegarSessao(COMPLEMENTO_KEY);
        $cidade = pegarSessao(CIDADE_KEY);
        $estado = pegarSessao(ESTADO_KEY);
        $cep = preg_replace('/[^0-9]/', '', pegarSessao(CEP_KEY));
        $pais = pegarSessao(PAIS_KEY);
        $niveisEnsino = pegarSessao(NIVEIS_ENSINO_KEY);
        $descricao = pegarSessao(DESCRICAO_KEY);
        $website = pegarSessao(WEBSITE_KEY);
        $linkedin = pegarSessao(LINKEDIN_KEY);
        $instagram = pegarSessao(INSTAGRAM_KEY);
        $facebook = pegarSessao(FACEBOOK_KEY);
        $senha = pegarSessao(SENHA_KEY);

        $erros = 0;

        function validar($texto, $tipo, $min, $max)
        {
            $texto = trim($texto);

            switch ($tipo) {
                case 'textObrigatorio':


                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }
                    if (!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' -]+$/", $texto)) {
                        return false;
                    }
                    break;

                case 'numberObrigatorio':

                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }
                    if (!preg_match("/^[0-9]+$/", $texto)) {
                        return false;
                    }
                    break;

                case 'comprimento':



                    if (strlen($texto) < $min || strlen($texto) > $max) {
                        return false;
                    }


                    break;

                default:
                    return false;
            }

            return true;
        }


        if (!validar($cnpj, 'numberObrigatorio', 14, 14)) {
            throw new variavelNaoExiste("CNPJ ERRO\n");
            $erros++;
        }
        if (!validar($nome, 'textObrigatorio', 1, 255)) {
            throw new variavelNaoExiste("nome ERRO\n");
            $erros++;
        }
        if (!validar($telefone, 'numberObrigatorio', 0, 20)) {
            throw new variavelNaoExiste("telefone ERRO\n");
            $erros++;
        }
        if (!validar($email, 'comprimento', 3, 255)) {
            throw new variavelNaoExiste("email ERRO\n");
            $erros++;
        }
        if (!validar($senha, 'comprimento', 8, 255)) {
            throw new variavelNaoExiste("senha ERRO\n");
            $erros++;
        }
        if (!validar($endereco, 'comprimento', 1, 255)) {
            throw new variavelNaoExiste("Endereço ERRO\n");
            $erros++;
        }
        if (!validar($bairro, 'textObrigatorio', 1, 100)) {
            throw new variavelNaoExiste("Bairro ERRO\n");
            $erros++;
        }
        if (!validar($numero, 'numberObrigatorio', 1, 50)) {
            throw new variavelNaoExiste("Número ERRO\n");
            $erros++;
        }
        if (!validar($complemento, 'comprimento', 0, 255)) {
            throw new variavelNaoExiste("Complemento ERRO\n");
            $erros++;
        }
        if (!validar($cidade, 'textObrigatorio', 1, 100)) {
            throw new variavelNaoExiste("Cidade ERRO\n");
            $erros++;
        }
        if (!validar($estado, 'textObrigatorio', 1, 5)) {
            throw new variavelNaoExiste("Estado ERRO\n");
            $erros++;
        }
        if (!validar($cep, 'numberObrigatorio', 8, 10)) {
            throw new variavelNaoExiste("CEP ERRO\n");
            $erros++;
        }
        if (!validar($pais, 'textObrigatorio', 2, 100)) {
            throw new variavelNaoExiste("País ERRO\n");
            $erros++;
        }
        if (!validar($nomeResponsavel, 'textObrigatorio', 1, 255)) {
            throw new variavelNaoExiste("nomeResponsavel ERRO\n");
            $erros++;
        }
        if (!validar($cargoResponsavel, 'textObrigatorio', 1, 100)) {
            throw new variavelNaoExiste("cargoResponsavel ERRO\n");
            $erros++;
        }
        if (!validar($telefoneResponsavel, 'numberObrigatorio', 1, 25)) {
            throw new variavelNaoExiste("telefoneResponsavel ERRO\n");
            $erros++;
        }
        if (!validar($emailResponsavel, 'comprimento', 1, 255)) {
            throw new variavelNaoExiste("emailResponsavel ERRO\n");
            $erros++;
        }
        if (!validar($niveisEnsino, 'comprimento', 1, 100)) {
            throw new variavelNaoExiste("niveisEnsino ERRO\n");
            $erros++;
        }
        if (!validar($descricao, 'comprimento', 1, 500)) {
            throw new variavelNaoExiste("descricao ERRO\n");
            $erros++;
        }
        if (!validar($website, 'comprimento', 0, 100)) {
            throw new variavelNaoExiste("website ERRO\n");
            $erros++;
        }
        if (!validar($linkedin, 'comprimento', 0, 100)) {
            throw new variavelNaoExiste("linkedin ERRO\n");
            $erros++;
        }
        if (!validar($instagram, 'comprimento', 0, 100)) {
            throw new variavelNaoExiste("instagram ERRO\n");
            $erros++;
        }
        if (!validar($facebook, 'comprimento', 0, 100)) {
            throw new variavelNaoExiste("facebook ERRO\n");
            $erros++;
        }

        //BANCO DE DADOS

        require_once '../../../server/conexao.php';

        class Escola
        {
            private $conn;
            private $table;

            public function __construct($db, $table)
            {
                $this->conn = $db;
                $this->table = $table;
            }

            public function inserirEscola($dados)
            {
                $sql = "INSERT INTO " . $this->table . " (
            cnpj, nome, telefone, email, nome_responsavel, cargo_responsavel, telefone_responsavel, email_responsavel,
            endereco, bairro, numero, complemento, cidade, estado, cep, pais, niveis_ensino, descricao, website, linkedin,
            instagram, facebook, senha, status
        ) VALUES (
            :cnpj, :nome, :telefone, :email, :nomeResponsavel, :cargoResponsavel, :telefoneResponsavel, :emailResponsavel,
            :endereco, :bairro, :numero, :complemento, :cidade, :estado, :cep, :pais, :niveisEnsino, :descricao, :website, :linkedin,
            :instagram, :facebook, :senha, :status
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
        $username = 'escolaInsert';
        $password = '123';
        $table = 'escola';

        $database = new Database($db_name, $username, $password);
        $db = $database->connect();

        $escola = new Escola($db, $table);

        $dados = [
            'cnpj' => $cnpj,
            'nome' => $nome,
            'telefone' => $telefone,
            'email' => $email,
            'nomeResponsavel' => $nomeResponsavel,
            'cargoResponsavel' => $cargoResponsavel,
            'telefoneResponsavel' => $telefoneResponsavel,
            'emailResponsavel' => $emailResponsavel,
            'endereco' => $endereco,
            'bairro' => $bairro,
            'numero' => $numero,
            'complemento' => $complemento,
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $cep,
            'pais' => $pais,
            'niveisEnsino' => $niveisEnsino,
            'descricao' => $descricao,
            'website' => $website,
            'linkedin' => $linkedin,
            'instagram' => $instagram,
            'facebook' => $facebook,
            'senha' => password_hash($senha, PASSWORD_DEFAULT), // Hash da senha
            'status' => 1
        ];

        if ($escola->inserirEscola($dados)) {
            session_unset();
            session_destroy();
            header("location: ../sucesso.php");
        } else {
            echo "Erro ao inserir escola.";
        }
    } catch (variavelNaoExiste $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
        $_SESSION['statusCadastroEscola'] = "andamento";
        $_SESSION['etapaCadastroEscola'] = 6;
        header("Location: etapa6.php?erro");
        exit;
    } catch (validacaoVariaveis $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    } catch (Exception $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    }
} else {
    header("location: action.php");
}
?>