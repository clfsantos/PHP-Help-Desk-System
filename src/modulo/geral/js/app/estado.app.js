$(function () {
    $('#dgEstado').datagrid({
        url: home_uri + '/modulo/geral/view/EstadoView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Estados Cadastrados',
        onDblClickCell: function () {
            editarEstadoPg();
        },
        columns: [[
                {field: 'id', title: 'ID', sortable: 'true', width: "10%"},
                {field: 'nome', title: 'Estado', sortable: 'true', width: "70%"},
                {field: 'sigla', title: 'UF', sortable: 'true', width: "20%"}
            ]]
    });
});

function cadastrarEstado() {
    var op = 'cadastrar';
    salvarEstado(op);
}

function cadastrarEstadoPg() {
    window.location = home_uri + "/geral/estado/cadastrar";
}

function editarEstado() {
    var op = 'editar';
    salvarEstado(op);
}

function editarEstadoPg() {
    var row = $('#dgEstado').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/geral/estado/editar/" + row.id;
    } else {
        emitirMensagemAviso('Selecione o estado que deseja editar!');
    }
}

function salvarEstado(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmEstado").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/EstadoController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwEstado").hasClass("window-body")) {
                $("#mwEstado").window('close');
                $('#cbEstado').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmEstado').form('clear');
                }
            }
        } else {
            emitirErrosEstado(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirEstado() {
    var row = $('#dgEstado').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este estado?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/geral/controller/EstadoController.php?op=excluir',
                    dataType: 'json',
                    data: {id: row.id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgEstado').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosEstado(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o estado que deseja excluir');
    }
}

function pesquisarEstado() {
    $('#dgEstado').datagrid('load', {
        q: $('#busca').val()
    });
}

function emitirErrosEstado(erro, errocod) {
    if (errocod === 101) {
        $("#sigla").focus();
        $("#hb-sigla").html(erro);
    } else if (errocod === 102 || errocod === 103) {
        $("#estado-nome").focus();
        $("#hb-estado-nome").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}
