$(function () {

    if ($('#fmGrupo').length > 0) {

        $('#dlProduto').datalist({
            url: home_uri + '/modulo/suporte/view/ProdutoChamadoView.php?op=dl',
            checkbox: true,
            lines: true,
            height: 350,
            singleSelect: false,
            onLoadSuccess: function (data) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/view/GrupoChamadoView.php?op=lista',
                    dataType: 'json',
                    data: {grupo_id: gid}
                }).done(function (retorno) {
                    for (i = 0; i < retorno.length; ++i) {
                        for (j = 0; j < data.rows.length; ++j) {
                            if (data.rows[j]['id'] === retorno[i]['spchamado_produto_id']) {
                                $('#dlProduto').datalist('checkRow', j);
                            }
                        }
                    }
                });
            }
        });

        $('#info-produto').qtip({
            content: {
                title: 'Informação',
                text: "Selecione o produto ou os produtos que este grupo pertence."
            },
            position: {
                my: 'top left',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-dark qtip-shadow'
            }
        });

    } else {
        $('#dgGrupo').datagrid({
            url: home_uri + '/modulo/suporte/view/GrupoChamadoView.php?op=grupos',
            singleSelect: true,
            pagination: true,
            collapsible: false,
            toolbar: '#toolbar',
            title: 'Grupos Cadastrados',
            onDblClickCell: function () {
                editarGrupoPg();
            },
            columns: [[
                    {field: 'spchamado_grupo_id', title: 'ID', sortable: 'true', width: "20%"},
                    {field: 'spchamado_grupo_desc', title: 'Descrição', sortable: 'true', width: "80%"}
                ]]
        });
    }
});

function cadastrarGrupo() {
    var op = 'cadastrar';
    salvarGrupo(op);
}

function cadastrarGrupoPg() {
    window.location = home_uri + "/suporte/grupo/cadastrar";
}

function editarGrupo() {
    var op = 'editar';
    salvarGrupo(op);
}

function editarGrupoPg() {
    var row = $('#dgGrupo').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/suporte/grupo/editar/" + row.spchamado_grupo_id;
    } else {
        emitirMensagemAviso('Selecione o grupo que deseja editar!');
    }
}

function salvarGrupo(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var rows = $('#dlProduto').datalist('getSelections');
    var dados = JSON.stringify($("#fmGrupo").serializeArray());
    var ss = $.map(rows, function (item, idx) {
        return item.id;
    });
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/GrupoChamadoController.php?op=' + op,
        dataType: 'json',
        data: {'produto_id[]': ss, dados: dados}
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwGrupo").hasClass("window-body")) {
                $("#mwGrupo").window('close');
                $('#dlGrupo').datalist('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmGrupo').form('load', {
                        spchamado_grupo_desc: ''
                    });
                }
            }
        } else {
            emitirErrosGrupo(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirGrupo() {
    var row = $('#dgGrupo').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este grupo?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/GrupoChamadoController.php?op=excluir',
                    dataType: 'json',
                    data: {ide: row.spchamado_grupo_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgGrupo').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosGrupo(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o grupo que deseja excluir');
    }
}

function pesquisarGrupo() {
    $('#dgGrupo').datagrid('load', {
        q: $('#busca').val()
    });
}

function emitirErrosGrupo(erro, errocod) {
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
        $("#hb-lista-produtos").html(erro);
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