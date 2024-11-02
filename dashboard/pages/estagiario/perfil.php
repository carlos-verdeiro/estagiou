<section class="sectionPages sectionPagesEstagiario" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/perfil.css">
    <script src="../assets/js/dashboard/estagiario/perfil.js"></script>

    <!-- Cabeçalho Fixo -->
    <div class="header text-center py-3 mb-4">
        <h1>Editar Perfil</h1>
    </div>

    <!-- Formulário de Edição de Perfil -->
    <form id="formEdicaoPerfil" method="post" action="/path/to/submit" class="container">

        <!-- Card Dados Pessoais -->
        <div class="card mb-3">
            <div class="card-header bg-secondary text-white m-0 row">
                <h4 class="col">Dados Pessoais</h4>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-light">Editar</button>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome*</label>
                    <input type="text" id="nome" name="nome" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="sobrenome" class="form-label">Sobrenome</label>
                    <input type="text" id="sobrenome" name="sobrenome" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="estado_civil" class="form-label">Estado Civil*</label>
                    <input type="text" id="estado_civil" name="estado_civil" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="cpf" class="form-label">CPF*</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="rg" class="form-label">RG*</label>
                    <input type="text" id="rg" name="rg" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="data_nascimento" class="form-label">Data de Nascimento*</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="genero" class="form-label">Gênero*</label>
                    <input type="text" id="genero" name="genero" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="nacionalidade" class="form-label">Nacionalidade*</label>
                    <input type="text" id="nacionalidade" name="nacionalidade" class="form-control" disabled>
                </div>
            </div>
        </div>

        <!-- Card Contato -->
        <div class="card mb-3">
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
                    <input type="tel" id="celular" name="celular" class="form-control" disabled>
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" disabled>
                </div>
            </div>
        </div>

        <!-- Card Endereço -->
        <div class="card mb-3">
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
                    <input type="text" id="estado" name="estado" class="form-control" disabled>
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
        </div>
    </form>

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