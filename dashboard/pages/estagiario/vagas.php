<section class="sectionPages sectionPagesEstagiario" id="sectionPageVagas">
    <link rel="stylesheet" href="../assets/css/dashboard/estagiario/vagas.css">
    <script src="../assets/js/dashboard/estagiario/vagas.js"></script>

    <h1 class="tituloPage mb-2">VAGAS</h1>

    <div class="text-center" id="overlay">
        <div class="spinner-border text-light" id="loading" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <div class="container text-center row d-flex align-items-start justify-content-center">
        <div class="col m-1">
            <div class="container-sm bg-light p-3 rounded">
                <ul class="nav nav-tabs d-flex flex-wrap-reverse">
                    <li class="nav-item">
                        <button class="nav-link active navPage" aria-current="page" id="navPageTodas">Buscar</button>
                    </li>
                    <?php
                    session_start();
                    include_once '../../../server/conexao.php';

                    $stmt = $conn->prepare("SELECT COUNT(*) FROM aluno WHERE id_estagiario = ?");
                    $stmt->bind_param('i', $_SESSION['idUsuarioLogin']);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    $row = $result->fetch_row();
                    $count = $row[0];

                    if ($count > 0) {
                        echo '<li class="nav-item">
                        <button class="nav-link navPage" aria-current="page" id="navIndicacoes">Indicações</button>
                    </li>';
                    }

                    // Fecha a conexão
                    $stmt->close();
                    $conn->close();
                    ?>

                    <li class="nav-item">
                        <button class="nav-link navPage" aria-current="page" id="navPageMinhas">Inscrito</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link navPage" aria-current="page" id="navPageContratado">Contratado</button>
                    </li>
                    <!--<li class="ms-auto">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Titulo, Cidade..."
                                aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                        </form>
                    </li>-->
                </ul>
                <div class="list-group mt-1 overflow-y-auto blocoVagas" id="listaVagas">

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
    <div class="modal fade" id="modalVaga" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <p id="dataEncerramentoVagaModal">--/--/----</p>
                    </div>
                    <div class="mb-3">
                        <h6 for="dataPublicacaoVagaModal" class="form-label">Data de Publicação:</h6>
                        <p id="dataPublicacaoVagaModal">--/--/----</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnModalCancelarVaga" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary inscreverVaga" id="inscreverVagaModal">Inscrever-se</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal contrato -->
    <div class="modal fade " id="modalContrato" aria-hidden="true" aria-labelledby="modalContrato" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h2 class="modal-title fs-4 fw-bold user-select-all" id="modalContratoTitulo">Contrato</h2>
                    <button type="button" class="btn-close btn-close-white" data-bs-target="#modalContrato" data-bs-toggle="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <!-- info estagiario -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Vaga:</h5>
                                <p id="modalEstagiarioVaga" class=" user-select-all">vaga</p>
                            </div>
                           
                        </div>

                        <!-- Data Contratacao -->
                        <div class="row mb-3" id="modalEstagiarioDatas">
                            <div class="col-12">
                                <h5 class="fw-bold">Data de contratação:</h5>
                                <p id="modalEstagiarioDataContratacao">contratacao</p>
                            </div>
                            <div class="col-12">
                                <h5 class="fw-bold">Fim de contrato:</h5>
                                <p id="modalEstagiarioFimContrato">fim contratacao</p>
                            </div>
                        </div>

                        <!-- Observacoes -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5 class="fw-bold">Observações:</h5>
                                <p id="modalEstagiarioObservacoes">Observações</p>
                            </div>
                        </div>

                        <!-- Currículo -->
                        <div class="row" id="modalEstagiarioContratoGeral">
                            <div class="col-12">
                                <iframe id="modalEstagiarioContrato" class="rounded border" frameborder="0" style="height: 80vh; max-height: 600px; width: 100%;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
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