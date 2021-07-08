home_uri = 'http://' + location.hostname + '/sgsti/src';

$(function () {
    var url = window.location;
    var element = $('ul.collapse a').filter(function () {
        return this.href === url || url.href.indexOf(this.href) === 0;
    }).addClass('active-link').parent().addClass('active-link').parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active-sub');
    }
    $('li.sozinho a').filter(function () {
        return this.href === url || url.href.indexOf(this.href) === 0;
    }).addClass('active-link').parent().addClass('active-link');

    atualizaContagem();
    chamadosAbertoUsuario();
    setInterval(atualizaContagem, 9000);
    setInterval(chamadosAbertoUsuario, 9000);

    //$("#notificacoes").click(function(e){
    // alert('abriu');
    //});

    /*
    var d = $("#demo-asd-vis");
    $("#demo-toggle-aside").on("click", function (e) {
    $.when(e.preventDefault(), nifty.container.hasClass("aside-in") ? ($.niftyAside("hide"), d.niftyCheck("toggleOff")) : ($.niftyAside("show"), d.niftyCheck("toggleOn"))).then(setTimeout(function () {
    $("body").panel("doLayout");
    }, 300));
    }); */
});

function atualizaContagem() {
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/ComumController.php?op=fila',
        dataType: 'html'
    }).done(function (retorno) {
        $('.contagem-fila').html(retorno);
    });
}

function chamadosAbertoUsuario() {
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/ComumController.php?op=ch',
        dataType: 'html'
    }).done(function (retorno) {
        $('.chamados_abertos').html(retorno);
    });
}

function emitirMensagemSucesso(mensagem) {
    var estilo = '<div id="floating-top-right" class="floating-container"><div class="alert-wrap in animated jellyIn"><div class="alert alert-success" role="alert"><button class="close" type="button"><i class="fa fa-times-circle"></i></button><div class="media"><div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon"><i class="fa fa-thumbs-up fa-lg"></i></span></div><div class="media-body"><h4 class="alert-title">Sucesso</h4><p class="alert-message">' + mensagem + '</p></div></div></div></div></div>';
    $(estilo).appendTo($("#mensagem")).fadeOut(4000);
}

function emitirMensagemErro(mensagem) {
    $.messager.alert('Erro', mensagem, 'error');
}

function emitirMensagemAviso(mensagem) {
    $.messager.alert('Atenção', mensagem, 'warning');
}

function expandirCampos() {
    $('.campos').textbox('resize', '100%');
    $('#guias').tabs('resize', '100%');
}

function limparErros() {
    $.each($('.hb-erro'), function () {
        $('.hb-erro').html("");
    });
}

function maskTelefone(v) {
	if (v) {
        v = v.replace(/\D/g, "");
        v = v.replace(/^(\d\d)(\d)/g, "($1) $2");
        v = v.replace(/(\d{4})(\d)/, "$1-$2");
		return v;
	} else {
		return '';
	}
}

function maskCpf(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return v;
}

function maskData(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/(\d{2})(\d)/, "$1/$2");
    v = v.replace(/(\d{2})(\d)/, "$1/$2");
    return v;
}
function maskHora(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/(\d{2})(\d)/, "$1:$2");
    return v;
}

function maskCep(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/^(\d{2})(\d)/, "$1.$2");
    v = v.replace(/(\d{3})(\d)/, "$1-$2");
    return v;
}

function maskCnpj(v) {
    v = v.replace(/\D/g, "");
    v = v.replace(/^(\d{2})(\d)/, "$1.$2");
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
    v = v.replace(/(\d{4})(\d)/, "$1-$2");
    return v;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteCookie(name) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

function checkCookie(cname) {
    var c = getCookie(cname);
    if (c !== "") {
        return true;
    } else {
        return false;
    }
}