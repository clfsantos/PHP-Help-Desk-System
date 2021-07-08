$(function () {
    $('#dgValores').datagrid({
        url: home_uri + '/vendas/view/ProdutoView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        fitColumns: true,
        toolbar: '#toolbar',
        title: 'Listas de Contatos',
        view: detailview,
        detailFormatter: function (index, row) {
            return '<div class="ddv"></div>';
        },
        onExpandRow: function (index, row) {
            var ddv = $(this).datagrid('getRowDetail', index).find('div.ddv');
            ddv.panel({
                height: '300',
                border: false,
                cache: false,
                href: home_uri + '/vendas/view/ProdutoViewDetalhes.php?id=' + row.vdproduto_id,
                onLoad: function () {
                    $('#dgValores').datagrid('fixDetailRowHeight', index);
                }
            });
            $('#dgValores').datagrid('fixDetailRowHeight', index);
        },
        rowStyler: function (index, row) {
            if (row.vdproduto_ativo === false) {
                return 'background-color:#ff5252;text-decoration:line-through;';
            } else {
                return 'background-color:#E0E0E0;';
            }
        },
        columns: [[
                {field: 'vdproduto_id', title: 'ID', sortable: 'true', width: "5%"},
                {field: 'vdproduto_nr_adm', title: 'REF', sortable: 'true', width: "5%"},
                {field: 'vdproduto_nome', title: 'Produto', sortable: 'true', width: "25%"},
                {field: 'nome_fabricante', title: 'Fornecedor', sortable: 'true', width: "20%"},
                {field: 'vdproduto_vl_un', title: 'Valor Unitário', sortable: 'false', width: "10%"},
                {field: 'vdproduto_vl_cx', title: 'Valor Caixa', sortable: 'false', width: "10%"},
                {field: 'vdproduto_vl_cx_un', title: 'Valor Caixa Un.', sortable: 'false', width: "10%"},
                {field: 'vdproduto_un_cx', title: 'Qtd. Caixa', sortable: 'false', width: "5%"},
                {field: 'vdproduto_ativo', title: 'Status', sortable: 'true', width: "9%"}
            ]]
    });

    $('#ctCategorias').combotree({
        url: home_uri + '/vendas/view/CategoriaComboTree.php',
        multiple: true
    });

});

function cadastrarLista() {
    var op = 'cadastrar';
    salvarLista(op);
}

function cadastrarListaPg() {
    window.location = home_uri + "/mkt/lista/cadastrar";
}

function editarLista() {
    var op = 'editar';
    salvarLista(op);
}

function editarListaPg() {
    var row = $('#dgLista').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/mkt/lista/editar/" + row.id;
    } else {
        emitirMensagemAviso('Selecione a lista que deseja editar!');
    }
}

function salvarLista(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmLista").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/mkt/controller/ListaController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwLista").hasClass("window-body")) {
                $("#mwLista").window('close');
                $('#dlContato').datalist('reload');
            } else {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        } else {
            emitirErrosLista(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirLista() {
    var row = $('#dgLista').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir esta lista?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/mkt/controller/ListaController.php?op=excluir',
                    dataType: 'json',
                    data: {id: row.id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgLista').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosLista(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a lista que deseja excluir');
    }
}

function exibirContatosLista() {
    var row = $('#dgLista').datagrid('getSelected');
    if (row) {
        $('#dgLista').datagrid('load', {
            q: ''
        });
        $('#toolbar').css("display", "none");
        $('#dgLista').datagrid({
            url: home_uri + '/mkt/view/ContatoView.php?op=listacontato&lid=' + row.id,
            singleSelect: true,
            pagination: true,
            collapsible: false,
            height: 'auto',
            toolbar: '#toolbar-contato',
            title: '<a href="javascript:location.reload();" title="Voltar"><i class="fa fa-angle-double-left fa-fw"></i></a> Contatos Cadastrados na Lista',
            onDblClickCell: function () {
                editarContatoListaExterno();
            },
            columns: [[
                    {field: 'id', title: 'ID', sortable: 'true', width: "10%"},
                    {field: 'nome', title: 'Nome', sortable: 'true', width: "35%"},
                    {field: 'email', title: 'Email', sortable: 'true', width: "35%"},
                    {field: 'cidade_nome', title: 'Cidade', sortable: 'true', width: "20%"}
                ]]
        });
    } else {
        emitirMensagemAviso('Selecione a lista para visualizar os contatos!');
    }
}

function pesquisarListaContato() {
    $('#dgLista').datagrid('load', {
        q: $('#busca-contato').val()
    });
}

function pesquisarProdutos() {
    $('#dgValores').datagrid('load', {
        q: $('#busca').val()
    });
}

function limparLista() {
    $('#fmLista').form('clear');
}

function emitirErrosLista(erro, errocod) {
    if (errocod === 1000) {
        $("input[name='peso']").focus();
        $("#peso").html(erro);
    } else if (errocod === 104) {
        $("#cbCidade").textbox('textbox').focus();
        $("#hb-cidade").html(erro);
    } else if (errocod === 105) {
        $("#hb-lista").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function editarContatoListaExterno() {
    var row = $('#dgLista').datagrid('getSelected');
    if (row) {
        $('#mwContato').window({
            href: home_uri + '/mkt/contato/editar/' + row.id,
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
