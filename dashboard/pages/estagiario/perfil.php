<section class="sectionPages sectionPagesEstagiario" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/perfil.css">
    <script src="../assets/js/dashboard/estagiario/perfil.js"></script>

    <!-- Cabeçalho Fixo -->
    <div class="header text-center py-3 mb-4">
        <h1>PERFIL</h1>
    </div>

    <!-- Formulário de Edição de Perfil -->
    <div class="container">
        <!-- Card Dados Pessoais -->
        <form method="post" id="formDadosPessoais" class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Dados Pessoais</h4>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-light">Editar</button>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome*</label>
                    <input type="text" id="nome" name="nome" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="sobrenome" class="form-label">Sobrenome</label>
                    <input type="text" id="sobrenome" name="sobrenome" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="estado_civil" class="form-label">Estado Civil*</label>
                    <select id="estado_civil" class="form-select w-100" placeholder="Estado Civil" aria-label="Estado Civil" name="estado_civil" disabled required>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="separado">Separado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Viúvo(a)</option>

                    </select>
                </div>
                <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF*</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" disabled required maxlength="14">
                </div>
                <div class="col-md-6">
                    <label for="rg" class="form-label">RG*</label>
                    <input type="text" id="rg" name="rg" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="data_nascimento" class="form-label">Data de Nascimento*</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="genero" class="form-label">Gênero*</label>
                    <select id="genero" class="form-select w-100" placeholder="Gênero" aria-label="Gênero" name="genero" disabled required>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                        <option value="O">Outros</option>

                    </select>
                </div>
                <div class="col-md-6">
                    <label for="nacionalidade" class="form-label">Nacionalidade*</label>
                    <input type="text" id="nacionalidade" list="listaNacionalidade" name="nacionalidade" class="form-control" disabled required>
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
                </div>
            </div>
        </form>

        <!-- Card Contato -->
        <form method="post" id="formContato" class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Contato</h4>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-light">Editar</button>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" id="email" name="email" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="celular" class="form-label">Celular*</label>
                    <input type="tel" id="celular" name="celular" class="form-control" disabled maxlength="15">
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" disabled maxlength="14">
                </div>
            </div>
        </form>

        <!-- Card Endereço -->
        <form method="post" id="formEndereco" class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Endereço</h4>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-light">Editar</button>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="endereco" class="form-label">Endereço*</label>
                    <input type="text" id="endereco" name="endereco" class="form-control" disabled>
                </div>
                <div class="col-md-3">
                    <label for="numero" class="form-label">Número*</label>
                    <input type="text" id="numero" name="numero" class="form-control" disabled>
                </div>
                <div class="col-md-3">
                    <label for="complemento" class="form-label">Complemento</label>
                    <input type="text" id="complemento" name="complemento" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="bairro" class="form-label">Bairro*</label>
                    <input type="text" id="bairro" name="bairro" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="cidade" class="form-label">Cidade*</label>
                    <input type="text" id="cidade" name="cidade" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label">Estado*</label>
                    <select id="estado" class="form-select w-100" aria-label="Estado" name="estado" disabled>
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
                </div>
                <div class="col-md-6">
                    <label for="cep" class="form-label">CEP*</label>
                    <input type="text" id="cep" name="cep" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="pais" class="form-label">País*</label>
                    <input type="text" id="pais" name="pais" class="form-control" disabled>
                </div>
            </div>
        </form>

        <!-- Card Troca de Senha -->
        <form method="post" id="formTrocaSenha" class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Troca de Senha</h4>
                <div class="col d-flex justify-content-end">
                    <button type="submit" class="btn btn-light">Alterar Senha</button>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="senha_atual" class="form-label">Senha Atual*</label>
                    <input type="password" id="senha_atual" name="senha_atual" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="nova_senha" class="form-label">Nova Senha*</label>
                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" required>
                    <div class="invalid-feedback" id="feedback-senha">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="confirma_senha" class="form-label">Confirme a Nova Senha*</label>
                    <input type="password" id="confirma_senha" name="confirma_senha" class="form-control" required>
                    <div class="invalid-feedback" id="feedback-confirmacaoSenha">
                        Preencha corretamente!
                    </div>
                </div>
            </div>
        </form>

    </div>

    <!-- Toast de Informação -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="toastInformacao" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Estagiou</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="corpoToastInformacao">
                Perfil atualizado com sucesso!
            </div>
        </div>
    </div>
</section>