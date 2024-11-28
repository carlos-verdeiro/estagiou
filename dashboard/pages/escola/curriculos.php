<!-- Section para o cadastro de alunos -->
<section class="sectionPages">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de Alunos</h2>
        <div class="d-flex align-items-center justify-content-end mb-3">
            <!-- Botão para adicionar novo aluno -->
            <button class="btn btn-primary" id="btnModalNovoCand" data-bs-toggle="modal" data-bs-target="#alunoModal">
                Adicionar Novo Aluno
            </button>
        </div>

        <!-- Lista de alunos em cards -->
        <div class="row" id="divCardsAlunos">
            <!-- card aluno -->
        </div>
    </div>
    <!--TOAST INFORMAÇÃO-->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastInformacao" class="toast" role="information" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Estagiou</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="corpoToastInformacao">
                Text
            </div>
        </div>
    </div>
</section>

<!-- Modal para cadastro de aluno -->
<div class="modal fade" id="alunoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="alunoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alunoModalLabel">Cadastrar Novo Aluno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAluno" method="post" enctype='multipart/form-data'>
                <input type="hidden" name="tipoForm" id="tipoForm" value="novo">
                <input type="hidden" name="formulario_id" id="formulario_id" value="edicaoEscolar">
                <input type="hidden" name="id_estagiario" id="id_estagiario">
                <div class="modal-body">
                    <!-- Informações Pessoais -->
                    <h6>Informações Pessoais</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome*</label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                            <div class="invalid-feedback" id="feedback-nome">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="sobrenome" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estadoCivil" class="form-label">Estado Civil*</label>
                            <select id="estadoCivil" class="form-select w-100" placeholder="Estado Civil" aria-label="Estado Civil" name="estadoCivil" value="<?php echo $estadoCivil; ?>" required>
                                <option hidden disabled value="NA">Selecione</option>
                                <option value="solteiro">Solteiro(a)</option>
                                <option value="casado">Casado(a)</option>
                                <option value="separado">Separado(a)</option>
                                <option value="divorciado">Divorciado(a)</option>
                                <option value="viuvo">Viúvo(a)</option>
                            </select>
                            <div class="invalid-feedback" id="feedback-estadoCivil">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="genero" class="form-label">Gênero*</label>
                            <select id="genero" class="form-select w-100" placeholder="Gênero" aria-label="Gênero" name="genero" value="<?php echo $genero; ?>" required>
                                <option hidden disabled value="NA">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                                <option value="O">Outros</option>
                            </select>
                            <div class="invalid-feedback" id="feedback-genero">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF*</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                            <div class="invalid-feedback" id="feedback-cpf">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="rg" class="form-label">RG*</label>
                            <input type="text" class="form-control" id="rg" name="rg" required>
                            <div class="invalid-feedback" id="feedback-rg">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rgOrgEmissor" class="form-label">Órgão Emissor do RG*</label>
                            <input type="text" id="orgaoEmissor" list="orgaos" class="form-control w-100" aria-label="Órgão Emissor" name="orgaoEmissor" maxlength="10" required>

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
                        <div class="col-md-6">
                            <label for="rgEstadoEmissor" class="form-label">Estado Emissor do RG*</label>
                            <select id="estadoEmissor" class="form-select w-100" aria-label="Estado Emissor" name="estadoEmissor" required>
                                <option hidden value="NA">Selecione</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>

                            </select>
                            <div class="invalid-feedback" id="feedback-estadoEmissor">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dataNascimento" class="form-label">Data de Nascimento*</label>
                        <input type="date" id="dataNascimento" min="1924-01-01" max="<?php echo date('Y-m-d'); ?>" class="form-control w-100" placeholder="Data de nascimento" aria-label="Data de nascimento" name="dataNascimento" required>
                        <div class="invalid-feedback" id="feedback-dataNascimento">
                            Preencha corretamente!
                        </div>
                    </div>

                    <!-- Contato -->
                    <h6>Contato</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail*</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback" id="feedback-email">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-6" id="divSenha">
                            <label for="senha" class="form-label">Senha*</label>
                            <input type="password" class="form-control" id="senha" name="senha">
                            <div class="invalid-feedback" id="feedback-senha">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone">
                            <div class="invalid-feedback" id="feedback-telefone">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Celular*</label>
                            <input type="text" class="form-control" id="celular" name="celular" required>
                            <div class="invalid-feedback" id="feedback-celular">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <h6>Endereço</h6>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="endereco" class="form-label">Endereço*</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" required>
                            <div class="invalid-feedback" id="feedback-endereco">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="numero" class="form-label">Número*</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                            <div class="invalid-feedback" id="feedback-numero">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento">
                            <div class="invalid-feedback" id="feedback-complemento">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="bairro" class="form-label">Bairro*</label>
                            <input type="text" class="form-control" id="bairro" name="bairro">
                            <div class="invalid-feedback" id="feedback-bairro">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="cidade" class="form-label">Cidade*</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                            <div class="invalid-feedback" id="feedback-cidade">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado*</label>
                            <select id="estado" class="form-select w-100" aria-label="Estado" name="estado" required>
                                <option disabled hidden value="NA">Selecione</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>

                            </select>
                            <div class="invalid-feedback" id="feedback-estado">
                                Preencha corretamente!
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="cep" class="form-label">CEP*</label>
                            <input type="text" class="form-control" id="cep" name="cep">
                            <div class="invalid-feedback" id="feedback-cep">
                                Preencha corretamente!
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pais" class="form-label">País*</label>
                        <input type="text" class="form-control" id="pais" name="pais" required>
                        <div class="invalid-feedback" id="feedback-pais">
                            Preencha corretamente!
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <h6>Informações Adicionais</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nacionalidade" class="form-label">Nacionalidade*</label>
                            <input type="text" list="listaNacionalidade" class="form-control" id="nacionalidade" name="nacionalidade" required>
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
                        <div class="col-md-6">
                            <label for="dependentes" class="form-label">Dependentes*</label>
                            <input type="number" class="form-control" id="dependentes" name="dependentes" required>
                            <div class="invalid-feedback" id="feedback-dependentes">
                                Preencha corretamente!
                            </div>
                            <p class="text-secondary text-end mb-0">Digite 0 caso não haja!</p>

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cnh" class="form-label">CNH*</label>
                        <div class=" m-1 form-floating row p-0 me-1">
                            <div class="form-floating col p-0 me-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="A" id="cnhA" name="cnh[]">
                                    <label class="form-check-label" for="cnhA">
                                        A
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="B" id="cnhB" name="cnh[]">
                                    <label class="form-check-label" for="cnhB">
                                        B
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="C" id="cnhC" name="cnh[]">
                                    <label class="form-check-label" for="cnhC">
                                        C
                                    </label>
                                </div>
                            </div>
                            <div class="form-floating col p-0 me-1"><!--CNH-->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="D" id="cnhD" name="cnh[]">
                                    <label class="form-check-label" for="cnhD">
                                        D
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="E" id="cnhE" name="cnh[]">
                                    <label class="form-check-label" for="cnhE">
                                        E
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="cnhSem" id="cnhSem" name="cnhSem">
                                    <label class="form-check-label" for="cnhSem">
                                        Não Possui
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="feedback-cnh">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nomeSocial" class="form-label">Nome Social</label>
                        <input type="text" class="form-control" id="nomeSocial" name="nomeSocial">
                        <div class="invalid-feedback" id="feedback-nomeSocial">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="disponibilidade" class="form-label">Disponibilidade</label>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" name="integral" type="checkbox" id="integral">
                                <label class="form-check-label" for="integral">Período Integral</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="meio" type="checkbox" id="meio">
                                <label class="form-check-label" for="meio">Meio Período</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="remoto" type="checkbox" id="remoto">
                                <label class="form-check-label" for="remoto">Remoto</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="presencial" type="checkbox" id="presencial">
                                <label class="form-check-label" for="presencial">Presencial</label>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="feedback-disponibilidade">
                            Preencha corretamente!
                        </div>
                    </div>

                    <!-- Escolaridade e Habilidades -->
                    <h6>Escolaridade e Habilidades</h6>
                    <div class="mb-3">
                        <label for="escolaridade" class="form-label">Escolaridade</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="1" required id="escolaridade1" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade1">Fundamental Incompleto</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="2" required id="escolaridade2" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade2">Fundamental Completo</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="3" required id="escolaridade3" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade3">Médio Incompleto</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="4" required id="escolaridade4" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade4">Médio Completo</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="5" required id="escolaridade5" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade5">Superior Incompleto</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="6" required id="escolaridade6" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade6">Superior Completo</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="7" required id="escolaridade7" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade7">Pós-Graduação Incompleto</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="escolaridade" value="8" required id="escolaridade8" class="form-check-input">
                                    <label class="form-check-label" for="escolaridade8">Pós-Graduação Completo</label>
                                </div>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="feedback-escolaridade">
                            Preencha corretamente!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="formacoes" class="form-label">Formações</label>
                        <textarea class="form-control" id="formacoes" name="formacoes" rows="3" maxlength="1000"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="experiencias" class="form-label">Experiências</label>
                        <textarea class="form-control" id="experiencias" name="experiencias" rows="3" maxlength="1000"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="certificacoes" class="form-label">Certificações</label>
                        <textarea class="form-control" id="certificacoes" name="certificacoes" rows="3" maxlength="1000"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="habilidades" class="form-label">Habilidades</label>
                        <textarea class="form-control" id="habilidades" name="habilidades" rows="3" maxlength="1000"></textarea>
                    </div>

                    <!-- Proficiência em Línguas -->
                    <h6>Proficiência em Línguas</h6>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idiomaIngles" name="idiomaIngles">
                                <label class="form-check-label" for="idiomaIngles">Inglês</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idiomaEspanhol" name="idiomaEspanhol">
                                <label class="form-check-label" for="idiomaEspanhol">Espanhol</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="idiomaFrances" name="idiomaFrances">
                                <label class="form-check-label" for="idiomaFrances">Francês</label>
                            </div>
                        </div>
                        <div class="col">
                            <select class="form-select selectNivel " disabled aria-label="Nível de Inglês" name="nivelIngles" id="nivelIngles" name="nivelIngles"">
                                <option selected value="0" disabled>Nível de Inglês</option>
                                <option value="1">Básico</option>
                                <option value="2">Intermediário</option>
                                <option value="3">Avançado</option>
                            </select>
                            <select class="form-select mt-2 selectNivel" disabled aria-label="Nível de Espanhol" name="nivelEspanhol" id="nivelEspanhol" name="nivelEspanhol"">
                                <option selected value="0" disabled>Nível de Espanhol</option>
                                <option value="1">Básico</option>
                                <option value="2">Intermediário</option>
                                <option value="3">Avançado</option>
                            </select>
                            <select class="form-select mt-2 selectNivel" disabled aria-label="Nível de Francês" name="nivelFrances" id="nivelFrances" name="nivelFrances"">
                                <option selected value="0" disabled>Nível de Francês</option>
                                <option value="1">Básico</option>
                                <option value="2">Intermediário</option>
                                <option value="3">Avançado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/dashboard/escola/curriculos.js"></script>