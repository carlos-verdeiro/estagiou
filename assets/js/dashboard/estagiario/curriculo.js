$(document).ready(function () {
    let jsonInfo = null;

    // Elementos do DOM
    const divArquivo = $('.arquivo');
    const iframeArquivo = $('#iframeArquivo');
    const btnExcluir = $('#btnExcluir');
    const curriculo = $('#curriculo');
    const observacoes = $('#observacoes');
    const btnModalExcluir = $('#btnModalExcluir');
    const divInformacoes = $('#divInformacoes');
    const resNomeArquivo = $('#resNomeArquivo');
    const resSubmissao = $('#resSubmissao');
    const resObservacoes = $('#resObservacoes');
    const toastInformacao = new bootstrap.Toast($('#toastInformacao')[0]);
    const corpoToastInformacao = $('#corpoToastInformacao');

    // Função para converter data
    function converterData(data) {
        var partes = data.split('-');
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }

    function verificarMudancas() {
        if (!jsonInfo) return;

        function normalizarTexto(texto) {
            if (typeof texto === 'string') {
                return texto.trim().replace(/\s+/g, ' ');
            } else if (texto != null) {
                // Convert non-string input to a string
                return String(texto).trim().replace(/\s+/g, ' ');
            } else {
                // Handle cases where texto is null or undefined
                return '';
            }
        }


        $('input, select, textarea').each(function () {
            switch ($(this).attr('name')) {
                case 'escolaridade':
                case 'formacao':
                    if (normalizarTexto($('input[name="escolaridade"]:checked').val()) != normalizarTexto(jsonInfo.escolaridade) ||
                        normalizarTexto($('#formacao').val()) != normalizarTexto(jsonInfo.formacoes)) {
                        $('#btnAcorFormacao').addClass('bg-warning-subtle');
                    } else {
                        $('#btnAcorFormacao').removeClass('bg-warning-subtle');
                    }
                    break;

                case 'experiencias':
                    if (normalizarTexto($('#experiencias').val()) != normalizarTexto(jsonInfo.experiencias)) {
                        $('#btnAcorExperiencias').addClass('bg-warning-subtle');
                    } else {
                        $('#btnAcorExperiencias').removeClass('bg-warning-subtle');
                    }
                    break;

                case 'idiomaIngles':
                case 'idiomaEspanhol':
                case 'idiomaFrances':
                case 'nivelIngles':
                case 'nivelEspanhol':
                case 'nivelFrances':
                    const isInglesSelected = $('#idiomaIngles').is(':checked');
                    const isEspanholSelected = $('#idiomaEspanhol').is(':checked');
                    const isFrancesSelected = $('#idiomaFrances').is(':checked');

                    const nivelIngles = isInglesSelected ? $('#nivelIngles').val() : 0;
                    const nivelEspanhol = isEspanholSelected ? $('#nivelEspanhol').val() : 0;
                    const nivelFrances = isFrancesSelected ? $('#nivelFrances').val() : 0;

                    if ((nivelIngles != jsonInfo.proIngles) ||
                        (nivelEspanhol != jsonInfo.proEspanhol) ||
                        (nivelFrances != jsonInfo.proFrances)) {
                        $('#btnAcorIdiomas').addClass('bg-warning-subtle');
                    } else {
                        $('#btnAcorIdiomas').removeClass('bg-warning-subtle');
                    }
                    break;

                case 'certificacoes':
                    if (normalizarTexto($('#certificacoes').val()) != normalizarTexto(jsonInfo.certificacoes)) {
                        $('#btnAcorCertificacoes').addClass('bg-warning-subtle');
                    } else {
                        $('#btnAcorCertificacoes').removeClass('bg-warning-subtle');
                    }
                    break;

                case 'habilidades':
                    if (normalizarTexto($('#habilidades').val()) != normalizarTexto(jsonInfo.habilidades)) {
                        $('#btnAcorHabilidades').addClass('bg-warning-subtle');
                    } else {
                        $('#btnAcorHabilidades').removeClass('bg-warning-subtle');
                    }
                    break;

                case 'integral':
                case 'meio':
                case 'remoto':
                case 'presencial':
                    const selecionados = ['integral', 'meio', 'remoto', 'presencial']
                        .filter(tipo => $(`#${tipo}`).is(':checked'));

                    const valoresSelecionados = selecionados.join('/');
                    if (valoresSelecionados != jsonInfo.disponibilidade) {
                        $('#btnAcorDisponibilidade').addClass('bg-warning-subtle');
                    } else {
                        $('#btnAcorDisponibilidade').removeClass('bg-warning-subtle');
                    }
                    break;
                default:
                    break;
            }
        });
    }


    // Função para puxar arquivo
    function puxarArquivo() {
        $.ajax({
            url: '../server/api/curriculos/downloadCurriculo.php',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    divArquivo.removeClass('visually-hidden');
                    divInformacoes.removeClass('visually-hidden').addClass('w-100');
                    iframeArquivo.attr('src', '../server/curriculos/' + response.file);
                    btnExcluir.removeClass('disabled');
                    resNomeArquivo.text(response.nome);
                    resSubmissao.text(converterData(response.data_submissao));
                    resObservacoes.text(response.observacoes);
                } else if (response.status === 'notFound') {
                    divArquivo.addClass('visually-hidden');
                    divInformacoes.removeClass('w-100').addClass('visually-hidden');
                    btnExcluir.addClass('disabled');
                } else {
                    corpoToastInformacao.text('Erro ao gerar o PDF.');
                    toastInformacao.show();
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição:', error);
            }
        });
    }

    // Função para puxar informações
    function puxarInfo() {
        $.ajax({
            url: `../server/api/curriculos/puxarInfo.php`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                jsonInfo = response.data;
                console.table(response.data);
                //1
                $(`#escolaridade${response.data.escolaridade}`).prop('checked', true);
                $(`#formacao`).text(response.data.formacoes);

                //2
                $(`#experiencias`).text(response.data.experiencias);

                //3
                if (response.data.proIngles != null && response.data.proIngles != 0) { // inglês
                    $(`#idiomaIngles`).prop('checked', true);
                    $(`#nivelIngles`).val(response.data.proIngles);
                    $(`#nivelIngles`).prop('disabled', false);
                } else {
                    $(`#idiomaIngles`).prop('checked', false);
                    $(`#nivelIngles`).val(0);
                    $(`#nivelIngles`).prop('disabled', true);
                }

                if (response.data.proEspanhol != null && response.data.proEspanhol != 0) { // espanhol
                    $(`#idiomaEspanhol`).prop('checked', true);
                    $(`#nivelEspanhol`).val(response.data.proEspanhol);
                    $(`#nivelEspanhol`).prop('disabled', false);
                } else {
                    $(`#idiomaEspanhol`).prop('checked', false);
                    $(`#nivelEspanhol`).val(0);
                    $(`#nivelEspanhol`).prop('disabled', true);
                }

                if (response.data.proFrances != null && response.data.proFrances != 0) { // francês
                    $(`#idiomaFrances`).prop('checked', true);
                    $(`#nivelFrances`).val(response.data.proFrances);
                    $(`#nivelFrances`).prop('disabled', false);
                } else {
                    $(`#idiomaFrances`).prop('checked', false);
                    $(`#nivelFrances`).val(0);
                    $(`#nivelFrances`).prop('disabled', true);
                }

                //4
                $(`#certificacoes`).text(response.data.certificacoes);

                //5
                $(`#habilidades`).text(response.data.habilidades);

                //6
                if (response.data.disponibilidade) {
                    let valores = response.data.disponibilidade.split('/');

                    valores.forEach(element => {
                        $(`#${element}`).prop('checked', true);
                    });
                }

                // Verificar mudanças após carregar as informações
                verificarMudancas();
            },
            error: function (xhr, status, error, response) {
                corpoToastInformacao.text('Erro na requisição: ' + error);
                toastInformacao.show();
                console.error('Erro na requisição:', error);
            }
        });
    }

    // Função para salvar informações
    function salvarInfo(parametro, dados, callback) {
        $.ajax({
            url: `../server/api/curriculos/salvarInfo.php/${parametro}`,
            type: 'POST',
            data: dados,
            dataType: 'json',
            success: function (response) {
                corpoToastInformacao.text(response.message || 'Informações salvas com sucesso.');
                toastInformacao.show();
                puxarInfo(); // Atualiza jsonInfo após salvar
                if (callback) callback(); // Executa o callback, se fornecido
            },
            error: function (xhr, status, error) {
                corpoToastInformacao.text('Erro na requisição');
                toastInformacao.show();
                console.error('Erro na requisição:', status);
            }
        });
    }

    // Função de upload de arquivo
    $('#formUploadArquivo').submit(function (event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: '../server/api/curriculos/uploadCurriculo.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#overlay").show();
            },
            success: function (response) {
                puxarArquivo();
                curriculo.val('');
                observacoes.val('');
                corpoToastInformacao.text(response);
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Erro ao enviar arquivo.');
                toastInformacao.show();
            },
            complete: function () {
                $("#overlay").hide();
            }
        });

        return false;
    });

    // Função de exclusão de arquivo
    btnModalExcluir.on('click', function () {
        $.ajax({
            url: '../server/api/curriculos/excluirCurriculo.php',
            type: 'POST',
            success: function (response) {
                puxarArquivo();
                corpoToastInformacao.text('Excluído com sucesso.');
                toastInformacao.show();
            },
            error: function () {
                corpoToastInformacao.text('Erro ao excluir arquivo');
                toastInformacao.show();
            }
        });
    });

    // Salvando informações e verificando alterações
    $('.formAcord').on('submit', function (event) {
        event.preventDefault(); // Evita o comportamento padrão do submit

        let tipo = $(this).data('id');

        let formData = $(this).serializeArray();

        salvarInfo(tipo, formData, function () {
            verificarMudancas(); // Verifica mudanças após salvar
        });
    });

    $('#idiomaIngles').click(function () {
        if (this.checked) {
            $(`#nivelIngles`).val(1).prop('disabled', false);
        } else {
            $(`#nivelIngles`).val(0).prop('disabled', true);
        }
    });

    $('#idiomaEspanhol').click(function () {
        if (this.checked) {
            $(`#nivelEspanhol`).val(1).prop('disabled', false);
        } else {
            $(`#nivelEspanhol`).val(0).prop('disabled', true);
        }
    });

    $('#idiomaFrances').click(function () {
        if (this.checked) {
            $(`#nivelFrances`).val(1).prop('disabled', false);
        } else {
            $(`#nivelFrances`).val(0).prop('disabled', true);
        }
    });

    // Inicializar
    puxarArquivo();
    puxarInfo();

    // Verificar alterações ao digitar
    $('input, select, textarea').on('input', verificarMudancas);
});
