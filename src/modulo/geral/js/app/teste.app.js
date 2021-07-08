$(function () {
  
});

function testeDialog() {
    $('#mwEstado').dialog({
        href: home_uri + '/geral/recados',
        width: '90%',
        extractor: function (data) {
            var pattern = /<div class="extractor">((.|[\n\r])*)<\/div><!--extractor-->/im;
            var matches = pattern.exec(data);
            if (matches) {
                return matches[1];
            } else {
                return data;
            }
        },
        onOpen: function () {
            $(this).dialog('center');
        },
        onResize: function () {
            $(this).dialog('center');
        },
        onLoad: function () {
            $(this).dialog('center');
        }
    });

    //$('#dlgRecado').css("display", "");
    $('#mwEstado').dialog('open').dialog('setTitle', 'Recados');
    //$('#fmRecado').form('clear');
}


function cadastrarEstadoExterno() {
    $('#mwEstado').window({
        href: home_uri + '/geral/estado/cadastrar',
        title: 'Cadastrar Estado',
        modal: false,
        maximized: true,
        minimizable: false,
        maximizable: false,
        collapsible: false,
        extractor: function (data) {
            var pattern = /<div class="extractor">((.|[\n\r])*)<\/div><!--extractor-->/im;
            var matches = pattern.exec(data);
            if (matches) {
                return matches[1];
            } else {
                return data;
            }
        }
    });
}

