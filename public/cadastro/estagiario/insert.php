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
    isset($_SESSION['statusCadastro']) && $_SESSION['statusCadastro'] == "confirmado" &&
    isset($_SESSION['tipoCadastro']) && $_SESSION['tipoCadastro'] == "estagiario" &&
    isset($_SESSION['etapaCadastro']) && $_SESSION['etapaCadastro'] == 6
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
            $_SESSION['sobrenomeEstagiario'],
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
                case 'sobrenome':
                case 'bairro':
                case 'cidade':
                case 'pais':
                case 'nacionalidade':
                case 'orgaoEmissor':
                case 'genero':
                case 'estadoEmissor':
                case 'estado':
                case 'endereco':
                case 'estadoCivil':





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

                case 'cnh':
                case 'nomeSocial':
                case 'complemento':


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
            echo "CPF ERRO\n";
            $erros++;
        }
        if (!validar($nome, 'nome', 1, 100)) {
            echo "Nome ERRO\n";
            $erros++;
        }
        if (!validar($sobrenome, 'sobrenome', 0, 100)) {
            echo "Sobrenome ERRO\n";
            $erros++;
        }
        if (!validar($email, 'email', 3, 100)) {
            echo "Email ERRO\n";
            $erros++;
        }
        if (!validar($rg, 'rg', 9, 9)) {
            echo "RG ERRO\n";
            $erros++;
        }
        if (!validar($orgaoEmissor, 'orgaoEmissor', 1, 50)) {
            echo "Órgão Emissor ERRO\n";
            $erros++;
        }
        if (!validar($estadoEmissor, 'estadoEmissor', 2, 2)) {
            echo "Estado Emissor ERRO\n";
            $erros++;
        }
        if (!validar($genero, 'genero', 1, 50)) {
            echo "Gênero ERRO\n";
            $erros++;
        }
        if (!validar($nomeSocial, 'nomeSocial', 0, 255)) {
            echo "Nome Social ERRO\n";
            $erros++;
        }
        if (!validar($estadoCivil, 'estadoCivil', 2, 255)) {
            echo "Estado Civil ERRO\n";
            $erros++;
        }
        if (!validar($dataNascimento, 'dataNascimento', 0, 100)) {
            echo "Data de Nascimento ERRO\n";
            $erros++;
        }
        if (!validar($nacionalidade, 'nacionalidade', 0, 100)) {
            echo "Nacionalidade ERRO\n";
            $erros++;
        }
        if (!validar($celular, 'celular', 11, 11)) {
            echo "Celular ERRO\n";
            $erros++;
        }
        if (!validar($telefone, 'telefone', 0, 10)) {
            echo "Telefone ERRO\n";
            $erros++;
        }
        if (!validar($cnh, 'cnh', 0, 50)) {
            echo "CNH ERRO\n";
            $erros++;
        }
        if (!validar($dependentes, 'dependentes', 0, 11)) {
            echo "Dependentes ERRO\n";
            $erros++;
        }
        if (!validar($endereco, 'endereco', 0, 255)) {
            echo "Endereço ERRO\n";
            $erros++;
        }
        if (!validar($bairro, 'bairro', 0, 100)) {
            echo "Bairro ERRO\n";
            $erros++;
        }
        if (!validar($numero, 'numero', 0, 50)) {
            echo "Número ERRO\n";
            $erros++;
        }
        if (!validar($complemento, 'complemento', 0, 255)) {
            echo "Complemento ERRO\n";
            $erros++;
        }
        if (!validar($cidade, 'cidade', 0, 100)) {
            echo "Cidade ERRO\n";
            $erros++;
        }
        if (!validar($estado, 'estado', 0, 100)) {
            echo "Estado ERRO\n";
            $erros++;
        }
        if (!validar($cep, 'cep', 8, 8)) {
            echo "CEP ERRO\n";
            $erros++;
        }
        if (!validar($pais, 'pais', 2, 100)) {
            echo "País ERRO\n";
            $erros++;
        }
        if (!validar($senha, 'senha', 0, 100)) {
            echo "Senha ERRO\n";
            $erros++;
        }

        if ($erros > 0) {
            $_SESSION['statusCadastro'] = "andamento";
            $_SESSION['etapaCadastro'] = 6;
            header("Location: etapa6.php?erro");
            exit;
        }











        $usernameDB = "estagiarioInsert";
        $passwordDB = "123";
        include_once "../../../server/conexao.php";
    } catch (variavelNaoExiste $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    } catch (validacaoVariaveis $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    } catch (Exception $e) {
        // tratar exceções gerais
    }
} else {
}
?>