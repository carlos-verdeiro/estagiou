<?php
session_start();

if (
    isset($_POST['confirmado'])
) {

    $_SESSION['statusCadastroEmpresa'] = "confirmado";
    $_SESSION['etapaCadastroEmpresa'] = 6;

    header("Location: insert.php");
    exit;
}

if ($_SESSION['statusCadastroEmpresa'] != "andamento" || $_SESSION['etapaCadastroEmpresa'] < 6) {
    header("Location: action.php");
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etapa 6</title>

    <link rel="stylesheet" href="../../../assets/css/cadastro/etapas.css">

    <!--BIBLIOTECAS-->

    <!--BOOTSTRAP-->
    <link href="../../../assets/css/bootstrap.css" rel="stylesheet">
    <script src="../../../assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!--ICONES-->
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
    include_once "../../templates/cadastro/headerEtapa.php";
    //---------HEADER---------


    // Função para obter valor da sessão
    function pegarSessao($key)
    {
        return isset($_SESSION[$key]) && $_SESSION[$key] != NULL ? $_SESSION[$key] : NULL;
    }


    // Definindo constantes para as chaves da sessão
    define('CNPJ_KEY', 'cnpjEmpresa');
    define('NOME_EMPRESA_KEY', 'nomeEmpresa');
    define('TELEFONE_KEY', 'telefoneEmpresa');
    define('EMAIL_KEY', 'emailEmpresa');
    define('NOME_RESPONSAVEL_KEY', 'nomeResponsavelEmpresa');
    define('CARGO_RESPONSAVEL_KEY', 'cargoResponsavelEmpresa');
    define('TELEFONE_RESPONSAVEL_KEY', 'telefoneResponsavelEmpresa');
    define('EMAIL_RESPONSAVEL_KEY', 'emailResponsavelEmpresa');
    define('ENDERECO_KEY', 'enderecoEmpresa');
    define('BAIRRO_KEY', 'bairroEmpresa');
    define('NUMERO_KEY', 'numeroEmpresa');
    define('COMPLEMENTO_KEY', 'complementoEmpresa');
    define('CIDADE_KEY', 'cidadeEmpresa');
    define('ESTADO_KEY', 'estadoEmpresa');
    define('CEP_KEY', 'cepEmpresa');
    define('PAIS_KEY', 'paisEmpresa');
    define('ATUACAO_KEY', 'atuacaoEmpresa');
    define('DESCRICAO_KEY', 'descricaoEmpresa');
    define('WEBSITE_KEY', 'websiteEmpresa');
    define('LINKEDIN_KEY', 'linkedinEmpresa');
    define('INSTAGRAM_KEY', 'instagramEmpresa');
    define('FACEBOOK_KEY', 'facebookEmpresa');

    $cnpj = pegarSessao(CNPJ_KEY);
    $nomeEmpresa = pegarSessao(NOME_EMPRESA_KEY);
    $telefone = pegarSessao(TELEFONE_KEY);
    $email = pegarSessao(EMAIL_KEY);
    $nomeResponsavel = pegarSessao(NOME_RESPONSAVEL_KEY);
    $cargoResponsavel = pegarSessao(CARGO_RESPONSAVEL_KEY);
    $telefoneResponsavel = pegarSessao(TELEFONE_RESPONSAVEL_KEY);
    $emailResponsavel = pegarSessao(EMAIL_RESPONSAVEL_KEY);
    $endereco = pegarSessao(ENDERECO_KEY);
    $bairro = pegarSessao(BAIRRO_KEY);
    $numero = pegarSessao(NUMERO_KEY);
    $complemento = pegarSessao(COMPLEMENTO_KEY);
    $cidade = pegarSessao(CIDADE_KEY);
    $estado = pegarSessao(ESTADO_KEY);
    $cep = pegarSessao(CEP_KEY);
    $pais = pegarSessao(PAIS_KEY);
    $atuacao = pegarSessao(ATUACAO_KEY);
    $descricao = pegarSessao(DESCRICAO_KEY);
    $website = pegarSessao(WEBSITE_KEY);
    $linkedin = pegarSessao(LINKEDIN_KEY);
    $instagram = pegarSessao(INSTAGRAM_KEY);
    $facebook = pegarSessao(FACEBOOK_KEY);

    ?>


    <section id="cadastro">

        <form class="formConfirmacao row p-3 gap-3 m-5" method="post" id="formEtapa6">
            <div class="progress p-0" role="progressbar" aria-label="Example with label" style="height: 20px;" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 95%;">95%</div>
            </div>
            <h1 id='tituloCadastro'>CONFIRME SEUS DADOS</h1>
            <!--INICIO FORMULARIO-->

            <!--ETAPA 1-->
            <div class="row divInputs bg-dark-subtle p-2 rounded">
                <h3 class="m-3">Etapa 1</h3>
                <div class="form-floating m-1 row"><!--CNPJ-->
                    <input disabled autofocus type="text" id="cnpj" class="form-control w-100" placeholder="CNPJ" aria-label="CNPJ" name="cnpj" value="<?php echo $cnpj; ?>" required>
                    <label for="cnpj">CNPJ *</label>
                    <div class="invalid-feedback" id="feedback-cnpj">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--NOME DA EMPRESA-->
                    <input disabled type="text" id="nomeEmpresa" class="form-control w-100" placeholder="Nome da Empresa" aria-label="Nome da Empresa" name="nomeEmpresa" value="<?php echo $nomeEmpresa; ?>" maxlength="50" required>
                    <label for="nomeEmpresa">Nome da Empresa *</label>
                    <div class="invalid-feedback" id="feedback-nomeEmpresa">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--TELEFONE-->
                    <input disabled type="text" id="telefone" class="form-control w-100" placeholder="Telefone" aria-label="Telefone" value="<?php echo $telefone; ?>" maxlength="50" name="telefone" required>
                    <label for="telefone">Telefone *</label>
                    <div class="invalid-feedback" id="feedback-telefone">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL CORPORATIVO-->
                    <input disabled type="email" id="email" class="form-control w-100" placeholder="E-mail Corporativo" aria-label="E-mail Corporativo" name="email" value="<?php echo $email; ?>" maxlength="100" required>
                    <label for="email">E-mail Corporativo *</label>
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
                <div class="form-floating m-1 row"><!--NOME RESPONSÁVEL-->
                    <input disabled autofocus type="text" id="nomeResponsavel" class="form-control w-100" placeholder="Nome do Responsável" aria-label="Nome do Responsável" name="nomeResponsavel" value="<?php echo $nomeResponsavel; ?>" required>
                    <label for="nomeResponsavel">Nome do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-nomeResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--CARGO RESPONSÁVEL-->
                    <input disabled type="text" id="cargoResponsavel" class="form-control w-100" placeholder="Cargo do Responsável" aria-label="Cargo do Responsável" name="cargoResponsavel" value="<?php echo $cargoResponsavel; ?>" maxlength="50" required>
                    <label for="cargoResponsavel">Cargo do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-cargoResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--TELEFONE RESPONSAVEL-->
                    <input disabled type="text" id="telefoneResponsavel" class="form-control w-100" placeholder="Telefone do Responsável" aria-label="Telefone do Responsável" value="<?php echo $telefoneResponsavel; ?>" maxlength="50" name="telefoneResponsavel" required>
                    <label for="telefoneResponsavel">Telefone do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-telefoneResponsavel">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1 row"><!--EMAIL RESPONSAVEL-->
                    <input disabled type="email" id="emailResponsavel" class="form-control w-100" placeholder="E-mail do Responsável" aria-label="E-mail do Responsável" name="emailResponsavel" value="<?php echo $emailResponsavel; ?>" maxlength="100" required>
                    <label for="emailResponsavel">E-mail do Responsável *</label>
                    <div class="invalid-feedback" id="feedback-emailResponsavel">
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
                    <div class="form-floating m-1 row">
                        <div class="form-floating col p-0 me-1"><!--CEP-->
                            <input disabled autofocus type="text" id="cep" class="form-control w-100" placeholder="CEP" aria-label="CEP" name="cep" value="<?php echo $cep; ?>" required>
                            <label for="cep">CEP *</label>
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
                </div>
                <div class="botoesEdicao m-1"><!--BOTÕES-->
                    <a href="etapa3.php" class="btn btn-primary btnProximo">EDITAR</a>
                </div>
            </div>


            <!--ETAPA 4-->
            <div class="row divInputs bg-dark-subtle p-2 rounded">
                <h3 class="m-3">Etapa 4</h3>
                <div class="form-floating m-1 row">
                    <div class="form-floating m-1 row"><!--ÁREA DE ATUAÇÃO-->
                        <input disabled autofocus type="text" id="atuacao" class="form-control w-100" placeholder="Área de Atuação Empresarial" aria-label="Área de Atuação Empresarial" name="atuacao" value="<?php echo $atuacao; ?>" required>
                        <label for="atuacao">Área de Atuação Empresarial *</label>
                        <div class="invalid-feedback" id="feedback-atuacao">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="form-floating m-1 row"><!--DESCRIÇÃO-->
                        <textarea disabled id="descricao" class="form-control w-100" placeholder="Descrição da Empresa" aria-label="Descrição da Empresa" name="descricao" maxlength="500" required><?php echo $descricao; ?></textarea>
                        <label for="descricao">Descrição da Empresa *</label>
                        <div class="invalid-feedback" id="feedback-descricao">
                            Preencha corretamente!
                        </div>
                    </div>
                    <p class="text-dark text-start m-1 mt-3 ">Redes sociais:</p>

                    <div class="input-group  m-1"><!--WEBSITE-->
                        <span class="input-group-text" id="websiteSpan"><i class="bi bi-globe2"></i></span>
                        <input disabled type="text" class="form-control" placeholder="Website" aria-label="Website" aria-describedby="Website-link" maxlength="100" value="<?php echo $website; ?>" name="website">
                    </div>
                    <div class="input-group  m-1"><!--LINKEDIN-->
                        <span class="input-group-text" id="linkedinSpan"><i class="bi bi-linkedin"></i></span>
                        <input disabled type="text" class="form-control" placeholder="Linkedin" aria-label="Linkedin" aria-describedby="Linkedin-link" maxlength="100" value="<?php echo $linkedin; ?>" name="linkedin">
                    </div>
                    <div class="input-group  m-1"><!--INSTAGRAM-->
                        <span class="input-group-text" id="instagramSpan"><i class="bi bi-instagram"></i></span>
                        <input disabled type="text" class="form-control" placeholder="Instagram" aria-label="Instagram" aria-describedby="Instagram-link" maxlength="100" value="<?php echo $instagram; ?>" name="instagram">
                    </div>
                    <div class="input-group  m-1"><!--FACEBOOK-->
                        <span class="input-group-text" id="facebookSpan"><i class="bi bi-facebook"></i></span>
                        <input disabled type="text" class="form-control" placeholder="Facebook" aria-label="Facebook" aria-describedby="Facebook-link" maxlength="100" value="<?php echo $facebook; ?>" name="facebook">
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


</body>

</html>