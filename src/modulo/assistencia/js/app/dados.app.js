$(function () {

    $('#nr_ip').mask("999.999.999.999");
    $('#mascara').mask("999.999.999.999");
    $('#gateway').mask("999.999.999.999");

});

function salvarDados() {
    $('#fmManutencao').form('submit', {
        url: home_uri + '/modulo/assistencia/controller/DadosController.php',
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.sucesso) {
                emitirMensagemSucesso(result.sucesso);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                emitirMensagemErro(result.erro);
            }
        }
    });
}

function desvincularDados() {
    $('#fmManutencao').form('submit', {
        url: home_uri + '/modulo/assistencia/controller/DadosController.php?op=desvincular',
        success: function (result) {
            var result = eval('(' + result + ')');
            if (result.sucesso) {
                emitirMensagemSucesso(result.sucesso);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                emitirMensagemErro(result.erro);
            }
        }
    });
}

function carregaDados(id_manutencao) {
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/view/DadosView.php?id=' + id_manutencao,
        dataType: 'json'
    }).done(function (data) {
        $('#mensagem').html("");
        $('#nr_ip').val('');
        $('#mascara').val('');
        $('#gateway').val('');
        $('#outros').val('');
        $('#bateria').iCheck('uncheck');
        $('#chave').iCheck('uncheck');
        $('#bobina').iCheck('uncheck');
        $.each(data.rows, function () {
            $('#nr_ip').val(formaterIP(this['nr_ip']));
            $('#mascara').val(formaterIP(this['mascara']));
            $('#gateway').val(formaterIP(this['gateway']));
            $('#outros').val(this['outros']);
            $('#lacre_antigo').val(this['lacre_antigo']);
            $('#lacre_novo').val(this['lacre_novo']);
            $('#novo_nsr').val(this['novo_nsr']);
            if (this['bateria'] === true) {
                $('#bateria').iCheck('check');
            } else {
                $('#bateria').iCheck('uncheck');
            }
            if (this['chave'] === true) {
                $('#chave').iCheck('check');
            } else {
                $('#chave').iCheck('uncheck');
            }
            if (this['bobina'] === true) {
                $('#bobina').iCheck('check');
            } else {
                $('#bobina').iCheck('uncheck');
            }
        });
    });
}

function formaterIP(v) {
    v = v.replace(/\D/g, "");                    //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2");       //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2");       //Coloca um ponto entre o terceiro e o quarto dígitos de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d)/, "$1.$2");      //Coloca um ponto entre o terceiro e o quarto dígitos de novo
    return v;
}
