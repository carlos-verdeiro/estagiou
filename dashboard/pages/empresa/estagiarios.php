<section class="container h-100">
    <h2 class="text-center mb-4">Estagiários Contratados</h2>

    <!-- Filtro de busca -->
    <div class="row mb-4">
        <div class="col-md-8">
            <input type="text" class="form-control" id="searchInput" placeholder="Buscar estagiário por nome...">
        </div>
        <div class="col-md-4 text-right">
            <button class="btn btn-primary">Filtrar</button>
        </div>
    </div>

    <!-- Tabela de estagiários -->
    <table class="table table-striped table-bordered ">
        <thead class="thead-dark ">
            <tr>
                <th>Nome</th>
                <th>Vaga</th>
                <th>Data de Contratação</th>
                <th>Contato</th>
            </tr>
        </thead>
        <tbody id="estagiariosTable">
            <!-- Exemplo de linha (será populado dinamicamente no back-end) -->
            <tr>
                <td>João Silva</td>
                <td>Desenvolvedor Front-end</td>
                <td>01/10/2023</td>
                <td>joao.silva@email.com</td>
            </tr>
            <tr>
                <td>Maria Souza</td>
                <td>Designer Gráfico</td>
                <td>15/09/2023</td>
                <td>maria.souza@email.com</td>
            </tr>
            <!-- Adicione mais linhas aqui conforme necessário -->
        </tbody>
    </table>

    <!-- Paginação (opcional) -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
        </ul>
    </nav>
</section>