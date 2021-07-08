function cadastrarArquivo() {
    var op = 'cadastrar';
    salvarArquivo(op);
}

function editarArquivo() {
    var op = 'editar';
    salvarArquivo(op);
}

function salvarArquivo(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    $('#fmArquivo').form('submit', {
        url: home_uri + '/modulo/assistencia/controller/ArquivoController.php?op=' + op,
        success: function (data) {
            var retorno = eval('(' + data + ')');
            if (retorno.sucesso) {
                emitirMensagemSucesso(retorno.sucesso);
                if ($("#mwArquivo").hasClass("window-body")) {
                    $("#mwArquivo").window('close');
                    $('#dgArquivo').datagrid('reload');
                } else {
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            } else {
                emitirErrosArquivo(retorno.erro, retorno.errocod);
            }
            $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
            $('button').removeAttr('disabled');
        }
    });
}

function excluirArquivo() {
    var row = $('#dgArquivo').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este arquivo?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/assistencia/controller/ArquivoController.php?op=excluir',
                    dataType: 'json',
                    data: {id_arquivo: row.id_arquivo, caminho_arquivo: row.caminho_arquivo}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgArquivo').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosArquivo(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o arquivo que deseja excluir');
    }
}

function cancelarArquivo() {
    if ($("#mwArquivo").hasClass("window-body")) {
        $("#mwArquivo").window('close');
    } else {
        window.history.back();
    }
}

function carregaGridArquivo(id_manutencao) {
    $('#dgArquivo').datagrid({
        url: home_uri + '/modulo/assistencia/view/ArquivoView.php?id=' + id_manutencao,
        nowrap: false,
        singleSelect: true,
        pagination: true,
        collapsible: false,
        title: 'Arquivos Disponíveis',
        onDblClickCell: function () {
            editarArquivo();
        },
        columns: [[
                {field: 'data_upload', title: 'Data', sortable: 'true', width: "25%"},
                {field: 'nome_arquivo', title: 'Nome', sortable: 'true', width: "50%"},
                {field: 'caminho_arquivo', title: 'Baixar', formatter: formaterArquivo, width: "25%"}

            ]]
    });
    var pager = $('#dgArquivo').datagrid().datagrid('getPager'); // get the pager of datagrid
    pager.pagination({
        buttons: [{
                iconCls: 'icon-add',
                handler: function () {
                    arquivoExterno('cadastrar', id_manutencao);
                }
            }, {
                iconCls: 'icon-edit',
                handler: function () {
                    var row = $('#dgArquivo').datagrid('getSelected');
                    if (row) {
                        arquivoExterno('editar', row.id_arquivo);
                    } else {
                        emitirMensagemAviso('Primeiro selecione o arquivo que deseja editar');
                    }
                }
            }, {
                iconCls: 'icon-remove',
                handler: function () {
                    excluirArquivo();
                }
            }]
    });
}

function arquivoExterno(op, id) {
    if (op === 'editar') {
        var url = home_uri + '/modulo/assistencia/form/Arquivo.form.php?assistencia_id=0&op=editar&arquivo_id=' + id;
    } else {
        var url = home_uri + '/modulo/assistencia/form/Arquivo.form.php?assistencia_id=' + id + '&op=cadastrar&arquivo_id=0';
    }
    $('#mwArquivo').window({
        href: url,
        title: 'Cadastrar Arquivo',
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

function formaterArquivo(val) {
    return "<a href='" + home_uri + "/modulo/assistencia/arquivos/baixar.php?arquivo=" + val + "' title='Clique para baixar'>Baixar</a>";
}

function emitirErrosArquivo(erro, errocod) {
    if (errocod === 102) {
        $("#nome").textbox('textbox').focus();
        $("#hb-nome").html(erro);
    } else if (errocod === 103) {
        $("#email").textbox('textbox').focus();
        $("#hb-email").html(erro);
    } else if (errocod === 104) {
        $("#cbCidade").textbox('textbox').focus();
        $("#hb-cidade").html(erro);
    } else if (errocod === 105) {
        $("#hb-lista").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}
