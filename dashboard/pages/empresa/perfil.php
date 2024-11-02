<section class="sectionPages sectionPagesEstagiario" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/perfil.css">
    <script src="../assets/js/dashboard/empresa/perfil.js"></script>

    <!-- Cabeçalho Fixo -->
    <div class="header text-center py-3 mb-4">
        <h1>PERFIL</h1>
    </div>

    <!-- Formulário de Edição de Perfil -->
    <div class="container">
        <!-- Card Dados Pessoais -->
        <form method="post" id="formDadosPessoais" class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Dados Empresariais</h4>
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
                    <label for="cnpj" class="form-label">CNPJ*</label>
                    <input type="text" id="cnpj" name="cnpj" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="area_atuacao" class="form-label">Área de atuação*</label>
                    <input type="text" id="area_atuacao" name="area_atuacao" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="descricao" class="form-label">Descrição*</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" disabled required>
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
                    <label for="telefone" class="form-label">Telefone*</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" disabled maxlength="15">
                </div>
            </div>
            <div class="card-body row g-3">
                <p class="text-dark text-start mb-0 mt-0 ms-1">Redes sociais:</p>
                <div class="col mt-1">
                    <div class="input-group  m-1"><!--WEBSITE-->
                        <span class="input-group-text" id="websiteSpan"><i class="bi bi-globe2"></i></span>
                        <input type="text" class="form-control" id="website" placeholder="Website" aria-label="Website" aria-describedby="Website-link" maxlength="100" name="website" disabled>
                    </div>
                    <div class="input-group  m-1"><!--LINKEDIN-->
                        <span class="input-group-text" id="linkedinSpan"><i class="bi bi-linkedin"></i></span>
                        <input type="text" class="form-control" id="linkedin" placeholder="Linkedin" aria-label="Linkedin" aria-describedby="Linkedin-link" maxlength="100" name="linkedin" disabled>
                    </div>
                </div>
                <div class="col  mt-1">
                    <div class="input-group  m-1"><!--INSTAGRAM-->
                        <span class="input-group-text" id="instagramSpan"><i class="bi bi-instagram"></i></span>
                        <input type="text" class="form-control" id="instagram" placeholder="Instagram" aria-label="Instagram" aria-describedby="Instagram-link" maxlength="100" name="instagram" disabled>
                    </div>
                    <div class="input-group  m-1"><!--FACEBOOK-->
                        <span class="input-group-text" id="facebookSpan"><i class="bi bi-facebook"></i></span>
                        <input type="text" class="form-control" id="facebook" placeholder="Facebook" aria-label="Facebook" aria-describedby="Facebook-link" maxlength="100" name="facebook" disabled>
                    </div>
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

        <!-- Card Responsável -->
        <form method="post" id="formResponsavel" class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Responsável</h4>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-light">Editar</button>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="nome_responsavel" class="form-label">Nome*</label>
                    <input type="text" id="nome_responsavel" name="nome_responsavel" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="email_responsavel" class="form-label">Email*</label>
                    <input type="text" id="email_responsavel" name="email_responsavel" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="telefone_responsavel" class="form-label">Telefone*</label>
                    <input type="text" id="telefone_responsavel" name="telefone_responsavel" class="form-control" disabled required>
                </div>
                <div class="col-md-6">
                    <label for="cargo_responsavel" class="form-label">Cargo*</label>
                    <input type="text" id="cargo_responsavel" name="cargo_responsavel" class="form-control" disabled required>
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