$(function () {
    $('#dgCidade').datagrid({
        url: home_uri + '/modulo/geral/view/CidadeView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        width: '100%',
        toolbar: '#toolbar',
        title: 'Cidades Cadastradas',
        onDblClickCell: function () {
            editarCidadePg();
        },
        columns: [[
                {field: 'cidade_id', title: 'ID', sortable: 'true', width: "10%"},
                {field: 'cidade_nome', title: 'Cidade', sortable: 'true', width: "70%"},
                {field: 'estado_nome', title: 'Estado', sortable: 'true', width: "20%"}
            ]]
    });

    $('#cbEstado').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/geral/view/EstadoView.php',
        idField: 'id',
        textField: 'id',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'id', title: 'Sigla', width: 100},
                {field: 'nome', title: 'Estado', width: 300},
                {field: 'sigla', title: 'UF', width: 100}
            ]],
        onSelect: function (index, row) {
            $("#cbestado_nome").val(row.nome);
        }
    });

    $('#info-estado').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar um estado rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
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

function cadastrarCidade() {
    var op = 'cadastrar';
    salvarCidade(op);
}

function cadastrarCidadePg() {
    window.location = home_uri + "/geral/cidade/cadastrar";
}

function editarCidade() {
    var op = 'editar';
    salvarCidade(op);
}

function editarCidadePg() {
    var row = $('#dgCidade').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/geral/cidade/editar/" + row.cidade_id;
    } else {
        emitirMensagemAviso('Selecione a cidade que deseja editar!');
    }
}

function salvarCidade(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmCidade").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/CidadeController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwCidade").hasClass("window-body")) {
                $("#mwCidade").window('close');
                $('#cbCidade').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmCidade').form('clear');
                }
            }
        } else {
            emitirErrosCidade(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirCidade() {
    var row = $('#dgCidade').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir esta cidade?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/geral/controller/CidadeController.php?op=excluir',
                    dataType: 'json',
                    data: {cidade_id: row.cidade_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgCidade').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosCidade(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a cidade que deseja excluir');
    }
}

function pesquisarCidade() {
    $('#dgCidade').datagrid('load', {
        q: $('#busca').val()
    });
}

function emitirErrosCidade(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#cidade_nome").focus();
        $("#hb-cidade-nome").html(erro);
    } else if (errocod === 103) {
        $("#cbEstado").textbox('textbox').focus();
        $("#hb-cbestado").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function cadastrarEstadoExterno() {
    $('#mwEstado').window({
        href: home_uri + '/geral/estado/cadastrar',
        title: 'Cadastrar Estado',
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
