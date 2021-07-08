$(function() {
    $('#dgEnvio').datagrid({
        url: home_uri + '/modulo/mkt/view/EnvioView.php',
        singleSelect: true,
        striped: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Campanhas Enviadas',
        onDblClickCell: function () {
            verEstatisticas();
        },
        columns: [[
                {field: 'id', title: 'ID', sortable: 'true', width: "10%"},
                {field: 'titulo', title: 'Título', sortable: 'true', width: "60%"},
                {field: 'data_envio', title: 'Data de Envio', sortable: 'true', width: "20%"},
                {field: 'status', title: 'Status', sortable: 'true', width: "10%"}
            ]]
    });
});

function verEstatisticas() {
    var row = $('#dgEnvio').datagrid('getSelected');
    if (row) {
        window.location = home_uri + '/mkt/ver-estatisticas/' + row.id;
    } else {
        emitirMensagemAviso('Selecione a mensagem que deseja visualizar!');
    }
}

function verMensagem() {
    var row = $('#dgEnvio').datagrid('getSelected');
    if (row) {
        $('#mwMensagem').window({
        href: home_uri + '/mkt/ver-mensagem/'+ row.id,
        title: 'Mensagem',
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
    } else {
        emitirMensagemAviso('Selecione a mensagem que deseja visualizar!');
    }
}

function pesquisarEnvio() {
    $('#dgEnvio').datagrid('load', {
        q: $('#busca').val()
    });
}