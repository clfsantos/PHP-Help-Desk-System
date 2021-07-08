$(function () {

    $('#cbEventoFollowup').combogrid({
        panelWidth: '100%',
        panelMaxWidth: 550,
        panelHeight: 308,
        url: home_uri + '/modulo/assistencia/view/EventoFollowupView.php',
        idField: 'id_evento',
        textField: 'id_evento',
        loadMsg: 'Carregando! Aguarde ...',
        mode: 'remote',
        fitColumns: true,
        pagination: true,
        striped: true,
        columns: [[
                {field: 'id_evento', title: 'ID', sortable: 'true', width: 100},
                {field: 'descricao_evento', title: 'Evento', sortable: 'true', width: 300}
            ]],
        onSelect: function (index, row) {
            $("#descricao_evento").val(row.descricao_evento);
        }
    });

    $('#info-evento').qtip({
        content: {
            title: 'Dica',
            text: "Para encontrar um evento rapidamente começe a digitar o nome do mesmo e o sistema completará a busca!"
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

});

function cadastrarFollowup() {
    var op = 'cadastrar';
    salvarFollowup(op);
}

function editarFollowup() {
    var op = 'editar';
    salvarFollowup(op);
}

function salvarFollowup(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var dados = $("#fmFollowup").serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/assistencia/controller/FollowupController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if ($("#mwFollowup").hasClass("window-body")) {
                $("#mwFollowup").window('close');
                $('#dgFollowup').datagrid('reload');
            } else {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        } else {
            emitirErrosFollowup(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function excluirFollowup() {
    var row = $('#dgFollowup').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este followup?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/FollowupController.php?op=excluir',
                    dataType: 'json',
                    data: {id_followup: row.id_followup}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgFollowup').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosFollowup(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o followup que deseja excluir');
    }
}

function cancelarFollowup() {
    if ($("#mwFollowup").hasClass("window-body")) {
        $("#mwFollowup").window('close');
    } else {
        window.history.back();
    }
}

function carregaGridFollowup(id_manutencao) {
    $('#dgFollowup').datagrid({
        url: home_uri + '/modulo/assistencia/view/FollowupView.php?id=' + id_manutencao,
        nowrap: false,
        singleSelect: true,
        pagination: true,
        collapsible: false,
        title: 'Follow-ups Lançados',
        onDblClickCell: function () {
            editarFollowup();
        },
        columns: [[
                {field: 'data_followup', title: 'Data', sortable: 'true', width: "15%"},
                {field: 'nome', title: 'Usuário', sortable: 'true', width: "15%"},
                {field: 'followup_conteudo', title: 'Conteudo', width: "50%"},
                {field: 'descricao_evento', title: 'Evento', width: "20%"}
            ]]
    });
    var pager = $('#dgFollowup').datagrid().datagrid('getPager');
    pager.pagination({
        buttons: [{
                iconCls: 'icon-add',
                handler: function () {
                    followupExterno('cadastrar', id_manutencao);
                }
            }, {
                iconCls: 'icon-edit',
                handler: function () {
                    var row = $('#dgFollowup').datagrid('getSelected');
                    if (row) {
                        followupExterno('editar', row.id_followup);
                    } else {
                        emitirMensagemAviso('Primeiro selecione o follow-up que deseja editar');
                    }
                }
            }, {
                iconCls: 'icon-remove',
                handler: function () {
                    excluirFollowup();
                }
            }]
    });
}

function emitirErrosFollowup(erro, errocod) {
    if (errocod === 102) {
        $("#cbEventoFollowup").textbox('textbox').focus();
        $("#hb-eventof-cb").html(erro);
    } else if (errocod === 104) {
        $("#followup_conteudo").focus();
        $("#hb-followup-m").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function followupExterno(op, id) {
    if (op === 'editar') {
        var url = home_uri + '/modulo/assistencia/form/followup.form.php?assistencia_id=0&op=editar&followup_id=' + id;
    } else {
        var url = home_uri + '/modulo/assistencia/form/followup.form.php?assistencia_id=' + id + '&op=cadastrar&followup_id=0';
    }
    $('#mwFollowup').window({
        href: url,
        title: 'Cadastrar Followup',
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