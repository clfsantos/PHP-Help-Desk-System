$(function () {

    if ($('#dgRelease').length > 0) {

        $('#dgRelease').datagrid({
            url: home_uri + '/modulo/suporte/view/ReleaseView.php',
            singleSelect: true,
            pagination: true,
            collapsible: false,
            toolbar: '#toolbar',
            title: 'Release Cadastradas',
            onDblClickCell: function () {
                editarReleasePg();
            },
            columns: [[
                    {field: 'spchamado_release_dt_fmt', title: 'Data', sortable: 'true', width: "20%"},
                    {field: 'spchamado_produto_desc', title: 'Produto', sortable: 'true', width: "20%"},
                    {field: 'spchamado_release_num', title: 'Release', width: "10%"},
                    {field: 'spchamado_release_desc', title: 'Alterações', width: "50%"}
                ]]
        });

    } else {

        $('.cbProduto').combobox({
            url: home_uri + '/modulo/suporte/view/ProdutoChamadoCombo.php',
            valueField: 'spchamado_produto_id',
            textField: 'spchamado_produto_desc',
            editable: false
        });

        $('.calendario').datebox({
            formatter: function (date) {
                var y = date.getFullYear();
                var m = date.getMonth() + 1;
                var d = date.getDate();
                return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
            },
            parser: function (s) {
                if (!s)
                    return new Date();
                var ss = s.split('/');
                var y = parseInt(ss[0], 10);
                var m = parseInt(ss[1], 10);
                var d = parseInt(ss[2], 10);
                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                    return new Date(d, m - 1, y);
                } else {
                    return new Date();
                }
            }
        }).datebox('textbox').mask("99/99/9999");
    }
});

function cadastrarRelease() {
    var op = 'cadastrar';
    salvarRelease(op);
}

function cadastrarReleasePg() {
    window.location = home_uri + "/suporte/release/cadastrar";
}

function editarRelease() {
    var op = 'editar';
    salvarRelease(op);
}

function editarReleasePg() {
    var row = $('#dgRelease').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/suporte/release/editar/" + row.spchamado_release_id;
    } else {
        emitirMensagemAviso('Selecione a release que deseja editar!');
    }
}

function salvarRelease(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmRelease").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/ReleaseController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwRelease").hasClass("window-body")) {
                $("#mwRelease").window('close');
                $('#cbRelease').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmRelease').form('clear');
                }
            }
        } else {
            emitirErrosRelease(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirRelease() {
    var row = $('#dgRelease').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir esta release?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/ReleaseController.php?op=excluir',
                    dataType: 'json',
                    data: {spchamado_release_id: row.spchamado_release_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgRelease').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosRelease(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a release que deseja excluir');
    }
}

function pesquisarRelease() {
    $('#dgRelease').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarRelease() {
    if ($("#mwRelease").hasClass("window-body")) {
        $("#mwRelease").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosRelease(erro, errocod) {
    $.messager.alert('Erro', erro, 'error', function () {
        if (errocod === 102) {
            $(".cbProduto").textbox('textbox').focus();
        } else if (errocod === 103) {
            $("#spchamado_release_num").focus();
        } else if (errocod === 104) {
            $("#spchamado_release_desc").focus();
        } else if (errocod === 105) {
            $("#spchamado_release_dt_fmt").textbox('textbox').focus();
        }
    });
}
