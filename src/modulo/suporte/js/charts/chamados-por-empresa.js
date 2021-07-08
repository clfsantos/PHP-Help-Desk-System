$(function () {
    geraChamadosPorEmpresaGrade();
    $('#dtInicial').datebox({
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
    $('#dtFinal').datebox({
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
    $('.cbProduto').combobox({
        url: home_uri + '/modulo/suporte/view/ProdutoChamadoCombo.php',
        valueField: 'spchamado_produto_id',
        textField: 'spchamado_produto_desc',
        editable: false,
        multiple: true
    });
    $('.cbClass').combobox({
        url: home_uri + '/modulo/suporte/view/ClassificacaoChamadoCombo.php',
        valueField: 'spchamado_class_id',
        textField: 'spchamado_class_desc',
        editable: false,
        multiple: true
    });
	$('#cbCliente').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/geral/view/CRClienteView.php',
        idField: 'crcliente_id',
        textField: 'crcliente_fantasia',
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
                {field: 'crcliente_id', title: 'ID', sortable: 'true', width: 100},
                {field: 'is_cliente_mensalista', title: 'Mensalista', sortable: 'true', formatter: formatterMensalista, styler: styleMensalista, width: 100},
                {field: 'crcliente_cnpj', title: 'CNPJ', sortable: 'true', width: 200},
                {field: 'crcliente_fantasia', title: 'Nome Fantasia', sortable: 'true', width: 300},
                {field: 'crcliente_razao', title: 'Razão Social', sortable: 'true', width: 300}
            ]]
    });
});

function geraChamadosPorEmpresaGrade() {
    var dados = $("#fmFiltroChamados").serialize();
    $('#gradeChamados').html("carregando...");
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/suporte/relatorio/chamados-por-empresa.php",
        dataType: 'html',
        data: dados
    }).done(function (retorno) {
        $('#gradeChamados').html(retorno);
    });
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