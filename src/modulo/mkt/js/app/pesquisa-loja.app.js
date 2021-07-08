function enviarEmail() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> Aguarde...');
    var dados = $("#fmEnvioPesquisa").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/mkt/controller/PesquisaLojaController.php',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            $('#fmEnvioPesquisa').form('clear');
        } else {
            emitirMensagemErro(retorno.erro);
        }
        $('.load').html('<i class="fa fa-paper-plane"></i> Enviar');
        $('button').removeAttr('disabled');
    });
}