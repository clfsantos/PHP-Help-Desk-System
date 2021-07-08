$(function () {

    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone("#fmFotoPerfil", {
        url: home_uri + '/modulo/geral/controller/UsuarioConfigController.php?op=foto',
        maxFilesize: 1,
        maxFiles: 1,
        acceptedFiles: '.png,.jpg',
        dictInvalidFileType: 'Extensão de arquivo inválida, somente .jpg ou .png são permitidas!',
        dictFileTooBig: 'Arquivo muito grande. Máximo permitido: {{maxFilesize}}mb. Seu arquivo: {{filesize}}mb',
        success: function (file, response, action) {
            var retorno = jQuery.parseJSON(response);
            if (retorno.sucesso) {
                emitirMensagemSucesso(retorno.sucesso);
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                emitirMensagemErro(retorno.erro);
            }
        },
        error: function (file, response) {
            emitirMensagemErro(response);
        }
    });

    $('#trocar-senha').on('click', function () {
        trocarSenha();
    });
});

function trocarSenha() {
    $('button').attr('disabled', 'disabled');
    var dados = $("#fmUsuarioConfig").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/UsuarioConfigController.php',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            $('#fmUsuarioConfig').form('clear');
            emitirMensagemSucesso(retorno.sucesso);
        } else {
            emitirMensagemErro(retorno.erro);
        }
        $('button').removeAttr('disabled');
    });
}
