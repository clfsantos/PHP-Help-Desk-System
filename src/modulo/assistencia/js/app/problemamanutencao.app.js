$(function () {
    $('#dgProblemaManutencao').datagrid({
        url: home_uri + '/modulo/assistencia/view/ProblemaManutencaoView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Problemas de Manutenção Cadastrados',
        onDblClickCell: function () {
            editarProblemaManutencaoPg();
        },
        columns: [[
                {field: 'id_problema', title: 'ID', sortable: 'true', width: "20%"},
                {field: 'descricao_problema', title: 'Problema', sortable: 'true', width: "80%"}
            ]]
    });
});

function cadastrarProblemaManutencao() {
    var op = 'cadastrar';
    salvarProblemaManutencao(op);
}

function cadastrarProblemaManutencaoPg() {
    window.location = home_uri + "/assistencia/problemamanutencao/cadastrar";
}

function editarProblemaManutencao() {
    var op = 'editar';
    salvarProblemaManutencao(op);
}

function editarProblemaManutencaoPg() {
    var row = $('#dgProblemaManutencao').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/problemamanutencao/editar/" + row.id_problema;
    } else {
        emitirMensagemAviso('Selecione o problema de manutenção que deseja editar!');
    }
}

function salvarProblemaManutencao(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmProblemaManutencao").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/ProblemaManutencaoController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwProblemaManutencao").hasClass("window-body")) {
                $("#mwProblemaManutencao").window('close');
                $('#cbProblemaManutencao').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmProblemaManutencao').form('clear');
                }
            }
        } else {
            emitirErrosProblemaManutencao(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirProblemaManutencao() {
    var row = $('#dgProblemaManutencao').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este evento de followup?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/ProblemaManutencaoController.php?op=excluir',
                    dataType: 'json',
                    data: {id_problema: row.id_problema}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgProblemaManutencao').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosProblemaManutencao(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o problema de manutenção que deseja excluir');
    }
}

function pesquisarProblemaManutencao() {
    $('#dgProblemaManutencao').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarProblemaManutencao() {
    if ($("#mwProblemaManutencao").hasClass("window-body")) {
        $("#mwProblemaManutencao").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosProblemaManutencao(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#descricao_problema").focus();
        $("#hb-problema-descricao").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}
