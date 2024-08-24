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
                            <input class="form-control me-2" type="search" placeholder="Titulo, Cidade..." aria-label="Search">
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
        <div class="card px-0" style="width: 18rem;">
            <div class="card-header">
                <h5 class="card-title m-0">${vaga.titulo}</h5>
            </div>
            <div class="card-body">
                <h6>Descrição:</h6>
                <p class="card-text">${vaga.descricao}</p>
                <h6>Requisitos:</h6>
                <p class="card-text">${vaga.requisitos}</p>
                <h6>Encerra:</h6>
                <p class="card-text">${dataEncerramento}</p>
                <h6>Publicado:</h6>
                <p class="card-text">${formatarData(vaga.data_publicacao)}</p>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary sm btnVizualizar" value="${index}">Vizualizar</button>
                <button type="button" class="btn btn-warning sm btnEditar" value="${index}">Editar</button>
                <button type="button" class="btn btn-danger sm btnEncerrar" value="${index}" data-bs-toggle="modal" data-bs-target="#modalEncerrar">Encerrar</button>
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