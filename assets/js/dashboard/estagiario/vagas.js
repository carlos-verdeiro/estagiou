$(document).ready(function () {

    let vagasJson = null;
    const listaVagas = $('#listaVagas');
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

    function formatarData(data) {
        // Verifica se a data é válida
        if (!data) return 'Não programado';

        // Dividir a data e hora
        const partes = data.split(' ');
        const [ano, mes, dia] = partes[0].split('-');
        //const hora = partes[1].substring(0, 5);

        // Formatar a data como DD/MM/AAAA
        return `${dia}/${mes}/${ano}`;
    }

    function puxarVagas() {
        $.getJSON('../../server/api/vagas/mostrarVaga.php/estagiarioVagas')
            .done(function (data) {
                vagasJson = data;
                console.log(vagasJson);
                listaVagas.empty();
                if (data.length === 0) {
                    listaVagas.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    data.forEach((vaga, index) => {
                        const dataEncerramento = vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado';
                        listaVagas.append(`
                            <button class="list-group-item list-group-item-action p-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${vaga.titulo}</h5>
                                    <small>Publicado: ${formatarData(vaga.data_publicacao)}</small>
                                </div>
                                <p class="mt-1 mb-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore asperiores maxime nemo blanditiis ad temporibus earum, alias aspernatur voluptates suscipit incidunt at ipsa et. Culpa molestias iure atque error fugit!</p>
                            </button>`);
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${jqXHR}`);
                toastInformacao.show();
                console.log(errorThrown);
            });
    }

    // Inicializa as vagas
    puxarVagas();




});
