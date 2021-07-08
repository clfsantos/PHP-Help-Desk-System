$(function () {
    setInterval(carregaPrioridade, 3000);
    $('#cbCliente').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/geral/view/CRClienteView.php',
        idField: 'crcliente_id',
        textField: 'crcliente_fantasia',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        rowStyler: function (index, row) {
            if (row.crcliente_bloqueado === true) {
                return 'background-color:#ff5252;text-decoration:line-through;';
            }
        },
        columns: [[
                {field: 'crcliente_id', title: 'ID', sortable: 'true', width: 100},
                {field: 'is_cliente_mensalista', title: 'Mensalista', sortable: 'true', formatter: formatterMensalista, styler: styleMensalista, width: 100},
                {field: 'crcliente_cnpj', title: 'CNPJ', sortable: 'true', width: 200},
                {field: 'crcliente_fantasia', title: 'Nome Fantasia', sortable: 'true', width: 300},
                {field: 'crcliente_razao', title: 'Razão Social', sortable: 'true', width: 300}
            ]]
    });
    $('#dgFluxo').datagrid({
        url: home_uri + '/modulo/suporte/view/FluxoAtendimentoView.php',
        singleSelect: true,
        pagination: false,
        collapsible: false,
        loadMsg: '',
        title: 'Fluxo Atendimento',
        columns: [[
                {field: 'spchamado_fluxo_dt_ft', title: 'Horário', width: "20%"},
                {field: 'crcliente_fantasia', title: 'Empresa', width: "60%"},
                {field: 'nome', title: 'Técnico', width: "20%"}
            ]]
    });
});

function carregaPrioridade() {
    $('#dgFluxo').datagrid('reload');
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/FluxoAtendimentoController.php?op=prioridade',
        dataType: 'html',
    }).done(function (retorno) {
        $('#container-prioridade').html(retorno);
    });
}

function salvarAtendimento() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + 'SALVAR');
    var dados = $("#fmFluxo").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/FluxoAtendimentoController.php?op=cadastrar',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            $('#fmFluxo').form('clear');
        } else {
            emitirMensagemErro(retorno.erro);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + 'SALVAR');
        $('button').removeAttr('disabled');
    });
}

function formatterMensalista(val) {
    if (val === true) {
        return 'Sim';
    } else {
        return 'Não';
    }
}

function styleMensalista(val) {
    if (val === true) {
        return 'background-color:green;color:white;font-weight:bold;';
    } else {
        return 'background-color:red;color:white;font-weight:bold;';
    }
}