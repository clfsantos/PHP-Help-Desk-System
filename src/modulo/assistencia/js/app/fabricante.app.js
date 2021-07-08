$(function () {
    $('#dgFabricante').datagrid({
        url: home_uri + '/modulo/assistencia/view/FabricanteView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Fabricantes Cadastrados',
        onDblClickCell: function () {
            editarFabricantePg();
        },
        columns: [[
                {field: 'codigo_fabricante', title: 'ID', sortable: 'true', width: "20%"},
                {field: 'nome_fabricante', title: 'Fabricante', sortable: 'true', width: "80%"}
            ]]
    });
});

function cadastrarFabricante() {
    var op = 'cadastrar';
    salvarFabricante(op);
}

function cadastrarFabricantePg() {
    window.location = home_uri + "/assistencia/fabricante/cadastrar";
}

function editarFabricante() {
    var op = 'editar';
    salvarFabricante(op);
}

function editarFabricantePg() {
    var row = $('#dgFabricante').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/fabricante/editar/" + row.codigo_fabricante;
    } else {
        emitirMensagemAviso('Selecione o fabricante que deseja editar!');
    }
}

function salvarFabricante(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmFabricante").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/FabricanteController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwFabricante").hasClass("window-body")) {
                $("#mwFabricante").window('close');
                $('#cbFabricante').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmFabricante').form('clear');
                }
            }
        } else {
            emitirErrosFabricante(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirFabricante() {
    var row = $('#dgFabricante').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este fabricante?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/FabricanteController.php?op=excluir',
                    dataType: 'json',
                    data: {codigo_fabricante: row.codigo_fabricante}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgFabricante').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosFabricante(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o fabricante que deseja excluir');
    }
}

function pesquisarFabricante() {
    $('#dgFabricante').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarFabricante() {
    if ($("#mwFabricante").hasClass("window-body")) {
        $("#mwFabricante").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosFabricante(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#nome_fabricante").focus();
        $("#hb-fabricante").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}
