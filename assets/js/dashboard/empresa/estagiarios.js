$(document).ready(function () {
    const main = $('#principal');

    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');


    function puxarEstagiarios() {
        $.getJSON('../../server/api/estagiarios/mostrarEstagiarios.php/estagiarios')
            .done(function (data) {
                main.empty();
                if (data.length === 0) {
                    main.append('<h3 class="text-center">Não há estagiários contratados</h3>');
                } else {
                    main.append(`
                    <div class="row mb-4">
                        <div class="col-md-8">
                                <input type="text" class="form-control" id="searchInput" placeholder="Buscar estagiário por nome...">
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark ">
                                <tr>
                                    <th>Nome</th>
                                    <th>Vaga</th>
                                    <th>Data de Contratação</th>
                                    <th>Contato</th>
                                </tr>
                            </thead>
                            <tbody id="estagiariosTable">
                    `);
                    data.forEach((estagiario, index) => {
                        blocosVagas.append(`
                        <tr>
                            <td>${data.nome}</td>
                            <td>${data.vaga}</td>
                            <td>${data.data_contratacao}</td>
                            <td>${data.email}</td>
                        </tr>
                    `);
                    });
                }
                main.append(`
                        </tbody>
                </table>
                <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                </ul>
            </nav>
                `);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error(errorThrown);
            });
    }




    puxarEstagiarios();
});