$(document).ready(function () {
    const toastInformacao = bootstrap.Toast.getOrCreateInstance($('#toastInformacao'));
    const corpoToastInformacao = $('#corpoToastInformacao');

    $("#formSupote").submit(function (event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: 'server/api/suporte/enviarMsg.php/',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                corpoToastInformacao.text(response.message);
                toastInformacao.show();
                $('#modalContrato').modal('hide');
            },
            error: function (response) {
                console.log(response);
                corpoToastInformacao.text(response.responseText);
                toastInformacao.show();
            }
        });
    });
});