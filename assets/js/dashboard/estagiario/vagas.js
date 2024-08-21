$(document).ready(function () {

    let vagasJson = null;
    const blocosVagas = $('.blocosVagas');
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

    function formatarData(data) {
        // Verifica se a data é válida
        if (!data) return 'Não programado';

        // Dividir a data e hora
        const partes = data.split(' ');
        const [ano, mes, dia] = partes[0].split('-');
        const hora = partes[1].substring(0, 5);

        // Formatar a data como DD/MM/AAAA
        return `${dia}/${mes}/${ano} ${hora}`;
    }

    function puxarVagas() {
        $.getJSON('../../server/api/vagas/mostrarVaga.php/estagiarioVagas')
            .done(function (data) {
                vagasJson = data;
                console.log(vagasJson);
                blocosVagas.empty();
                if (data.length === 0) {
                    blocosVagas.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    data.forEach((vaga, index) => {
                        const dataEncerramento = vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado';
                        blocosVagas.append(`
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
                            </div>`);
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
