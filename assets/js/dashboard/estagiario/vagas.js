$(document).ready(function () {
    const listaVagas = $('#listaVagas');
    const blocoVagas = $('.blocoVagas');
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    // Variáveis globais
    let vagasJson = [];
    let totalRegistros = 0;
    let paginaAtual = 1;

    function formatarData(data) {
        if (!data) return 'Não programado';
        const [ano, mes, dia] = data.split(' ')[0].split('-');
        return `${dia}/${mes}/${ano}`;
    }

    function paginacao(totalRegistros) {
        const paginas = Math.ceil(totalRegistros / 30);
        if (paginas > 1) {
            $('.pgNumeros').empty();
            for (let i = 1; i <= paginas; i++) {
                const activeClass = i === 1 ? 'active' : '';
                $('.pgNumeros').append(
                    `<li class="pgNum" value="${i}">
                        <button class="page-link pgNumBTN ${activeClass}" id="pgNum${i}" value="${i}">${i}</button>
                    </li>`
                );
            }
            $('.pgVoltar').toggleClass('disabled', true);
        } else {
            $('.navPaginacao').addClass('invisible');
        }
    }

    function ativaBtnAvanco(pagina) {
        $('.pgVoltar, .pgAvancar').removeClass('disabled');
        if (pagina === 1) {
            $('.pgVoltar').addClass('disabled');
        }
        if (pagina === Math.ceil(totalRegistros / 30)) {
            $('.pgAvancar').addClass('disabled');
        }

        // Atualiza o estado do botão "active"
        $('.pgNumBTN').removeClass('active');
        $(`#pgNum${pagina}`).addClass('active');
    }

    function puxarVagas(inicio) {
        $.getJSON(`../../server/api/vagas/mostrarVaga.php/estagiarioVagas/${inicio}`)
            .done(function (data) {
                vagasJson = data.vagas || [];
                totalRegistros = data.total_registros || 0;
                console.log(`Total de registros: ${totalRegistros}`, vagasJson);

                if (inicio === 0) {
                    paginacao(totalRegistros);
                }

                listaVagas.empty();
                if (vagasJson.length === 0) {
                    listaVagas.append('<h3 class="text-center">Não há vagas cadastradas</h3>');
                } else {
                    vagasJson.forEach((vaga, index) => {
                        const dataEncerramento = vaga.data_encerramento ? formatarData(vaga.data_encerramento) : 'Não programado';
                        listaVagas.append(`
                            <button class="list-group-item btnVaga list-group-item-action p-3" value="${index}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${vaga.titulo}</h5>
                                    <small>Publicado: ${formatarData(vaga.data_publicacao)}</small>
                                </div>
                                <p class="mt-1 mb-1">${vaga.descricao}</p>
                                <small>Encerramento: ${dataEncerramento}</small>
                            </button>
                        `);
                    });
                }
            })
            .fail(function (jqXHR, textStatus) {
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.error('Erro ao obter os dados:', textStatus);
            });
    }

    // Inicializa as vagas
    puxarVagas(0);

    $('.pgNumeros').on('click', '.pgNumBTN', function () {
        if (!$(this).hasClass('active')) {
            const novaPagina = parseInt($(this).val(), 10);
            ativaBtnAvanco(novaPagina);
            paginaAtual = novaPagina;
            puxarVagas(30 * (paginaAtual - 1));
            $('#listaVagas').scrollTop(0);
        }
    });

    $('.pgVoltar').click(function () {
        if (paginaAtual > 1) {
            paginaAtual--;
            ativaBtnAvanco(paginaAtual);
            puxarVagas(30 * (paginaAtual - 1));
            $('#listaVagas').scrollTop(0);
        }
    });

    $('.pgAvancar').click(function () {
        if (paginaAtual < Math.ceil(totalRegistros / 30)) {
            paginaAtual++;
            ativaBtnAvanco(paginaAtual);
            puxarVagas(30 * (paginaAtual - 1));
            $('#listaVagas').scrollTop(0);
        }
    });

    blocoVagas.on('click', '.btnVaga', function () {
        const vagaVizualizar = vagasJson[$(this).val()];
        console.log(vagaVizualizar);
        // Adicione lógica para exibir detalhes da vaga, se necessário
    });
});
