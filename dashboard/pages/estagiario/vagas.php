<section class="sectionPages sectionPagesEstagiario" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/estagiario/vagas.css">
    <script src="../assets/js/dashboard/estagiario/vagas.js"></script>

    <h1 class="tituloPage mb-2">VAGAS</h1>

    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <div class="container text-center row d-flex align-items-center justify-content-center">
        <div class="col m-1">
            <div class="container-sm bg-light p-3 rounded">
                <ul class="nav nav-tabs d-flex flex-wrap-reverse">
                    <li class="nav-item">
                        <a class="nav-link active " aria-current="page" href="#">Todas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Minhas</a>
                    </li>
                    <li class="ms-auto">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Titulo, Cidade..."
                                aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                        </form>
                    </li>
                </ul>
                <div class="list-group mt-1 overflow-y-auto blocoVagas" id="listaVagas">
                    <!--vagas aparecem aqui-->
                </div>
                <nav aria-label="Page navigation" class="mt-3 mb-0 navPaginacao">
                    <ul class="pagination justify-content-center">
                        <li class="page-item pgVoltar">
                            <button class="page-link">Voltar</button>
                        </li>
                        <div class="page-item pgNumeros pagination d-flex flex-row">
                        </div>
                        <li class="page-item pgAvancar">
                            <button class="page-link">Avançar</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="card px-0 d-none" id="cardGeralVaga" style="width: 18rem;">
            <div class="card-header">
                <h5 class="card-title m-0" id="blocoTituloVaga">Titulo</h5>
            </div>
            <div class="card-body">
                <h6>Descrição:</h6>
                <p class="card-text" id="blocoDescricaoVaga">Descrição</p>
                <h6>Requisitos:</h6>
                <p class="card-text" id="blocoRequisitosVaga">Requisitos</p>
                <h6>Encerra:</h6>
                <p class="card-text" id="blocoencerramentoVaga">Encerramento</p>
                <h6>Publicado:</h6>
                <p class="card-text" id="blocoPublicacaoVaga">Publicação</p>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary sm btnVizualizarVaga" id="btnVizualizarVaga">Vizualizar</button>
            </div>
        </div>
    </div>

    <!-- Modal Vaga-->
    <div class="modal fade" id="modalVaga" data-bs-keyboard="false" tabindex="-1"  aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tituloVagaModal">Título</h1>
                    <button type="button" id="btnFecharModalVaga" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 for="descricaoVagaModal" class="form-label">Descrição:</h6>
                        <p id="descricaoVagaModal">Descrição</p>
                    </div>
                    <div class="mb-3">
                        <h6 for="requisitosVagaModal" class="form-label">Requisitos:</h6>
                        <p id="requisitosVagaModal">Requisitos</p>
                    </div>
                    <div class="mb-3">
                        <h6 for="dataEncerramentoVagaModal" class="form-label">Encerramento das inscrições:</h6>
                        <p id="dataEncerramentoVagaModal">00/00/0000</p>
                    </div>
                    <div class="mb-3">
                        <h6 for="dataPublicacaoVagaModal" class="form-label">Data de Publicação:</h6>
                        <p id="dataPublicacaoVagaModal">00/00/0000</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnModalCancelarVaga" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary inscreverVaga" id="inscreverVagaModal">Inscrever-se</button>
                </div>
            </div>
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