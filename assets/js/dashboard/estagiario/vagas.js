$(document).ready(function () {

    const listaVagas = $('#listaVagas');
    const blocoVagas = $('.blocoVagas');
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');


    //global
    let vagasJson;
    let totalRegistros;
    let pagAtual;

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

    function paginacao(totalRegistros) {
        //controle de paginacao
        if (totalRegistros / 30 > 1) {
            $('.pgNumeros').empty();
            let paginas = Math.ceil(totalRegistros / 30);
            for (let i = 1; i <= paginas; i++) {
                if (i == 1) {
                    $('.pgNumeros').append(`<li class=" pgNum" value="${i}"><button class="page-link pgNumBTN" id="pgNumPrimeiro" value="${i}">${i}</button></li>`);
                } else if (i == paginas) {
                    $('.pgNumeros').append(`<li class=" pgNum" value="${i}"><button class="page-link pgNumBTN" id="pgNumUltimo" value="${i}">${i}</button></li>`);
                } else {
                    $('.pgNumeros').append(`<li class=" pgNum" value="${i}"><button class="page-link pgNumBTN" value="${i}">${i}</button></li>`);
                }
            }
            $('#pgNumPrimeiro').addClass('active');
            if (!$('.pgVoltar').hasClass('disabled')) {
                $('.pgVoltar').addClass('disabled');
            }
            paginaAtual = 1;
        } else {
            if (!$('.navPaginacao').hasClass('invisible')) {
                $('.navPaginacao').addClass('invisible');
            }
        }
    }

    function puxarVagas(inicio) {
        $.getJSON(`../../server/api/vagas/mostrarVaga.php/estagiarioVagas/${inicio}`)
            .done(function (data) {
                // Assumindo que o JSON retornado tem 'total_registros' e 'vagas'
                vagasJson = data.vagas;
                totalRegistros = data.total_registros;

                console.log(`Total de registros: ${totalRegistros}`);
                console.log(vagasJson);

                if (inicio == 0) {
                    paginacao(totalRegistros);
                }

                // Limpa a lista de vagas antes de adicionar novos itens
                listaVagas.empty();
                // adicionar vagas
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
                            </button>`);
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                // Mostrar mensagem de erro
                corpoToastInformacao.text(`Erro ao obter os dados: ${textStatus}`);
                toastInformacao.show();
                console.log(errorThrown);
            });
    }


    // Inicializa as vagas
    puxarVagas(0);
    pagAtual = 1;


    $('.pgNumeros').on('click', '.pgNumBTN', function () {
        if (!$(this).hasClass('active')) {
            $('.pgNumBTN').removeClass('active');
            $('.page-item').removeClass('disabled');
            $(this).addClass('active');
            puxarVagas(30 * ($(this).val() - 1));
            if ($(this).val() == 1) {
                $('.pgVoltar').addClass('disabled');
            } else if ($(this).val() == Math.ceil(totalRegistros / 30)) {
                $('.pgAvancar').addClass('disabled');
            }
            pagAtual = $(this).val();
        }
    });


    $('.pgVoltar').click(function () {
        //voltarBTN
    });

    blocoVagas.on('click', '.btnVaga', function () {
        const vagaVizualizar = vagasJson[$(this).val()];
        console.log(vagaVizualizar);

    });


});
