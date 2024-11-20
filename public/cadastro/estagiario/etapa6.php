<?php
session_start();

if ($_SESSION['statusCadastroEstagiario'] != "andamento" || $_SESSION['etapaCadastroEstagiario'] < 6) {
    header("Location: action.php");
}


if (
    isset($_POST['confirmado'])
) {

    $_SESSION['statusCadastroEstagiario'] = "confirmado";
    $_SESSION['etapaCadastroEstagiario'] = 6;




    header("Location: insert.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 5</title>

    <link rel="stylesheet" href="../../../assets/css/cadastro/etapas.css">
    <link rel="shortcut icon" href="../../../assets/img/logo/logo.svg" type="image/x-icon">

    <!--BIBLIOTECAS-->

    <!--BOOTSTRAP-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../../assets/js/bootstrap.bundle.js"></script>
    <!--FIM BOOTSTRAP-->

    <!--JQUERY-->
    <script src="../../../assets/js/jquery-3.7.1.js"></script>
    <script type="text/javascript" src="../../../assets/js/jquery.mask.js"></script><!--PLUGIN JQUERY MASK-->
    <!--FIM JQUERY-->

    <!--FIM BIBLIOTECAS-->

</head>

<body>


    <?php

    //---------HEADER---------
    include_once "../../../assets/templates/cadastro/headerEtapa.php";
    //---------HEADER---------


    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }


    // Definindo constantes para as chaves da sessão
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

    ?>


    <section id="cadastro">

        <form class="formConfirmacao row p-3 gap-3 m-5" method="post" id="formEtapa6">
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 100%;">6/6</div>
            </div>
            <h1 id='tituloCadastro'>CONFIRME SEUS DADOS</h1>
            <!--INICIO FORMULARIO-->

            <!--ETAPA 1-->
            <div class="row divInputs bg-dark-subtle p-2 rounded">
                <h3 class="m-3">Etapa 1</h3>
                <div class="form-floating m-1 row"><!--CPF-->
                    <input disabled autofocus type="text" id="cpf" class="form-control w-100" placeholder="CPF" aria-label="CPF" name="cpf" value="<?php echo $cpf; ?>" required>
                    <label for="cpf">CPF *</label>
                    <div class="invalid-feedback" id="feedback-cpf">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME-->
                    <input disabled type="text" id="nome" class="form-control w-100" placeholder="Nome" aria-label="Nome" name="nome" value="<?php echo $nome; ?>" maxlength="50" required>
                    <label for="nome">Nome *</label>
                    <div class="invalid-feedback" id="feedback-nome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--SOBRENOME-->
                    <input disabled type="text" id="sobrenome" class="form-control w-100" placeholder="Sobrenome" aria-label="Sobrenome" value="<?php echo $sobrenome; ?>" maxlength="50" name="sobrenome">
                    <label for="sobrenome">Sobrenome</label>
                    <div class="invalid-feedback" id="feedback-sobrenome">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL-->
                    <input disabled type="email" id="email" class="form-control w-100" placeholder="Email" aria-label="Email" name="email" value="<?php echo $email; ?>" required>
                    <label for="email">E-mail *</label>
                    <div class="invalid-feedback" id="feedback-email">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="botoesEdicao m-1"><!--BOTÕES-->
                    <a href="etapa1.php" class="btn btn-primary btnProximo">EDITAR</a>
                </div>
            </div>


            <!--ETAPA 2-->
            <div class="row divInputs bg-dark-subtle p-2 rounded">
                <h3 class="m-3">Etapa 2</h3>
                <div class="form-floating m-1 row"><!--RG-->
                    <input disabled DISA autofocus type="text" id="rg" class="form-control w-100" placeholder="RG" aria-label="RG" name="rg" value="<?php echo $rg; ?>" required>
                    <label for="rg">RG *</label>
                    <div class="invalid-feedback" id="feedback-rg">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="m-1 row">
                    <div class="form-floating col p-0 me-1"><!--ÓRGÃO EMISSOR-->
                        <input disabled type="text" id="orgaoEmissor" list="orgaos" class="form-control w-100" placeholder="Órgão Emissor" aria-label="Órgão Emissor" name="orgaoEmissor" value="<?php echo $orgaoEmissor; ?>" maxlength="10" required>
                        <label for="orgaoEmissor">Órgão Emissor *</label>
                        <datalist id="orgaos">
                            <option value="SSP">Secretaria de Segurança Pública</option>
                            <option value="PC">Polícia Civil</option>
                            <option value="IIF">Instituto de Identificação Forense</option>
                            <option value="PAC">Postos de Atendimento ao Cidadão</option>

                        </datalist>
                        <div class="invalid-feedback" id="feedback-orgaoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO EMISSOR-->
                        <select disabled id="estadoEmissor" class="form-select w-100" aria-label="Estado Emissor" name="estadoEmissor" required>
                            <option <?php echo ($estadoEmissor == 'NA') ? 'selected' : ''; ?> hidden value="NA">Selecione</option>
                            <option <?php echo ($estadoEmissor == 'AC') ? 'selected' : ''; ?> value="AC">Acre</option>
                            <option <?php echo ($estadoEmissor == 'AL') ? 'selected' : ''; ?> value="AL">Alagoas</option>
                            <option <?php echo ($estadoEmissor == 'AP') ? 'selected' : ''; ?> value="AP">Amapá</option>
                            <option <?php echo ($estadoEmissor == 'AM') ? 'selected' : ''; ?> value="AM">Amazonas</option>
                            <option <?php echo ($estadoEmissor == 'BA') ? 'selected' : ''; ?> value="BA">Bahia</option>
                            <option <?php echo ($estadoEmissor == 'CE') ? 'selected' : ''; ?> value="CE">Ceará</option>
                            <option <?php echo ($estadoEmissor == 'DF') ? 'selected' : ''; ?> value="DF">Distrito Federal</option>
                            <option <?php echo ($estadoEmissor == 'ES') ? 'selected' : ''; ?> value="ES">Espírito Santo</option>
                            <option <?php echo ($estadoEmissor == 'GO') ? 'selected' : ''; ?> value="GO">Goiás</option>
                            <option <?php echo ($estadoEmissor == 'MA') ? 'selected' : ''; ?> value="MA">Maranhão</option>
                            <option <?php echo ($estadoEmissor == 'MT') ? 'selected' : ''; ?> value="MT">Mato Grosso</option>
                            <option <?php echo ($estadoEmissor == 'MS') ? 'selected' : ''; ?> value="MS">Mato Grosso do Sul</option>
                            <option <?php echo ($estadoEmissor == 'MG') ? 'selected' : ''; ?> value="MG">Minas Gerais</option>
                            <option <?php echo ($estadoEmissor == 'PA') ? 'selected' : ''; ?> value="PA">Pará</option>
                            <option <?php echo ($estadoEmissor == 'PB') ? 'selected' : ''; ?> value="PB">Paraíba</option>
                            <option <?php echo ($estadoEmissor == 'PR') ? 'selected' : ''; ?> value="PR">Paraná</option>
                            <option <?php echo ($estadoEmissor == 'PE') ? 'selected' : ''; ?> value="PE">Pernambuco</option>
                            <option <?php echo ($estadoEmissor == 'PI') ? 'selected' : ''; ?> value="PI">Piauí</option>
                            <option <?php echo ($estadoEmissor == 'RJ') ? 'selected' : ''; ?> value="RJ">Rio de Janeiro</option>
                            <option <?php echo ($estadoEmissor == 'RN') ? 'selected' : ''; ?> value="RN">Rio Grande do Norte</option>
                            <option <?php echo ($estadoEmissor == 'RS') ? 'selected' : ''; ?> value="RS">Rio Grande do Sul</option>
                            <option <?php echo ($estadoEmissor == 'RO') ? 'selected' : ''; ?> value="RO">Rondônia</option>
                            <option <?php echo ($estadoEmissor == 'RR') ? 'selected' : ''; ?> value="RR">Roraima</option>
                            <option <?php echo ($estadoEmissor == 'SC') ? 'selected' : ''; ?> value="SC">Santa Catarina</option>
                            <option <?php echo ($estadoEmissor == 'SP') ? 'selected' : ''; ?> value="SP">São Paulo</option>
                            <option <?php echo ($estadoEmissor == 'SE') ? 'selected' : ''; ?> value="SE">Sergipe</option>
                            <option <?php echo ($estadoEmissor == 'TO') ? 'selected' : ''; ?> value="TO">Tocantins</option>

                        </select>
                        <label for="estadoEmissor">Estado Emissor *</label>
                        <div class="invalid-feedback" id="feedback-estadoEmissor">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>

                <div class="form-floating m-1 row"><!--GENERO-->
                    <select disabled id="genero" class="form-select w-100" placeholder="Gênero" aria-label="Gênero" name="genero" value="<?php echo $genero; ?>" required>
                        <option <?php echo ($genero == 'NA') ? 'selected' : ''; ?> hidden disabled value="NA">Selecione</option>
                        <option <?php echo ($genero == 'M') ? 'selected' : ''; ?> value="M">Masculino</option>
                        <option <?php echo ($genero == 'F') ? 'selected' : ''; ?> value="F">Feminino</option>
                        <option <?php echo ($genero == 'O') ? 'selected' : ''; ?> value="O">Outros</option>

                    </select>
                    <label for="genero">Gênero *</label>
                    <div class="invalid-feedback" id="feedback-genero">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME SOCIAL-->
                    <input disabled type="text" id="nomeSocial" class="form-control w-100" placeholder="Nome Social" aria-label="Nome Social" name="nomeSocial" value="<?php echo $nomeSocial; ?>">
                    <label for="nomeSocial">Nome Social</label>
                    <div class="invalid-feedback" id="feedback-rg">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--ESTADO CIVIL-->
                    <select disabled id="estadoCivil" class="form-select w-100" placeholder="Estado Civil" aria-label="Estado Civil" name="estadoCivil" value="<?php echo $estadoCivil; ?>" required>
                        <option <?php echo ($estadoCivil == 'NA') ? 'selected' : ''; ?> hidden disabled value="NA">Selecione</option>
                        <option <?php echo ($estadoCivil == 'solteiro') ? 'selected' : ''; ?> value="solteiro">Solteiro(a)</option>
                        <option <?php echo ($estadoCivil == 'casado') ? 'selected' : ''; ?> value="casado">Casado(a)</option>
                        <option <?php echo ($estadoCivil == 'separado') ? 'selected' : ''; ?> value="separado">Separado(a)</option>
                        <option <?php echo ($estadoCivil == 'divorciado') ? 'selected' : ''; ?> value="divorciado">Divorciado(a)</option>
                        <option <?php echo ($estadoCivil == 'viuvo') ? 'selected' : ''; ?> value="viuvo">Viúvo(a)</option>

                    </select>
                    <label for="estadoCivil">Estado Civil *</label>
                    <div class="invalid-feedback" id="feedback-estadoCivil">
                        Preencha corretamente!
                    </div>

                </div>
                <div class="botoesEdicao m-1"><!--BOTÕES-->
                    <a href="etapa2.php" class="btn btn-primary btnProximo">EDITAR</a>
                </div>
            </div>


            <!--ETAPA 3-->
            <div class="row divInputs bg-dark-subtle p-2 rounded">
                <h3 class="m-3">Etapa 3</h3>
                <div class="m-1 row">
                    <div class="form-floating col p-0 me-1"><!--ÓRGÃO EMISSOR-->
                        <input disabled autofocus type="date" id="dataNascimento" min="1924-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control w-100" placeholder="Data de nascimento" aria-label="Data de nascimento" name="dataNascimento" value="<?php echo $dataNascimento; ?>" required>
                        <label for="dataNascimento">Data de nascimento *</label>
                        <div class="invalid-feedback" id="feedback-dataNascimento">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO EMISSOR-->
                        <input disabled type="text" id="nacionalidade" list="listaNacionalidade" class="form-control w-100" placeholder="Nacionalidade" aria-label="Nacionalidade" name="nacionalidade" value="<?php echo $nacionalidade; ?>" maxlength="20" required>
                        <label for="nacionalidade">Nacionalidade *</label>
                        <datalist id="listaNacionalidade">
                            <option value="Brasileira"></option>
                            <option value="Americana"></option>
                            <option value="Portuguesa"></option>
                            <option value="Italiana"></option>
                            <option value="Japonesa"></option>
                            <option value="Alemã"></option>
                            <option value="Argentina"></option>
                            <option value="Francesa"></option>
                            <option value="Espanhola"></option>
                            <option value="Chinesa"></option>
                        </datalist>
                        <div class="invalid-feedback" id="feedback-nacionalidade">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row">
                    <div class="form-floating col p-0 me-1"><!--CELULAR-->
                        <input disabled type="text" id="celular" class="form-control w-100" placeholder="Celular" aria-label="Celular" name="celular" value="<?php echo $celular; ?>" required maxlength="15">
                        <label for="celular">Celular *</label>
                        <div class="invalid-feedback" id="feedback-celular">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--TELEFONE-->
                        <input disabled type="text" id="telefone" class="form-control w-100" placeholder="Telefone" aria-label="Telefone" name="telefone" value="<?php echo $telefone; ?>" maxlength="14">
                        <label for="telefone">Telefone</label>
                        <div class="invalid-feedback" id="feedback-telefone">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="m-1 row">
                    <div class=" form-floating col p-0 me-1"><!--CNH-->
                        <h6>Categoria de CNH que possui: </h6>
                        <div class=" m-1 form-floating row p-0 me-1">
                            <div class="form-floating col p-0 me-1">
                                <div class="form-check">
                                    <input disabled class="form-check-input" type="checkbox" value="A" id="cnhA" name="cnh[]" <?php echo $c = (in_array("A", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhA">
                                        A
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input disabled class="form-check-input" type="checkbox" value="B" id="cnhB" name="cnh[]" <?php echo $c = (in_array("B", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhB">
                                        B
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input disabled class="form-check-input" type="checkbox" value="C" id="cnhC" name="cnh[]" <?php echo $c = (in_array("C", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhC">
                                        C
                                    </label>
                                </div>
                            </div>
                            <div class="form-floating col p-0 me-1"><!--CNH-->
                                <div class="form-check">
                                    <input disabled class="form-check-input" type="checkbox" value="D" id="cnhD" name="cnh[]" <?php echo $c = (in_array("D", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhD">
                                        D
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input disabled class="form-check-input" type="checkbox" value="E" id="cnhE" name="cnh[]" <?php echo $c = (in_array("E", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhE">
                                        E
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input disabled class="form-check-input" type="checkbox" value="cnhSem" id="cnhSem" name="cnhSem" <?php echo $c = (in_array("N", str_split($cnh))) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="cnhSem">
                                        Não Possuo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--DEPENDENTES-->
                        <input disabled type="number" id="dependentes" min=0 class="form-control w-100" placeholder="Dependentes" aria-label="Dependentes" name="dependentes" value="<?php echo $dependentes; ?>" maxlength="10" required>
                        <label for="dependentes">Dependentes *</label>
                        <div class="invalid-feedback" id="feedback-dependentes">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="botoesEdicao m-1"><!--BOTÕES-->
                    <a href="etapa3.php" class="btn btn-primary btnProximo">EDITAR</a>
                </div>
            </div>


            <!--ETAPA 4-->
            <div class="row divInputs bg-dark-subtle p-2 rounded">
                <h3 class="m-3">Etapa 4</h3>
                <div class="form-floating m-1 row">
                    <div class="form-floating col p-0 me-1"><!--CEP-->
                        <input disabled autofocus type="text" id="cep" class="form-control w-100" placeholder="CEP" aria-label="CEP" name="cep" value="<?php echo $cep; ?>">
                        <label for="cep">CEP</label>
                        <div class="invalid-feedback" id="feedback-cep">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--PAÍS-->
                        <input disabled type="text" id="pais" class="form-control w-100" placeholder="País" aria-label="País" name="pais" value="<?php echo ($pais != NULL) ? $pais : 'Brasil'; ?>" maxlength="40" required>
                        <label for="pais">País *</label>
                        <div class="invalid-feedback" id="feedback-pais">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>


                <div class="form-floating m-1 row">
                    <div class="form-floating col p-0 me-1"><!--CIDADE-->
                        <input disabled type="text" id="cidade" class="form-control w-100" placeholder="Cidade" aria-label="Cidade" value="<?php echo $cidade; ?>" maxlength="50" name="cidade" required>
                        <label for="cidade">Cidade *</label>
                        <div class="invalid-feedback" id="feedback-cidade">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--ESTADO-->
                        <select disabled id="estado" class="form-select w-100" aria-label="Estado" name="estado" required>
                            <option <?php echo ($estado == 'NA' || $estado == NULL || $estado == '') ? 'selected' : ''; ?> disabled hidden value="NA">Selecione</option>
                            <option <?php echo ($estado == 'AC') ? 'selected' : ''; ?> value="AC">Acre</option>
                            <option <?php echo ($estado == 'AL') ? 'selected' : ''; ?> value="AL">Alagoas</option>
                            <option <?php echo ($estado == 'AP') ? 'selected' : ''; ?> value="AP">Amapá</option>
                            <option <?php echo ($estado == 'AM') ? 'selected' : ''; ?> value="AM">Amazonas</option>
                            <option <?php echo ($estado == 'BA') ? 'selected' : ''; ?> value="BA">Bahia</option>
                            <option <?php echo ($estado == 'CE') ? 'selected' : ''; ?> value="CE">Ceará</option>
                            <option <?php echo ($estado == 'DF') ? 'selected' : ''; ?> value="DF">Distrito Federal</option>
                            <option <?php echo ($estado == 'ES') ? 'selected' : ''; ?> value="ES">Espírito Santo</option>
                            <option <?php echo ($estado == 'GO') ? 'selected' : ''; ?> value="GO">Goiás</option>
                            <option <?php echo ($estado == 'MA') ? 'selected' : ''; ?> value="MA">Maranhão</option>
                            <option <?php echo ($estado == 'MT') ? 'selected' : ''; ?> value="MT">Mato Grosso</option>
                            <option <?php echo ($estado == 'MS') ? 'selected' : ''; ?> value="MS">Mato Grosso do Sul</option>
                            <option <?php echo ($estado == 'MG') ? 'selected' : ''; ?> value="MG">Minas Gerais</option>
                            <option <?php echo ($estado == 'PA') ? 'selected' : ''; ?> value="PA">Pará</option>
                            <option <?php echo ($estado == 'PB') ? 'selected' : ''; ?> value="PB">Paraíba</option>
                            <option <?php echo ($estado == 'PR') ? 'selected' : ''; ?> value="PR">Paraná</option>
                            <option <?php echo ($estado == 'PE') ? 'selected' : ''; ?> value="PE">Pernambuco</option>
                            <option <?php echo ($estado == 'PI') ? 'selected' : ''; ?> value="PI">Piauí</option>
                            <option <?php echo ($estado == 'RJ') ? 'selected' : ''; ?> value="RJ">Rio de Janeiro</option>
                            <option <?php echo ($estado == 'RN') ? 'selected' : ''; ?> value="RN">Rio Grande do Norte</option>
                            <option <?php echo ($estado == 'RS') ? 'selected' : ''; ?> value="RS">Rio Grande do Sul</option>
                            <option <?php echo ($estado == 'RO') ? 'selected' : ''; ?> value="RO">Rondônia</option>
                            <option <?php echo ($estado == 'RR') ? 'selected' : ''; ?> value="RR">Roraima</option>
                            <option <?php echo ($estado == 'SC') ? 'selected' : ''; ?> value="SC">Santa Catarina</option>
                            <option <?php echo ($estado == 'SP') ? 'selected' : ''; ?> value="SP">São Paulo</option>
                            <option <?php echo ($estado == 'SE') ? 'selected' : ''; ?> value="SE">Sergipe</option>
                            <option <?php echo ($estado == 'TO') ? 'selected' : ''; ?> value="TO">Tocantins</option>

                        </select> <label for="estado">Estado *</label>
                        <div class="invalid-feedback" id="feedback-estado">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row">

                    <div class="form-floating col p-0 me-1"><!--ENDEREÇO-->
                        <input disabled type="text" id="endereco" class="form-control w-100" placeholder="Endereço" aria-label="Endereço" value="<?php echo $endereco; ?>" maxlength="255" name="endereco" required>
                        <label for="endereco">Endereço *</label>
                        <div class="invalid-feedback" id="feedback-endereco">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating col p-0 md-1"><!--BAIRRO-->
                        <input disabled type="text" id="bairro" class="form-control w-100" placeholder="Bairro" aria-label="Bairro" value="<?php echo $bairro; ?>" maxlength="70" name="bairro" required>
                        <label for="bairro">Bairro *</label>
                        <div class="invalid-feedback" id="feedback-bairro">
                            Preencha corretamente!
                        </div>
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NÚMERO-->
                    <input disabled type="text" id="numero" class="form-control w-100" placeholder="Número" aria-label="Número" name="numero" value="<?php echo $numero; ?>" maxlength="10" required>
                    <label for="numero">Número *</label>
                    <div class="invalid-feedback" id="feedback-numero">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--COMPLEMENTO-->
                    <input disabled type="text" id="complemento" class="form-control w-100" placeholder="Complemento" aria-label="Complemento" name="complemento" value="<?php echo $complemento; ?>">
                    <label for="complemento">Complemento</label>
                    <div class="invalid-feedback" id="feedback-complemento">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="botoesEdicao m-1"><!--BOTÕES-->
                    <a href="etapa4.php" class="btn btn-primary btnProximo">EDITAR</a>
                </div>
            </div>
            <input type="hidden" name="confirmado">

            <!--FIM FORMULARIO-->
            <div class="botoesAvanco row"><!--BOTÕES-->
                <a href="etapa5.php" class="btn btn-warning btnVoltar col  m-1 btn btn-lg w-50">VOLTAR</a>
                <button type="submit" class="btn btn-success btnProximo col m-1 btn btn-lg w-50">CONCLUIR</button>
            </div>
        </form>
    </section>

    <script src="../../../assets/js/cadastro/validacaoEstagiario.js"></script>

</body>

</html>