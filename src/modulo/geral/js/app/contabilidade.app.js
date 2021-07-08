$(function () {
    $('#dgContabilidade').datagrid({
        url: home_uri + '/modulo/geral/view/ContabilidadeView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        width: '100%',
        toolbar: '#toolbar',
        title: 'Contabilidade Cadastradas',
        onDblClickCell: function () {
            editarContabilidadePg();
        },
        columns: [[
                {field: 'contabilidade_id', title: 'ID', sortable: 'true', width: "10%"},
				{field: 'contabilidade_nome', title: 'Nome', sortable: 'true', width: "30%"},
				{field: 'contabilidade_contato', title: 'Contato', sortable: 'true', width: "30%"},
                {field: 'contabilidade_cnpj', title: 'CNPJ', sortable: 'true', formatter: formatterCNPJCPF, width: "15%"},
				{field: 'contabilidade_telefone', title: 'Telefone', sortable: 'true', formatter: maskTelefone, width: "15%"}
            ]]
    });
    $("#contabilidade_telefone").mask("(99) 9999-9999?9");
	$("#contabilidade_cnpj").mask("99999999999?999");
});

function cadastrarContabilidade() {
    var op = 'cadastrar';
    salvarContabilidade(op);
}

function cadastrarContabilidadePg() {
    window.location = home_uri + "/geral/contabilidade/cadastrar";
}

function editarContabilidade() {
    var op = 'editar';
    salvarContabilidade(op);
}

function editarContabilidadePg() {
    var row = $('#dgContabilidade').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/geral/contabilidade/editar/" + row.contabilidade_id;
    } else {
        emitirMensagemAviso('Selecione a contabilidade que deseja editar!');
    }
}

function salvarContabilidade(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmContabilidade").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/ContabilidadeController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);            
			if (op === 'cadastrar') {
				$('#fmContabilidade').form('clear');
			}
        } else {
            emitirErrosContabilidade(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirContabilidade() {
    var row = $('#dgContabilidade').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir esta contabilidade?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/geral/controller/ContabilidadeController.php?op=excluir',
                    dataType: 'json',
                    data: {contabilidade_id: row.contabilidade_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgContabilidade').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosContabilidade(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a contabilidade que deseja excluir');
    }
}

function pesquisarContabilidade() {
    $('#dgContabilidade').datagrid('load', {
        q: $('#busca').val()
    });
}

function emitirErrosContabilidade(erro, errocod) {
    if (errocod === 101 || errocod === 102) {
        $("#contabilidade_cnpj").focus();
        $("#hb-contabilidade-cnpj").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function formatterMensalista(val) {
    if (val === true) {
        return 'Sim';
    } else {
        return 'Não';
    }
}

function styleMensalista(val) {
    if (val === true) {
        return 'background-color:green;color:white;font-weight:bold;';
    } else {
        return 'background-color:red;color:white;font-weight:bold;';
    }
}

function formatterCNPJCPF(val) {
    if (val.length === 14) {
        return maskCnpj(val);
    } else {
        return maskCpf(val);
    }
}
