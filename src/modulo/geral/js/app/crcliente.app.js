$(function () {
    $('#dgCliente').datagrid({
        url: home_uri + '/modulo/geral/view/CRClienteView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Clientes Cadastrados',
        onDblClickCell: function () {
            editarClientePg();
        },
        rowStyler: function (index, row) {
            if (row.crcliente_bloqueado === true) {
                return 'background-color:#ff5252;text-decoration:line-through;';
            }
        },
        columns: [[
                {field: 'crcliente_cd_junsoft', title: 'Junsoft', sortable: 'true', width: "5%"},
                {field: 'crcliente_cnpj', title: 'CPF/CNPJ', formatter: formatterCNPJCPF, sortable: 'true', width: "10%"},
                {field: 'crcliente_razao', title: 'Razão Social', sortable: 'true', width: "20%"},
                {field: 'crcliente_fantasia', title: 'Nome Fantasia', sortable: 'true', width: "15%"},
                {field: 'crcliente_telefone', title: 'Telefone', formatter: maskTelefone, sortable: 'false', width: "10%"},
				{field: 'rcliente_celular', title: 'Celular', formatter: maskTelefone, sortable: 'false', width: "10%"},
                {field: 'crcliente_email', title: 'E-mail', sortable: 'false', width: "10%"},
				{field: 'crcliente_email_rh', title: 'E-mail RH', sortable: 'false', width: "10%"},
                {field: 'crcliente_contato', title: 'Contato', sortable: 'false', width: "10%"}
            ]]
    });
	
	$('#cbContabilidade').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/geral/view/ContabilidadeView.php',
        idField: 'contabilidade_id',
        textField: 'contabilidade_nome',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        rowStyler: function (index, row) {
            if (row.crcliente_bloqueado === true) {
                return 'background-color:#ff5252;text-decoration:line-through;';
            }
        },
        columns: [[
                {field: 'contabilidade_id', title: 'ID', sortable: 'true', width: 100},
                {field: 'contabilidade_nome', title: 'Nome', sortable: 'true', width: 300},
                {field: 'contabilidade_contato', title: 'Contato', sortable: 'true', width: 200},
                {field: 'contabilidade_telefone', title: 'Telefone', sortable: 'true', width: 200}
            ]]
    });

    if ($("#crcliente_cnpj").length > 0) {
        if ($("#crcliente_cnpj").val().length === 14) {
            $("#crcliente_cnpj").mask("99.999.999/9999-99");
        } else {
            $("#crcliente_cnpj").mask("999.999.999-99");
        }

        if ($("#crcliente_telefone").val().length > 9) {
            $("#crcliente_telefone").mask("(99) 9999-9999?9");
        }
		
		if ($("#rcliente_celular").val().length > 9) {
            $("#rcliente_celular").mask("(99) 9999-9999?9");
        }

        $("#crcliente_end_cep").mask("99999-999");
    }

});

function editarCliente() {
    var op = 'editar';
    salvarCliente(op);
}

function editarClientePg() {
    var row = $('#dgCliente').datagrid('getSelected');
    if (row) {
        window.location = home_uri + '/geral/cliente/editar/' + row.crcliente_id;
    } else {
        emitirMensagemAviso('Selecione o cliente que deseja visualizar!');
    }
}

function salvarCliente(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmCliente").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/geral/controller/ClienteController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwCliente").hasClass("window-body")) {
                $("#mwCliente").window('close');
                $('#cbCliente').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmCliente').form('clear');
                }
            }
        } else {
            emitirMensagemErro(retorno.erro);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function pesquisarCliente() {
    $('#dgCliente').datagrid('load', {
        q: $('#busca').val()
    });
}

function verEquipamentos() {
    var row = $('#dgCliente').datagrid('getSelected');
    if (row) {
        $.ajax({
            type: "POST",
            url: home_uri + '/modulo/suporte/view/EquipamentoClienteCombo.php?clienteid=' + row.crcliente_id,
            dataType: 'json'
        }).done(function (data) {
            var md = '<hr />';
            for (i = 0; i < data.length; ++i) {
                md += data[i]['desc_nsr'] + '<hr />';
            }
            $('.equipamentos-conteudo').html(md);
            $(".md-equipamentos").modal();
        });
    } else {
        emitirMensagemAviso('Selecione o cliente que deseja visualizar!');
    }
}

function cancelarCliente() {
    if ($("#mwCliente").hasClass("window-body")) {
        $("#mwCliente").window('close');
    } else {
        window.history.back();
    }
}

function formatterCNPJCPF(val) {
    if (val.length === 14) {
        return maskCnpj(val);
    } else {
        return maskCpf(val);
    }
}
