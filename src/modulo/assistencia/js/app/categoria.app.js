$(function () {
    $('#dgCategoria').datagrid({
        url: home_uri + '/modulo/assistencia/view/CategoriaView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Categorias Cadastradas',
        onDblClickCell: function () {
            editarCategoriaPg();
        },
        columns: [[
                {field: 'id_categoria', title: 'ID', sortable: 'true', width: "20%"},
                {field: 'descricao_categoria', title: 'Descrição', sortable: 'true', width: "80%"}
            ]]
    });
});

function cadastrarCategoria() {
    var op = 'cadastrar';
    salvarCategoria(op);
}

function cadastrarCategoriaPg() {
    window.location = home_uri + "/assistencia/categoria/cadastrar";
}

function editarCategoria() {
    var op = 'editar';
    salvarCategoria(op);
}

function editarCategoriaPg() {
    var row = $('#dgCategoria').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/categoria/editar/" + row.id_categoria;
    } else {
        emitirMensagemAviso('Selecione a categoria que deseja editar!');
    }
}

function salvarCategoria(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmCategoria").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/CategoriaController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwCategoria").hasClass("window-body")) {
                $("#mwCategoria").window('close');
                $('#cbCategoria').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmCategoria').form('clear');
                }
            }
        } else {
            emitirErrosCategoria(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirCategoria() {
    var row = $('#dgCategoria').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir esta categoria?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/CategoriaController.php?op=excluir',
                    dataType: 'json',
                    data: {id_categoria: row.id_categoria}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgCategoria').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosCategoria(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a categoria que deseja excluir');
    }
}

function pesquisarCategoria() {
    $('#dgCategoria').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarCategoria() {
    if ($("#mwCategoria").hasClass("window-body")) {
        $("#mwCategoria").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosCategoria(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#descricao_categoria").focus();
        $("#hb-categoria-descricao").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}
