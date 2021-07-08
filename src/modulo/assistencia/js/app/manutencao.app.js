$(function () {

    if ($('#guias').length > 0) {
        $('#guias').tabs({
            border: false,
            onSelect: function (title, index) {
                if (index > 1) {
                    $('.acao').css("display", "none");
                } else {
                    $('.acao').css("display", "");
                }
            }
        });

        $('#cbEquipamento').combogrid({
            panelWidth: '100%',
            panelMaxWidth: 550,
            panelHeight: 308,
            url: home_uri + '/modulo/assistencia/view/EquipamentoView.php',
            idField: 'codigo_equipamento',
            textField: 'codigo_equipamento',
            loadMsg: 'Carregando! Aguarde ...',
            mode: 'remote',
            fitColumns: true,
            pagination: true,
            striped: true,
            columns: [[
                    {field: 'nr_serie', title: 'Número de Série', sortable: 'true', width: 100},
                    {field: 'crcliente_fantasia', title: 'Empresa', sortable: 'true', width: 300},
                    {field: 'descricao', title: 'Modelo', sortable: 'true', width: 200}
                ]],
            onSelect: function (index, row) {
                $("#descricao_manutencao_cb").val(row.descricao + " (" + row.nr_serie + ") -" + " (" + row.crcliente_fantasia + ")");
            }
        });

        $('#cbProblemaManutencao').combogrid({
            panelWidth: '100%',
            panelMaxWidth: 550,
            panelHeight: 308,
            url: home_uri + '/modulo/assistencia/view/ProblemaManutencaoView.php',
            idField: 'id_problema',
            textField: 'id_problema',
            loadMsg: 'Carregando! Aguarde ...',
            mode: 'remote',
            fitColumns: true,
            pagination: true,
            striped: true,
            columns: [[
                    {field: 'id_problema', title: 'ID', sortable: 'true', width: 100},
                    {field: 'descricao_problema', title: 'Problema', sortable: 'true', width: 300}
                ]],
            onSelect: function (index, row) {
                $("#descricao_problema_cb").val(row.descricao_problema);
            }
        });

        $('#info-equipamento').qtip({
            content: {
                title: 'Dica',
                text: "Para encontrar um equipamento rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
            },
            position: {
                my: 'top left',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-dark qtip-shadow'
            }
        });

        $('#info-problema').qtip({
            content: {
                title: 'Dica',
                text: "Para encontrar uma categoria de problema rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
            },
            position: {
                my: 'top left',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-dark qtip-shadow'
            }
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square'
        });

        $('#data_entrada').datebox({
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

        $('#data_devolucao').datebox({
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

        carregaGridFollowup(cid);
        carregaGridArquivo(cid);
        carregaDados(cid);
    } else {
        $('#dgManutencao').datagrid({
            url: home_uri + '/modulo/assistencia/view/ManutencaoView.php',
            singleSelect: true,
            pagination: true,
            collapsible: false,
            toolbar: '#toolbar',
            title: 'Manutenções Cadastradas',
            onDblClickCell: function () {
                editarManutencaoPg();
            },
            columns: [[
                    {field: 'data_entrada', title: 'Data de Entrada', sortable: 'true', width: "10%"},
                    {field: 'nr_serie', title: 'Número de Série', sortable: 'true', width: "20%"},
                    {field: 'descricao', title: 'Modelo', sortable: 'true', width: "20%"},
                    {field: 'crcliente_fantasia', title: 'Empresa', sortable: 'true', width: "30%"},
                    {field: 'nota_fiscal', title: 'Nota Fiscal', sortable: 'true', width: "10%"},
                    {field: 'manutencao_ativa', title: 'Status', sortable: 'true', formatter: formaterManutencao, styler: styleManutencao, width: "10%"}
                ]]
        });

        if (checkCookie('filtroManutencao')) {
            $('#statusBusca').val(getCookie('filtroManutencao'));
            pesquisarManutencao();
        }

        var hashc = window.location.hash;
        if (hashc === '#aberto') {
            $('#statusBusca').val('aberto');
            pesquisarManutencao();
        } else if (hashc === '#finalizado') {
            $('#statusBusca').val('finalizado');
            pesquisarManutencao();
        } else if (hashc === '#tudo') {
            $('#statusBusca').val('tudo');
            pesquisarManutencao();
        }
    }

});

function cadastrarManutencao() {
    var op = 'cadastrar';
    salvarManutencao(op);
}

function cadastrarManutencaoPg() {
    window.location = home_uri + "/assistencia/manutencao/cadastrar";
}

function editarManutencao() {
    var op = 'editar';
    salvarManutencao(op);
}

function editarManutencaoPg() {
    var row = $('#dgManutencao').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/manutencao/editar/" + row.id_manutencao;
    } else {
        emitirMensagemAviso('Selecione a manutenção que deseja editar!');
    }
}

function salvarManutencao(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmManutencao").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/ManutencaoController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwManutencao").hasClass("window-body")) {
                $("#mwManutencao").window('close');
            } else {
                if (op === 'cadastrar') {
                    $('#fmManutencao').form('clear');
                }
            }
        } else {
            emitirErrosManutencao(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirManutencao() {
    var row = $('#dgManutencao').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir esta manutenção?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/ManutencaoController.php?op=excluir',
                    dataType: 'json',
                    data: {id_manutencao: row.id_manutencao}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgManutencao').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosManutencao(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a manutenção que deseja excluir');
    }
}

function pesquisarManutencao() {
    setCookie('filtroManutencao', $('#statusBusca').val(), 1);
    $('#dgManutencao').datagrid('load', {
        q: $('#busca').val(),
        pm: $('#statusBusca').val()
    });
}

function limparManutencao() {
    $('#fmManutencao').form('clear');
}

function cancelarManutencao() {
    if ($("#mwManutencao").hasClass("window-body")) {
        $("#mwManutencao").window('close');
    } else {
        window.history.back();
    }
}

function visualisarManutencao() {
    var row = $('#dgManutencao').datagrid('getSelected');
    if (row) {
        window.location = home_uri + "/assistencia/detalhes-manutencao/" + row.id_manutencao;
    } else {
        emitirMensagemAviso('Selecione a manutenção que deseja visualizar!');
    }
}

function emitirErrosManutencao(erro, errocod) {
    if (errocod === 101) {
        $("#cbEquipamento").textbox('textbox').focus();
        $("#hb-equipamento-cb").html(erro);
    } else if (errocod === 102) {
        $("#cbProblemaManutencao").textbox('textbox').focus();
        $("#hb-problema-cb").html(erro);
    } else if (errocod === 103 || errocod === 104) {
        $("#problema_inicial").focus();
        $("#hb-pinicial").html(erro);
    } else if (errocod === 105) {
        $("#data_entrada").textbox('textbox').focus();
        $("#hb-dtentrada").html(erro);
    } else if (errocod === 106 || errocod === 107) {
        $("#data_devolucao").textbox('textbox').focus();
        $("#hb-dtdevolucao").html(erro);
    } else if (errocod === 108) {
        $("#nota_fiscal").focus();
        $("#hb-nfiscal").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function cadastrarEquipamentoExterno() {
    $('#mwEquipamento').window({
        href: home_uri + '/assistencia/equipamento/cadastrar',
        title: 'Cadastrar Equipamento',
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

function cadastrarProblemaManutencaoExterno() {
    $('#mwProblemaManutencao').window({
        href: home_uri + '/assistencia/problemamanutencao/cadastrar',
        title: 'Cadastrar Problema de Manutenção',
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

function editarChamadoExterno(spchamado_id) {
    $('#mwChamado').window({
        href: home_uri + "/suporte/chamado/editar/" + spchamado_id + "?pop=1",
        title: 'Editar Chamado',
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

function formaterManutencao(val) {
    if (val === false) {
        return 'Finalizado!';
    } else {
        return 'Em Aberto!';
    }
}

function styleManutencao(val) {
    if (val === false) {
        return 'background-color:green;color:white;font-weight:bold;';
    } else {
        return 'background-color:red;color:white;font-weight:bold;';
    }
}
