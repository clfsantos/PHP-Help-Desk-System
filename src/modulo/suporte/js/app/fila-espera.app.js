$(function () {
    setInterval(atualizaFilaEspera, 9000);
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
        columns: [[
                {field: 'crcliente_id', title: 'ID', sortable: 'true', width: 100},
                {field: 'crcliente_cd_junsoft', title: 'Junsoft', sortable: 'true', width: 100},
                {field: 'crcliente_cnpj', title: 'CNPJ', sortable: 'true', width: 200},
                {field: 'crcliente_fantasia', title: 'Nome Fantasia', sortable: 'true', width: 300},
                {field: 'crcliente_razao', title: 'Razão Social', sortable: 'true', width: 300}
            ]]
    });
    $('#dgFila').datagrid({
        url: home_uri + '/modulo/suporte/view/FilaAtendimentoView.php',
        singleSelect: true,
        pagination: false,
        collapsible: false,
        loadMsg: '',
        toolbar: '#toolbar',
        title: 'Fila de Espera',
        columns: [[
                {field: 'spchamado_fila_dt_ft', title: 'Horário', width: "15%"},
                {field: 'crcliente_fantasia', title: 'Empresa', width: "30%"},
                {field: 'spchamado_fila_obs', title: 'Observação', width: "30%"},
                {field: 'spchamado_fila_qtd', title: 'Retornos', width: "5%"},
                {field: 'spchamado_fila_id', title: '', formatter: formaterAddRetorno, width: "10%"},
                {field: 'crcliente_id', title: 'Atender', formatter: formaterFilaAtender, width: "10%"}
            ]]
    });
});

function atualizaFilaEspera() {
    $('#dgFila').datagrid('reload');
}

function salvarFila() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + 'SALVAR');
    var dados = $("#fmFila").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/FluxoAtendimentoController.php?op=cadastrarfila',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            $('#fmFila').form('clear');
            $('#dgFila').datagrid('reload');
        } else {
            emitirMensagemErro(retorno.erro);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + 'SALVAR');
        $('button').removeAttr('disabled');
    });
}

function salvarAtendimento(crcliente_id) {
    setTimeout(function () {
        var row = $('#dgFila').datagrid('getSelected');
        if (row) {
            limparErros();
            $('button').attr('disabled', 'disabled');
            $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + 'SALVAR');
            $.ajax({
                type: "POST",
                url: home_uri + '/modulo/suporte/controller/FluxoAtendimentoController.php?op=cadastrarbt',
                dataType: 'json',
                data: {'crcliente_id': crcliente_id, 'spchamado_fila_id': row.spchamado_fila_id}
            }).done(function (retorno) {
                if (retorno.sucesso) {
                    emitirMensagemSucesso(retorno.sucesso);
                    $('#dgFila').datagrid('reload');
                } else {
                    emitirMensagemErro(retorno.erro);
                }
                $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + 'SALVAR');
                $('button').removeAttr('disabled');
            });
        } else {
            emitirMensagemAviso('Nenhum atendimento selecionado!');
        }
    }, 100);
}

function addRetorno(spchamado_fila_id) {
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/FluxoAtendimentoController.php?op=addretorno',
        dataType: 'json',
        data: {spchamado_fila_id: spchamado_fila_id}
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            $('#dgFila').datagrid('reload');
        } else {
            emitirMensagemErro(retorno.erro);
        }
    });
}

function cancelarAtendimento() {
    var row = $('#dgFila').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja cancelar este atendimento?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/FluxoAtendimentoController.php?op=cancelar',
                    dataType: 'json',
                    data: {spchamado_fila_id: row.spchamado_fila_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgFila').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirMensagemErro(retorno.erro);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o atendimento que deseja cancelar');
    }
}

function editarAtendimento() {
    var row = $('#dgFila').datagrid('getSelected');
    $('#fmFila').form('load', {
        spchamado_fila_id: row.spchamado_fila_id,
        crcliente_id: row.crcliente_id,
        fila_obs: row.spchamado_fila_obs
    });
}

function formaterFilaAtender(val) {
    return "<button onclick='salvarAtendimento(" + val + ");' class='btn btn-sm btn-primary btn-labeled fa fa-phone'>Atender</button>";
}

function formaterAddRetorno(val) {
    return "<button onclick='addRetorno(" + val + ");' class='btn btn-sm btn-warning btn-labeled fa fa-plus'>Retorno</button>";
}