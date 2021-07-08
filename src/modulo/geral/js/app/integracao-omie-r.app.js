$(function () {

    $('#iomie').on('click', function () {
        rodarIntegracaoOmie();
    });

});

function rodarIntegracaoOmie() {
    $('button').attr('disabled', 'disabled');
    $('#ijprogress').html('<div class="progress progress-striped active"><div style="width: 100%;" class="progress-bar progress-bar-primary"></div></div>');
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/IntegracaoOmie.php',
        dataType: 'html'
    }).done(function (retorno) {
        $('#ijprogress').html('Integração OK!');
        $('#mensagem').html(retorno);
        $('button').removeAttr('disabled');
    });
}
