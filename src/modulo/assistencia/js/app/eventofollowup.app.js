$(function () {
    $('#dgEventoFollowup').datagrid({
        url: home_uri + '/modulo/assistencia/view/EventoFollowupView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Eventos de Followup Cadastrados',
        onDblClickCell: function () {
            editarEventoFollowupPg();
        },
        columns: [[
                {field: 'id_evento', title: 'ID', sortable: 'true', width: "20%"},
                {field: 'descricao_evento', title: 'Evento de Followup', sortable: 'true', width: "70%"},
                {field: 'prioridade_id', title: 'Nível SLA', sortable: 'true', width: "10%"}
            ]]
    });
});

function cadastrarEventoFollowup() {
    var op = 'cadastrar';
    salvarEventoFollowup(op);
}

function cadastrarEventoFollowupPg() {
    window.location = home_uri + "/assistencia/eventofollowup/cadastrar";
}

function editarEventoFollowup() {
    var op = 'editar';
    salvarEventoFollowup(op);
}

function editarEventoFollowupPg() {
    var row = $('#dgEventoFollowup').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/eventofollowup/editar/" + row.id_evento;
    } else {
        emitirMensagemAviso('Selecione o evento de followup que deseja editar!');
    }
}

function salvarEventoFollowup(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmEventoFollowup").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/EventoFollowupController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwEventoFollowup").hasClass("window-body")) {
                $("#mwEventoFollowup").window('close');
                $('#cbEventoFollowup').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmEventoFollowup').form('clear');
                }
            }
        } else {
            emitirErrosEventoFollowup(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirEventoFollowup() {
    var row = $('#dgEventoFollowup').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este evento de followup?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/EventoFollowupController.php?op=excluir',
                    dataType: 'json',
                    data: {id_evento: row.id_evento}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgEventoFollowup').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosEventoFollowup(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o evento de followup que deseja excluir');
    }
}

function pesquisarEventoFollowup() {
    $('#dgEventoFollowup').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarEventoFollowup() {
    if ($("#mwEventoFollowup").hasClass("window-body")) {
        $("#mwEventoFollowup").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosEventoFollowup(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#descricao_evento").focus();
        $("#hb-descricao-evento").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}
