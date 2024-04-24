<section id="sectionCadastro">
    <link rel="stylesheet" href="assets/css/index/cadastro.css">
    <script src="assets/js/cadastro.js"></script>
    <div class="divCadastro" id="cadastro">
        <h1 id='tituloCadastro'>CADASTRO</h1>
        <div class="formComponent p-4">
            <div class="progress w-75" role="progressbar" aria-label="Example with label" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 0%">0%</div>
            </div>
            <span class="spanPreencha">*Preencha com atenção*</span>
            <div class="divInputs d-flex flex-wrap w-100">
                <?php
                include_once "tipoPessoa.php";
                ?>
            </div>
        </div>
    </div>
</section>