$(function () {

    if ($('#fmContato').length > 0) {



        $('#dlContato').datalist({
            url: home_uri + '/modulo/mkt/view/ListaView.php?op=dl',
            checkbox: true,
            lines: true,
            height: 350,
            singleSelect: false,
            onLoadSuccess: function (data) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/mkt/view/ContatoView.php?op=lista',
                    dataType: 'json',
                    data: {contato_id: cid}
                }).done(function (retorno) {
                    for (i = 0; i < retorno.length; ++i) {
                        for (j = 0; j < data.rows.length; ++j) {
                            if (data.rows[j]['id'] === retorno[i]['lista_id']) {
                                $('#dlContato').datalist('checkRow', j);
                            }
                        }
                    }
                });
            }
        });



    } else {
        $('#dgContato').datagrid({
            url: home_uri + '/modulo/mkt/view/ContatoView.php?op=contato',
            singleSelect: true,
            pagination: true,
            collapsible: false,
            toolbar: '#toolbar',
            title: 'Contatos Cadastrados',
            onDblClickCell: function () {
                editarContatoPg();
            },
            rowStyler: function (index, row) {
                if (row.baixa === true) {
                    return 'color:#ef5350;';
                }
            },
            columns: [[
                    {field: 'id', title: 'ID', sortable: 'true', width: "10%"},
                    {field: 'nome', title: 'Nome', sortable: 'true', width: "30%"},
                    {field: 'email', title: 'Email', sortable: 'true', width: "35%"},
                    {field: 'cidade_nome', title: 'Cidade', sortable: 'true', width: "20%"},
                    {field: 'baixa', title: 'Baixa', sortable: 'true', width: "5%"}
                ]]
        });

        $('#dlgCadastroEmailMultiplo').dialog({
            buttons: '#dlg-cadastra-multiplo-buttons',
            onOpen: function () {
                $(this).dialog('center');
            },
            onResize: function () {
                $(this).dialog('center');
            }
        });

        $('#dlContato').datalist({
            url: home_uri + '/modulo/mkt/view/ListaView.php?op=dl',
            checkbox: true,
            lines: true,
            height: 350,
            singleSelect: false
        });

        if (checkCookie('filtroContato')) {
            $('#statusBusca').val(getCookie('filtroContato'));
            pesquisarContato();
        }

        var hashc = window.location.hash;
        if (hashc === '#baixa') {
            $('#statusBusca').val('baixa');
            pesquisarContato();
        } else if (hashc === '#ativo') {
            $('#statusBusca').val('ativo');
            pesquisarContato();
        } else if (hashc === '#tudo') {
            $('#statusBusca').val('tudo');
            pesquisarContato();
        }

    }

    $('#cbCidade').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/geral/view/CidadeView.php',
        idField: 'cidade_id',
        textField: 'cidade_id',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'cidade_id', title: 'ID', sortable: 'true', width: 100},
                {field: 'cidade_nome', title: 'Cidade', sortable: 'true', width: 300},
                {field: 'estado_nome', title: 'Estado', sortable: 'true', width: 200}
            ]],
        onSelect: function (index, row) {
            $("#cidade_nome_cb").val(row.cidade_nome);
        }
    });

    $('#info-cidade').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar uma cidade rapidamente começe a digitar o nome da mesma e o sistema completará a busca!"
        },
        position: {
            my: 'top left',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-dark qtip-shadow'
        }
    });

    $('#info-lista').qtip({
        content: {
            title: 'Informação',
            text: "Selecione a lista ou as listas que este contato pertence."
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

function cadastrarContato() {
    var op = 'cadastrar';
    salvarContato(op);
}

function cadastrarContatoPg() {
    window.location = home_uri + "/mkt/contato/cadastrar";
}

function editarContato() {
    var op = 'editar';
    salvarContato(op);
}

function editarContatoPg() {
    var row = $('#dgContato').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/mkt/contato/editar/" + row.id;
    } else {
        emitirMensagemAviso('Selecione o contato que deseja editar!');
    }
}

function salvarContato(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var rows = $('#dlContato').datalist('getSelections');
    var dados = JSON.stringify($("#fmContato").serializeArray());
    var ss = $.map(rows, function (item, idx) {
        return item.id;
    });
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/mkt/controller/ContatoController.php?op=' + op,
        dataType: 'json',
        data: {'lista_id[]': ss, dados: dados}
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwContato").hasClass("window-body")) {
                $("#mwContato").window('close');
                $('#dgLista').datalist('reload');
                $('#dgEstatisticas').datalist('reload');
            } else {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        } else {
            emitirErrosContato(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function salvarContatoMultiplo() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + 'Cadastrar');
    var rows = $('#dlContato').datalist('getSelections');
    var dados = JSON.stringify($("#fmContatoMultiplo").serializeArray());
    var ss = $.map(rows, function (item, idx) {
        return item.id;
    });
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/mkt/controller/ContatoController.php?op=multiplo',
        dataType: 'json',
        data: {'lista_id[]': ss, dados: dados}
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            $('#dlgCadastroEmailMultiplo').dialog('close');
            $('#dgContato').datagrid('reload');
        } else {
            emitirErrosContato(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + 'Cadastrar');
        $('button').removeAttr('disabled');
    });
}

function excluirContato() {
    var row = $('#dgContato').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este contato?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/mkt/controller/ContatoController.php?op=excluir',
                    dataType: 'json',
                    data: {ide: row.id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgContato').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosContato(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o contato que deseja excluir');
    }
}

function cadastrarEmailsMultiplos() {
    $('#dlgCadastroEmailMultiplo').dialog('open');
}

function pesquisarContato() {
    setCookie('filtroContato', $('#statusBusca').val(), 1);
    $('#dgContato').datagrid('load', {
        q: $('#busca').val(),
        sc: $('#statusBusca').val()
    });
}

function limparContato() {
    $('#fmContato').form('clear');
    $('#dlContato').datalist('clearSelections');
    $('#dlContato').datalist('clearChecked');
}

function emitirErrosContato(erro, errocod) {
    if (errocod === 102) {
        $("#nome").focus();
        $("#hb-nome-contato").html(erro);
    } else if (errocod === 103) {
        $("#email").focus();
        $("#hb-email-contato").html(erro);
    } else if (errocod === 104) {
        $("#cbCidade").textbox('textbox').focus();
        $("#hb-cidade-cb").html(erro);
    } else if (errocod === 105) {
        $("#hb-lista").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function cadastrarListaExterna() {
    $('#mwLista').window({
        href: home_uri + '/mkt/lista/cadastrar',
        title: 'Cadastrar Lista',
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

function cadastrarCidadeExterna() {
    $('#mwCidade').window({
        href: home_uri + '/geral/cidade/cadastrar',
        title: 'Cadastrar Cidade',
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
