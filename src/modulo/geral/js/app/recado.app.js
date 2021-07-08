$(function () {
    $('#dgRecado').datagrid({
        url: home_uri + '/modulo/geral/view/RecadoView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        width: '100%',
        toolbar: '#toolbar',
        title: 'Recados',
        onDblClickCell: function () {
            editarRecado();
        },
        rowStyler: function (index, row) {
            if (row.recado_atendido === true) {
                return 'background-color:#4CAF50;';
            }
        },
        columns: [[
                {field: 'recado_id', title: 'ID', sortable: 'true', width: "5%"},
                {field: 'recado_data_ft', title: 'Data', sortable: 'true', width: "15%"},
                {field: 'recado_empresa', title: 'Empresa', sortable: 'true', width: "20%"},
                {field: 'recado_contato', title: 'Contato', width: "10%"},
                {field: 'recado_desc', title: 'Recado', width: "30%"},
                {field: 'recado_destino', title: 'Departamento', sortable: 'true', width: "10%"},
                {field: 'recado_atendido', title: 'Atendido', formatter: formaterAtender, width: "10%"}
            ]]
    });
});

function salvarRecado() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + 'Salvar');
    var dados = $("#fmRecado").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/RecadoController.php?op=salvar',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            if (retorno.op === 'I') {
                $('#fmRecado').form('clear');
            }
            emitirMensagemSucesso(retorno.sucesso);
            $('#dgRecado').datagrid('reload');
        } else {
            emitirErrosRecado(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + 'Salvar');
        $('button').removeAttr('disabled');
    });
}

function cadastrarRecado() {
    limparErros();
    $('#dlgRecado').dialog({
        closed: true,
        buttons: "#dlg-buttons-recado",
        onOpen: function () {
            $(this).dialog('center');
        },
        onResize: function () {
            $(this).dialog('center');
        }
    });

    $('#dlgRecado').css("display", "");
    $('#dlgRecado').dialog('open').dialog('setTitle', 'Novo Recado');
    $('#fmRecado').form('clear');
}

function editarRecado() {
    var row = $('#dgRecado').datagrid('getSelected');
    if (row) {
        limparErros();
        $('#dlgRecado').dialog({
            closed: true,
            buttons: "#dlg-buttons-recado",
            onOpen: function () {
                $(this).dialog('center');
            },
            onResize: function () {
                $(this).dialog('center');
            }
        });

        $('#dlgRecado').css("display", "");
        $('#dlgRecado').dialog('open').dialog('setTitle', 'Editar Recado');
        $('#fmRecado').form('load', row);
    } else {
        emitirMensagemAviso('Primeiro selecione o recado que deseja Editar!');
    }
}

function atenderRecado() {
    var row = $('#dgRecado').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja marcar como atendido?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/geral/controller/RecadoController.php?op=at',
                    dataType: 'json',
                    data: {recado_id: row.recado_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgRecado').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosRecado(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o recado');
    }
}

function marcarNaoAtendido() {
    var row = $('#dgRecado').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja marcar como não atendido?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/geral/controller/RecadoController.php?op=mnat',
                    dataType: 'json',
                    data: {recado_id: row.recado_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgRecado').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosRecado(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o recado');
    }
}

function pesquisarRecado() {
    $('#dgRecado').datagrid('load', {
        q: $('#busca').val()
    });
}

function emitirErrosRecado(erro, errocod) {
    if (errocod === 101) {
        $("#recado_empresa").focus();
        $("#hb-erro").html(erro);
    } else if (errocod === 102) {
        $("#recado_contato").focus();
        $("#hb-erro").html(erro);
    } else if (errocod === 103) {
        $("#recado_destino").textbox('textbox').focus();
        $("#hb-erro").html(erro);
    } else if (errocod === 104) {
        $("#recado_desc").focus();
        $("#hb-erro").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function formaterAtender(value, row, index) {
    if (value === true) {
        return "Por (" + row.recado_usuario_nome + ")";
    } else {
        return "Não";
    }
}
