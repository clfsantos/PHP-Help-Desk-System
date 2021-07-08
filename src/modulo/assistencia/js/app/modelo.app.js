$(function () {
    $('#dgModelo').datagrid({
        url: home_uri + '/modulo/assistencia/view/ModeloView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Modelos Cadastrados',
        onDblClickCell: function () {
            editarModeloPg();
        },
        columns: [[
                {field: 'id_modelo', title: 'ID', sortable: 'true', width: "10%"},
                {field: 'descricao', title: 'Modelo', sortable: 'true', width: "50%"},
                {field: 'nome_fabricante', title: 'Fabricante', sortable: 'true', width: "20%"},
                {field: 'descricao_categoria', title: 'Categoria', sortable: 'true', width: "20%"}
            ]]
    });

    $('#cbFabricante').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/assistencia/view/FabricanteView.php',
        idField: 'codigo_fabricante',
        textField: 'codigo_fabricante',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'codigo_fabricante', title: 'ID', sortable: 'true', width: 100},
                {field: 'nome_fabricante', title: 'Fabricante', sortable: 'true', width: 300}
            ]],
        onSelect: function (index, row) {
            $("#nome_cbfabricante").val(row.nome_fabricante);
        }
    });

    $('#cbCategoria').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/assistencia/view/CategoriaView.php',
        idField: 'id_categoria',
        textField: 'id_categoria',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'id_categoria', title: 'ID', sortable: 'true', width: 100},
                {field: 'descricao_categoria', title: 'Cidade', sortable: 'true', width: 300}
            ]],
        onSelect: function (index, row) {
            $("#descricao_cbcategoria").val(row.descricao_categoria);
        }
    });

    $('#info-fabricante').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar um fabricante rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
        },
        position: {
            my: 'top left',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-dark qtip-shadow'
        }
    });

    $('#info-categoria').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar uma categoria rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
        },
        position: {
            my: 'top left',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-dark qtip-shadow'
        }
    });
});

function cadastrarModelo() {
    var op = 'cadastrar';
    salvarModelo(op);
}

function cadastrarModeloPg() {
    window.location = home_uri + "/assistencia/modelo/cadastrar";
}

function editarModelo() {
    var op = 'editar';
    salvarModelo(op);
}

function editarModeloPg() {
    var row = $('#dgModelo').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/modelo/editar/" + row.id_modelo;
    } else {
        emitirMensagemAviso('Selecione o modelo que deseja editar!');
    }
}

function salvarModelo(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmModelo").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/ModeloController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwModelo").hasClass("window-body")) {
                $("#mwModelo").window('close');
                $('#cbModelo').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmModelo').form('clear');
                }
            }
        } else {
            emitirErrosModelo(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirModelo() {
    var row = $('#dgModelo').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este modelo?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/ModeloController.php?op=excluir',
                    dataType: 'json',
                    data: {id_modelo: row.id_modelo}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgModelo').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosModelo(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o modelo que deseja excluir');
    }
}

function pesquisarModelo() {
    $('#dgModelo').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarModelo() {
    if ($("#mwModelo").hasClass("window-body")) {
        $("#mwModelo").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosModelo(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#modelo_descricao").focus();
        $("#hb-modelo-descricao").html(erro);
    } else if (errocod === 103) {
        $("#cbFabricante").textbox('textbox').focus();
        $("#hb-cbfabricante").html(erro);
    } else if (errocod === 104) {
        $("#cbCategoria").textbox('textbox').focus();
        $("#hb-cbcategoria").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function cadastrarFabricanteExterno() {
    $('#mwFabricante').window({
        href: home_uri + '/assistencia/fabricante/cadastrar',
        title: 'Cadastrar Fabricante',
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

function cadastrarCategoriaExterno() {
    $('#mwCategoria').window({
        href: home_uri + '/assistencia/categoria/cadastrar',
        title: 'Cadastrar Categoria',
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
