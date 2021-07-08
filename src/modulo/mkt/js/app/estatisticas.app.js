$(function () {
    $('#dgEstatisticas').datagrid({
        url: home_uri + '/modulo/mkt/view/EstatisticasView.php?eid=' + envio,
        singleSelect: true,
        striped: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Leituras Confirmadas',
        onDblClickCell: function () {
            editarContatoEstatisticaExterno();
        },
        rowStyler: function (index, row) {
            if (row.baixa === true) {
                return 'color:#ef5350;';
            }
        },
        columns: [[
                {field: 'contato_id', title: 'ID', sortable: 'true', width: "10%"},
                {field: 'nome', title: 'Nome', sortable: 'true', width: "40%"},
                {field: 'email', title: 'E-mail', sortable: 'true', width: "40%"},
                {field: 'qtdade', title: 'Quantidade de Leituras', sortable: 'true', width: "5%"},
                {field: 'baixa', title: 'Baixa', sortable: 'true', width: "5%"}
            ]]
    });
    $('#info-leituras-hora').qtip({
        content: {
            title: 'Informação',
            text: "Remete a quantidade do total de leituras em uma determinada hora. Mesmo que feito duas vezes pelo mesmo contato."
                    + "<br /><br />Clique sobre a hora para ver leituras que aconteceram naquela hora."
        },
        position: {
            my: 'top right',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-dark qtip-shadow'
        }
    });
    $('#info-status').qtip({
        content: {
            title: 'Informação',
            text: "<b>Enviadas:</b> Quantidade de e-mail enviados até o momento. <br /><br />"
                    + "<b>Leituras:</b> Quantidade de leituras únicas por contato. <br /><br />"
                    + "<b>Baixas:</b> Quantidade de contatos que pediram baixa nos envios. <br /><br />"
                    + "<b>Retornadas:</b> Quantidade de e-mail que não foram entregues. Ocorrências comuns: caixa de e-mail não existe, caixa de e-mail cheia, entre outros. <br /><br />"
                    + "<b>% Lidas:</b> Porcentagem dos e-mail lidos em relação aos e-mail enviados, desconsiderando os e-mail retornados."
        },
        position: {
            my: 'top right',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-dark qtip-shadow'
        }
    });
});

function limparFiltroEstatisticas() {
    pesquisarEstatisticas('');
}

function pesquisarEstatisticas(hora) {
    $('#dgEstatisticas').datagrid('load', {
        q: $('#busca').val(),
        hora: hora
    });
}

function pesquisarStatus(status) {
    $('#dgEstatisticas').datagrid('load', {
        q: $('#busca').val(),
        status: status
    });
}

function editarContatoEstatisticaExterno() {
    var row = $('#dgEstatisticas').datagrid('getSelected');
    if (row) {
        $('#mwContato').window({
            href: home_uri + '/mkt/contato/editar/' + row.contato_id,
            title: 'Editar Contato',
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
        emitirMensagemAviso('Selecione o contato que deseja editar!');
    }
}
