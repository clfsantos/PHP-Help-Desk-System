//function cadastrarAnexoChamado() {
//    var op = 'cadastrar';
//    salvarAnexoChamado(op);
//}
//
//function editarAnexoChamado() {
//    var op = 'editar';
//    salvarAnexoChamado(op);
//}
//
//function salvarAnexoChamado(op) {
//    limparErros();
//    $('button').attr('disabled', 'disabled');
//    $('.loada').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
//    $('#fmAnexoChamado').form('submit', {
//        url: home_uri + '/suporte/controller/AnexoChamadoController.php?op=' + op,
//        success: function (data) {
//            var retorno = eval('(' + data + ')');
//            if (retorno.sucesso) {
//                emitirMensagemSucesso(retorno.sucesso);
//                if ($("#mwAnexoChamado").hasClass("window-body")) {
//                    $("#mwAnexoChamado").window('close');
//                    $('#dgAnexoChamado').datagrid('reload');
//                } else {
//                    setTimeout(function () {
//                        location.reload();
//                    }, 1000);
//                }
//            } else {
//                emitirErrosAnexoChamado(retorno.erro, retorno.errocod);
//            }
//            $('.loada').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
//            $('button').removeAttr('disabled');
//        }
//    });
//}
//
//function excluirAnexoChamado() {
//    var row = $('#dgAnexoChamado').datagrid('getSelected');
//    if (row) {
//        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este anexo?', function (r) {
//            if (r) {
//                $.ajax({
//                    type: "POST",
//                    url: home_uri + '/suporte/controller/AnexoChamadoController.php?op=excluir',
//                    dataType: 'json',
//                    data: {id_arquivo: row.id_arquivo, caminho_arquivo: row.caminho_arquivo}
//                }).done(function (retorno) {
//                    if (retorno.sucesso) {
//                        $('#dgAnexoChamado').datagrid('reload');
//                        emitirMensagemSucesso(retorno.sucesso);
//                    } else {
//                        emitirErrosAnexoChamado(retorno.erro, retorno.errocod);
//                    }
//                });
//            }
//        });
//    } else {
//        emitirMensagemAviso('Primeiro selecione o anexo que deseja excluir');
//    }
//}
//
//function cancelarAnexoChamado() {
//    if ($("#mwAnexoChamado").hasClass("window-body")) {
//        $("#mwAnexoChamado").window('close');
//    } else {
//        window.history.back();
//    }
//}
//
//function limparAnexoChamado() {
//    $('#fmAnexoChamado').form('clear');
//}
//
//function carregaGridAnexoChamado(chamado_id) {
//    $('#dgAnexoChamado').datagrid({
//        url: home_uri + '/suporte/view/AnexoChamadoView.php?id=' + chamado_id,
//        nowrap: false,
//        singleSelect: true,
//        pagination: true,
//        collapsible: false,
//        title: 'Anexos Disponíveis',
//        onDblClickCell: function () {
//            editarAnexoChamado();
//        },
//        columns: [[
//                {field: 'spanexo_dt_up', title: 'Data', sortable: 'true', width: "25%"},
//                {field: 'spanexo_nome', title: 'Nome', sortable: 'true', width: "50%"},
//                {field: 'spanexo_caminho', title: 'Baixar', formatter: formaterAnexoChamado, width: "25%"}
//
//            ]]
//    });
//    var pager = $('#dgAnexoChamado').datagrid().datagrid('getPager'); // get the pager of datagrid
//    pager.pagination({
//        buttons: [{
//                iconCls: 'icon-add',
//                handler: function () {
//                    anexoChamadoExterno('cadastrar', chamado_id);
//                }
//            }, {
//                iconCls: 'icon-edit',
//                handler: function () {
//                    var row = $('#dgAnexoChamado').datagrid('getSelected');
//                    if (row) {
//                        anexoChamadoExterno('editar', row.id_arquivo);
//                    } else {
//                        emitirMensagemAviso('Primeiro selecione o anexo que deseja editar');
//                    }
//                }
//            }, {
//                iconCls: 'icon-remove',
//                handler: function () {
//                    excluirAnexoChamado();
//                }
//            }]
//    });
//}
//
//function anexoChamadoExterno(op, id) {
//    if (op === 'editar') {
//        var url = home_uri + '/suporte/form/anexo.form.php?chamado_id=0&op=editar&anexo_id=' + id;
//    } else {
//        var url = home_uri + '/suporte/form/anexo.form.php?chamado_id=' + id + '&op=cadastrar&anexo_id=0';
//    }
//    $('#mwAnexoChamado').window({
//        href: url,
//        title: 'Cadastrar Anexo',
//        modal: false,
//        maximized: true,
//        minimizable: false,
//        maximizable: false,
//        collapsible: false,
//        extractor: function (data) {
//            var pattern = /<div class="extractor">((.|[\n\r])*)<\/div><!--extractor-->/im;
//            var matches = pattern.exec(data);
//            if (matches) {
//                return matches[1];
//            } else {
//                return data;
//            }
//        }
//    });
//}
//
//function formaterAnexoChamado(val) {
//    return "<a href='" + home_uri + "/suporte/arquivos/baixar.php?arquivo=" + val + "' title='Clique para baixar'>Baixar</a>";
//}
//
//function emitirErrosAnexoChamado(erro, errocod) {
//    if (errocod === 102) {
//        $("#nome").textbox('textbox').focus();
//        $("#hb-nome").html(erro);
//    } else if (errocod === 103) {
//        $("#email").textbox('textbox').focus();
//        $("#hb-email").html(erro);
//    } else if (errocod === 104) {
//        $("#cbCidade").textbox('textbox').focus();
//        $("#hb-cidade").html(erro);
//    } else if (errocod === 105) {
//        $("#hb-lista").html(erro);
//    } else {
//        emitirMensagemErro(erro);
//    }
//}
