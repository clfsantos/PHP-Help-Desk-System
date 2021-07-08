$(function () {

    if ($('#fmSubGrupo').length > 0) {

        $('#dlGrupo').datalist({
            url: home_uri + '/modulo/suporte/view/GrupoChamadoView.php?op=dl',
            checkbox: true,
            lines: true,
            height: 350,
            singleSelect: false,
            onLoadSuccess: function (data) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/view/SubGrupoChamadoView.php?op=lista',
                    dataType: 'json',
                    data: {subgrupo_id: sgid}
                }).done(function (retorno) {
                    for (i = 0; i < retorno.length; ++i) {
                        for (j = 0; j < data.rows.length; ++j) {
                            if (data.rows[j]['id'] === retorno[i]['spchamado_grupo_id']) {
                                $('#dlGrupo').datalist('checkRow', j);
                            }
                        }
                    }
                });
            }
        });

        $('#info-grupo').qtip({
            content: {
                title: 'Informação',
                text: "Selecione o grupo ou os grupos que este sub-grupo pertence."
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
        $('#dgSubGrupo').datagrid({
            url: home_uri + '/modulo/suporte/view/SubGrupoChamadoView.php?op=subgrupos',
            singleSelect: true,
            pagination: true,
            collapsible: false,
            toolbar: '#toolbar',
            title: 'Sub-Grupos Cadastrados',
            onDblClickCell: function () {
                editarSubGrupoPg();
            },
            columns: [[
                    {field: 'spchamado_subgrupo_id', title: 'ID', sortable: 'true', width: "20%"},
                    {field: 'spchamado_subgrupo_desc', title: 'Descrição', sortable: 'true', width: "80%"}
                ]]
        });
    }
});

function cadastrarSubGrupo() {
    var op = 'cadastrar';
    salvarSubGrupo(op);
}

function cadastrarSubGrupoPg() {
    window.location = home_uri + "/suporte/sub-grupo/cadastrar";
}

function editarSubGrupo() {
    var op = 'editar';
    salvarSubGrupo(op);
}

function editarSubGrupoPg() {
    var row = $('#dgSubGrupo').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/suporte/sub-grupo/editar/" + row.spchamado_subgrupo_id;
    } else {
        emitirMensagemAviso('Selecione o sub-grupo que deseja editar!');
    }
}

function salvarSubGrupo(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var rows = $('#dlGrupo').datalist('getSelections');
    var dados = JSON.stringify($("#fmSubGrupo").serializeArray());
    var ss = $.map(rows, function (item, idx) {
        return item.id;
    });
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/SubGrupoChamadoController.php?op=' + op,
        dataType: 'json',
        data: {'grupo_id[]': ss, dados: dados}
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwSubGrupo").hasClass("window-body")) {
                $("#mwSubGrupo").window('close');
            } else {
                if (op === 'cadastrar') {
                    $('#fmSubGrupo').form('load', {
                        spchamado_subgrupo_desc: ''
                    });
                }
            }
        } else {
            emitirErrosSubGrupo(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirSubGrupo() {
    var row = $('#dgSubGrupo').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este sub-grupo?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/SubGrupoChamadoController.php?op=excluir',
                    dataType: 'json',
                    data: {ide: row.spchamado_subgrupo_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgSubGrupo').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosSubGrupo(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o sub-grupo que deseja excluir');
    }
}

function pesquisarSubGrupo() {
    $('#dgSubGrupo').datagrid('load', {
        q: $('#busca').val()
    });
}

function emitirErrosSubGrupo(erro, errocod) {
    if (errocod === 103) {
        $("#nome").focus();
        $("#hb-nome-contato").html(erro);
    } else if (errocod === 103) {
        $("#email").focus();
        $("#hb-email-contato").html(erro);
    } else if (errocod === 104) {
        $("#cbCidade").textbox('textbox').focus();
        $("#hb-cidade-cb").html(erro);
    } else if (errocod === 105) {
        $("#hb-lista-grupos").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function cadastrarGrupoExterno() {
    $('#mwGrupo').window({
        href: home_uri + '/suporte/grupo/cadastrar',
        title: 'Cadastrar Grupo',
        modal: false,
        maximized: true,
        minimizable: false,
        maximizable: false,
        collapsible: false,
        extractor: function (data) {
            data = $.fn.panel.defaults.extractor(data);
            var tmp = $('<div></div>').html(data);
            data = tmp.find('.extractor').html();
            tmp.remove();
            return data;
        }
    });
}