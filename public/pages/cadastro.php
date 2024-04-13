<section id="sectionCadastro">
    <link rel="stylesheet" href="assets/css/index/cadastro.css">
    <div class="divCadastro" id="cadastro1">
        <h1 id='tituloCadastro'>CADASTRO</h1>
        <div class="formComponent p-4">
            <div class="progress w-75" role="progressbar" aria-label="Example with label" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%">0%</div>
            </div>
            <span class="spanPreencha">*Preencha com atenção*</span>
            <div class="divInputs d-flex flex-wrap w-100">
                <div class="form-floating m-1">
                    <input type="text" id="nome" class="form-control form-control-lg w-100" placeholder="Nome"
                        aria-label="Nome">
                    <label for="nome">Nome</label>
                    <div class="invalid-feedback">
                        Preencha corretamente!
                    </div>
                </div>
                <div class="form-floating m-1">
                    <input type="text" id="sobrenome" class="form-control form-control-lg w-100" placeholder="Sobrenome"
                        aria-label="Sobrenome">
                    <label for="sobrenome">Sobrenome</label>
                    <div class="invalid-feedback">
                        Preencha corretamente!
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success btnProximo btn-lg w-50">PRÓXIMO</button>
        </div>
    </div>
</section>