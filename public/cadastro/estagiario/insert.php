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
        <l-ring size="2a00" stroke="10" bg-opacity="0" speed="2" color="#4c4eba"></l-ring>
        <h3>Carregando...</h3>
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
            $_SESSION['cnhSemEstagiario'],
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

        $cpf = pegarSessao(CPF_KEY);
        $nome = pegarSessao(NOME_KEY);
        $sobrenome = pegarSessao(SOBRENOME_KEY);
        $email = pegarSessao(EMAIL_KEY);
        $rg = pegarSessao(RG_KEY);
        $orgaoEmissor = pegarSessao(ORGAO_EMISSOR_KEY);
        $estadoEmissor = pegarSessao(ESTADO_EMISSOR_KEY);
        $genero = pegarSessao(GENERO_KEY);
        $nomeSocial = pegarSessao(NOME_SOCIAL_KEY);
        $estadoCivil = pegarSessao(ESTADO_CIVIL_KEY);
        $dataNascimento = pegarSessao(DATA_NASCIMENTO_KEY);
        $nacionalidade = pegarSessao(NACIONALIDADE_KEY);
        $celular = pegarSessao(CELULAR_KEY);
        $telefone = pegarSessao(TELEFONE_KEY);
        $cnh = pegarSessao(CNH_KEY);
        $dependentes = pegarSessao(DEPENDENTES_KEY);
        $endereco = pegarSessao(ENDERECO_KEY);
        $bairro = pegarSessao(BAIRRO_KEY);
        $numero = pegarSessao(NUMERO_KEY);
        $complemento = pegarSessao(COMPLEMENTO_KEY);
        $cidade = pegarSessao(CIDADE_KEY);
        $estado = pegarSessao(ESTADO_KEY);
        $cep = pegarSessao(CEP_KEY);
        $pais = pegarSessao(PAIS_KEY);
        $senha = pegarSessao(SENHA_KEY);

        $usernameDB = "estagiarioInsert";
        $passwordDB = "123";
        include_once "../../../server/conexao.php";
    } catch (variavelNaoExiste $e) {
        echo 'Erro capturado: ',  $e->getMessage(), "\n";
    } catch (Exception $e) {
        // tratar exceções gerais
    }
} else {
}
?>