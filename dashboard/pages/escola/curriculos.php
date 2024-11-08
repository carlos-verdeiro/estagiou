<!-- Section para o cadastro de alunos -->
<section class="sectionPages">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cadastro de Alunos</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Alunos Cadastrados</h5>
            <!-- Botão para adicionar novo aluno -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#alunoModal">
                Adicionar Novo Aluno
            </button>
        </div>

        <!-- Lista de alunos em cards -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nome do Aluno</h5>
                        <p class="card-text">Curso: Informática</p>
                        <p class="card-text">Período: 2º Ano</p>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#alunoModal">
                            Editar
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repita o card acima para cada aluno -->
        </div>
    </div>
</section>

<!-- Modal para cadastro e edição de aluno -->
<div class="modal fade" id="alunoModal" tabindex="-1" aria-labelledby="alunoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alunoModalLabel">Cadastrar Novo Aluno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <!-- Informações Pessoais -->
                    <h6>Informações Pessoais</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nomeAluno" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeAluno" required>
                        </div>
                        <div class="col-md-6">
                            <label for="sobrenomeAluno" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenomeAluno">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estadoCivil" class="form-label">Estado Civil</label>
                            <input type="text" class="form-control" id="estadoCivil" required>
                        </div>
                        <div class="col-md-6">
                            <label for="genero" class="form-label">Gênero</label>
                            <input type="text" class="form-control" id="genero" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control" id="rg" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rgOrgEmissor" class="form-label">Órgão Emissor do RG</label>
                            <input type="text" class="form-control" id="rgOrgEmissor" required>
                        </div>
                        <div class="col-md-6">
                            <label for="rgEstadoEmissor" class="form-label">Estado Emissor do RG</label>
                            <input type="text" class="form-control" id="rgEstadoEmissor" maxlength="2" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="dataNascimento" required>
                    </div>

                    <!-- Contato -->
                    <h6>Contato</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone">
                        </div>
                        <div class="col-md-6">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="celular" required>
                        </div>
                    </div>

                    <!-- Endereço -->
                    <h6>Endereço</h6>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" required>
                        </div>
                        <div class="col-md-4">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento">
                        </div>
                        <div class="col-md-6">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" required>
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="pais" class="form-label">País</label>
                        <input type="text" class="form-control" id="pais" required>
                    </div>

                    <!-- Informações Adicionais -->
                    <h6>Informações Adicionais</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nacionalidade" class="form-label">Nacionalidade</label>
                            <input type="text" class="form-control" id="nacionalidade" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dependentes" class="form-label">Dependentes</label>
                            <input type="number" class="form-control" id="dependentes" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cnh" class="form-label">CNH</label>
                        <input type="text" class="form-control" id="cnh">
                    </div>
                    <div class="mb-3">
                        <label for="nomeSocial" class="form-label">Nome Social</label>
                        <input type="text" class="form-control" id="nomeSocial">
                    </div>
                    <div class="mb-3">
                        <label for="disponibilidade" class="form-label">Disponibilidade</label>
                        <input type="text" class="form-control" id="disponibilidade">
                    </div>

                    <!-- Escolaridade e Habilidades -->
                    <h6>Escolaridade e Habilidades</h6>
                    <div class="mb-3">
                        <label for="escolaridade" class="form-label">Escolaridade</label>
                        <input type="number" class="form-control" id="escolaridade">
                    </div>
                    <div class="mb-3">
                        <label for="formacoes" class="form-label">Formações</label>
                        <textarea class="form-control" id="formacoes" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="experiencias" class="form-label">Experiências</label>
                        <textarea class="form-control" id="experiencias" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="certificacoes" class="form-label">Certificações</label>
                        <textarea class="form-control" id="certificacoes" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="habilidades" class="form-label">Habilidades</label>
                        <textarea class="form-control" id="habilidades" rows="3"></textarea>
                    </div>

                    <!-- Proficiência em Línguas -->
                    <h6>Proficiência em Línguas</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="proIngles" class="form-label">Inglês</label>
                            <input type="number" class="form-control" id="proIngles">
                        </div>
                        <div class="col-md-4">
                            <label for="proEspanhol" class="form-label">Espanhol</label>
                            <input type="number" class="form-control" id="proEspanhol">
                        </div>
                        <div class="col-md-4">
                            <label for="proFrances" class="form-label">Francês</label>
                            <input type="number" class="form-control" id="proFrances">
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