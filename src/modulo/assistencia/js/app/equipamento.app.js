$(function () {
    $('#dgEquipamento').datagrid({
        url: home_uri + '/modulo/assistencia/view/EquipamentoView.php',
        singleSelect: true,
        pagination: true,
        collapsible: false,
        toolbar: '#toolbar',
        title: 'Equipamentos Cadastrados',
        onDblClickCell: function () {
            editarEquipamentoPg();
        },
        rowStyler: function (index, row) {
            if (row.inativo === true) {
                return 'background-color:#ff5252;text-decoration:line-through;';
            }
        },
        columns: [[
				{field: 'dt_inclusao_ft', title: 'Data Inclusão', sortable: 'false', width: "10%"},
                {field: 'nr_serie', title: 'Número de Série', sortable: 'true', width: "20%"},
                {field: 'crcliente_fantasia', title: 'Cliente', sortable: 'true', width: "40%"},
                {field: 'descricao', title: 'Modelo', sortable: 'true', width: "30%"}
            ]]
    });

    $('#cbCliente').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/geral/view/CRClienteView.php',
        idField: 'crcliente_id',
        textField: 'crcliente_id',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'crcliente_id', title: 'ID', sortable: 'true', width: 100},
                {field: 'crcliente_cd_junsoft', title: 'Junsoft', sortable: 'true', width: 100},
                {field: 'crcliente_cnpj', title: 'CNPJ', sortable: 'true', width: 200},
                {field: 'crcliente_fantasia', title: 'Nome Fantasia', sortable: 'true', width: 300},
                {field: 'crcliente_razao', title: 'Razão Social', sortable: 'true', width: 300}
            ]],
        onSelect: function (index, row) {
            $("#crcliente_fantasia_cb").val(row.crcliente_fantasia);
        }
    });

    $('#cbModelo').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/assistencia/view/ModeloView.php',
        idField: 'id_modelo',
        textField: 'id_modelo',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'id_modelo', title: 'ID', sortable: 'true', width: 100},
                {field: 'descricao', title: 'Modelo', sortable: 'true', width: 300},
                {field: 'nome_fabricante', title: 'Fabricante', sortable: 'true', width: 200},
                {field: 'descricao_categoria', title: 'Categoria', sortable: 'true', width: 200}
            ]],
        onSelect: function (index, row) {
            $("#descricao_modelo_cb").val(row.descricao);
        }
    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square',
        radioClass: 'iradio_square'
    });

    $('#info-cliente').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar um cliente rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
        },
        position: {
            my: 'top left',
            at: 'bottom center'
        },
        style: {
            classes: 'qtip-dark qtip-shadow'
        }
    });

    $('#info-modelo').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar um modelo rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
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

function cadastrarEquipamento() {
    var op = 'cadastrar';
    salvarEquipamento(op);
}

function cadastrarEquipamentoPg() {
    window.location = home_uri + "/assistencia/equipamento/cadastrar";
}

function editarEquipamento() {
    var op = 'editar';
    salvarEquipamento(op);
}

function editarEquipamentoPg() {
    var row = $('#dgEquipamento').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/equipamento/editar/" + row.codigo_equipamento;
    } else {
        emitirMensagemAviso('Selecione o equipamento que deseja editar!');
    }
}

function salvarEquipamento(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmEquipamento").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/EquipamentoController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwEquipamento").hasClass("window-body")) {
                $("#mwEquipamento").window('close');
                $('#cbEquipamento').combogrid('grid').datagrid('reload');
            } else {
                if (op === 'cadastrar') {
                    $('#fmEquipamento').form('clear');
                }
            }
        } else {
            emitirErrosEquipamento(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirEquipamento() {
    var row = $('#dgEquipamento').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este equipamento?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/EquipamentoController.php?op=excluir',
                    dataType: 'json',
                    data: {codigo_equipamento: row.codigo_equipamento}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgEquipamento').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosEquipamento(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o equipamento que deseja excluir');
    }
}

function pesquisarEquipamento() {
    $('#dgEquipamento').datagrid('load', {
        q: $('#busca').val()
    });
}

function cancelarEquipamento() {
    if ($("#mwEquipamento").hasClass("window-body")) {
        $("#mwEquipamento").window('close');
    } else {
        window.history.back();
    }
}

function emitirErrosEquipamento(erro, errocod) {
    if (errocod === 101 || errocod === 102 || errocod === 103) {
        $("#nr_serie").focus();
        $("#hb-nsr").html(erro);
    } else if (errocod === 104) {
        $("#cbCliente").textbox('textbox').focus();
        $("#hb-cbcliente").html(erro);
    } else if (errocod === 105) {
        $("#cbModelo").textbox('textbox').focus();
        $("#hb-cbmodelo").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function cadastrarEmpresaExterno() {
    $('#mwEmpresa').window({
        href: home_uri + '/assistencia/cliente/cadastrar',
        title: 'Cadastrar Empresa',
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

function cadastrarModeloExterno() {
    $('#mwModelo').window({
        href: home_uri + '/assistencia/modelo/cadastrar',
        title: 'Cadastrar Modelo',
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
