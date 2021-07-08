$(function () {
    if ($('.guias').length > 0) {
        $('.guias').tabs({
            border: false,
            onSelect: function (title, index) {
                if ($('#tbChamados').length < 1) {
                    if (index > 1) {
                        $('.editar').css("display", "none");
                    } else {
                        $('.editar').css("display", "");
                    }
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    if (index > 1) {
                        p.find('.editar').css("display", "none");
                    } else {
                        p.find('.editar').css("display", "");
                    }
                }
            }
        });

        var spchamado_sla_data_vto_nft;
        var spchamado_aberto;
        var sptarefa_dt_tarefa;
        var sptarefa_duracao;
        var spchamado_transferir;

        if ($('#tbChamados').length < 1) {
            spchamado_sla_data_vto_nft = $('.spchamado_sla_data_vto_nft');
            spchamado_aberto = $('.spchamado_aberto');
            sptarefa_dt_tarefa = $('.sptarefa_dt_tarefa');
            sptarefa_duracao = $('.sptarefa_duracao');
            spchamado_transferir = $('.spchamado_transferir');
            $(".modal-toggle-e").click(function () {
                $(".md-equipamentos").modal();
            });
            $(".modal-toggle-c").click(function () {
                $(".md-contratos").modal();
            });
        } else {
            var p = $('#tbChamados').tabs('getSelected');
            spchamado_sla_data_vto_nft = p.find('.spchamado_sla_data_vto_nft');
            spchamado_aberto = p.find('.spchamado_aberto');
            sptarefa_dt_tarefa = p.find('.sptarefa_dt_tarefa');
            sptarefa_duracao = p.find('.sptarefa_duracao');
            spchamado_transferir = p.find('.spchamado_transferir');
            p.find(".modal-toggle-e").click(function () {
                p.find(".md-equipamentos").modal();
            });
            p.find(".modal-toggle-c").click(function () {
                p.find(".md-contratos").modal();
            });
        }

        $('.cbCliente').combogrid({
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
            rowStyler: function (index, row) {
                if (row.crcliente_bloqueado === true) {
                    return 'background-color:#ff5252;text-decoration:line-through;';
                }
            },
            columns: [[
                    {field: 'crcliente_id', title: 'ID', sortable: 'true', width: 100},
                    {field: 'is_cliente_mensalista', title: 'Mensalista', sortable: 'true', formatter: formatterMensalista, styler: styleMensalista, width: 100},
                    {field: 'crcliente_cnpj', title: 'CNPJ', formatter: formatterCNPJCPF, sortable: 'true', width: 200},
                    {field: 'crcliente_fantasia', title: 'Nome Fantasia', sortable: 'true', width: 300},
                    {field: 'crcliente_razao', title: 'Razão Social', sortable: 'true', width: 300}
                ]],
            onSelect: function (index, row) {
                if ($('#tbChamados').length < 1) {
                    $(".crcliente_razao").val(row.crcliente_razao);
                    $(".crcliente_fantasia").val(row.crcliente_fantasia);
                    $(".crcliente_cnpj").val(formatterCNPJCPF(row.crcliente_cnpj));
                    $(".crcliente_telefone").val(row.crcliente_telefone).mask("(99) 9999-9999?9");
                    $(".crcliente_contato").val(row.crcliente_contato);
                    if (row.is_cliente_mensalista === true) {
                        $(".crcliente_cd_junsoft").val("Sim");
                        $(".crcliente_cd_junsoft").removeClass("red-color");
                        $(".crcliente_cd_junsoft").addClass("green-color");
                    } else {
                        $(".crcliente_cd_junsoft").val("Não");
                        $(".crcliente_cd_junsoft").removeClass("green-color");
                        $(".crcliente_cd_junsoft").addClass("red-color");
                    }
                    if (row.email_ultima_pesquisa) {
                        $(".crcliente_email").val(row.email_ultima_pesquisa);
                    } else {
                        $(".crcliente_email").val(row.crcliente_email);
                    }
                    if (row.dt_ultima_pesquisa) {
                        $(".ultima-pesquisa").html('Última pesquisa: ' + row.dt_ultima_pesquisa);
                        $(".dt_ultima_pesquisa").val(row.dt_ultima_pesquisa);
                    } else {
                        $(".ultima-pesquisa").html('Pesquisa de satisfação pendente');
                        $(".dt_ultima_pesquisa").val('');
                    }
                    $.ajax({
                        type: "GET",
                        url: home_uri + '/modulo/suporte/view/ContratosClienteView.php?clienteid=' + row.crcliente_id,
                        dataType: 'json'
                    }).done(function (data) {
                        if (!jQuery.isEmptyObject(data)) {
                            var md = '<hr />';
                            for (i = 0; i < data.length; ++i) {
                                md += data[i]['contrato_desc'] + ' - ' + data[i]['contrato_qtd'] + '<hr />';
                            }
                        } else {
                            var md = '<hr />Sem contratos cadastrados!<hr />';
                        }
                        $('.contratos-conteudo').html(md);
                    });
                    $.ajax({
                        type: "GET",
                        url: home_uri + '/modulo/suporte/view/EquipamentoClienteCombo.php?clienteid=' + row.crcliente_id,
                        dataType: 'json'
                    }).done(function (data) {
                        if (!jQuery.isEmptyObject(data)) {
                            var md = '<hr />';
                            for (i = 0; i < data.length; ++i) {
                                if (data[i]['inativo'] === true) {
                                    md += '<span style="text-decoration:line-through;">' + data[i]['desc_nsr'] + '</span>' + '<hr />';
                                } else {
                                    md += data[i]['desc_nsr'] + '<hr />';
                                }
                            }
                        } else {
                            var md = '<hr />Sem equipamentos cadastrados!<hr />';
                        }
                        $('.equipamentos-conteudo').html(md);
                    });
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    p.find(".crcliente_razao").val(row.crcliente_razao);
                    p.find(".crcliente_fantasia").val(row.crcliente_fantasia);
                    p.find(".crcliente_cnpj").val(formatterCNPJCPF(row.crcliente_cnpj));
                    p.find(".crcliente_telefone").val(row.crcliente_telefone).mask("(99) 9999-9999?9");
                    p.find(".crcliente_contato").val(row.crcliente_contato);
                    if (row.is_cliente_mensalista === true) {
                        p.find(".crcliente_cd_junsoft").val("Sim");
                        p.find(".crcliente_cd_junsoft").removeClass("red-color");
                        p.find(".crcliente_cd_junsoft").addClass("green-color");
                    } else {
                        p.find(".crcliente_cd_junsoft").val("Não");
                        p.find(".crcliente_cd_junsoft").removeClass("green-color");
                        p.find(".crcliente_cd_junsoft").addClass("red-color");
                    }
                    if (row.email_ultima_pesquisa) {
                        p.find(".crcliente_email").val(row.email_ultima_pesquisa);
                    } else {
                        p.find(".crcliente_email").val(row.crcliente_email);
                    }
                    if (row.dt_ultima_pesquisa) {
                        p.find(".ultima-pesquisa").html('Última pesquisa: ' + row.dt_ultima_pesquisa);
                        p.find(".dt_ultima_pesquisa").val(row.dt_ultima_pesquisa);
                    } else {
                        p.find(".ultima-pesquisa").html('Pesquisa de satisfação pendente');
                        p.find(".dt_ultima_pesquisa").val('');
                    }
                    $.ajax({
                        type: "GET",
                        url: home_uri + '/modulo/suporte/view/ContratosClienteView.php?clienteid=' + row.crcliente_id,
                        dataType: 'json'
                    }).done(function (data) {
                        if (!jQuery.isEmptyObject(data)) {
                            var md = '<hr />';
                            for (i = 0; i < data.length; ++i) {
                                md += data[i]['contrato_desc'] + ' - ' + data[i]['contrato_qtd'] + '<hr />';
                            }
                        } else {
                            var md = '<hr />Sem contratos cadastrados!<hr />';
                        }
                        p.find('.contratos-conteudo').html(md);
                    });
                    $.ajax({
                        type: "GET",
                        url: home_uri + '/modulo/suporte/view/EquipamentoClienteCombo.php?clienteid=' + row.crcliente_id,
                        dataType: 'json'
                    }).done(function (data) {
                        if (!jQuery.isEmptyObject(data)) {
                            var md = '<hr />';
                            for (i = 0; i < data.length; ++i) {
                                if (data[i]['inativo'] === true) {
                                    md += '<span style="text-decoration:line-through;">' + data[i]['desc_nsr'] + '</span>' + '<hr />';
                                } else {
                                    md += data[i]['desc_nsr'] + '<hr />';
                                }
                            }
                        } else {
                            var md = '<hr />Sem equipamentos cadastrados!<hr />';
                        }
                        p.find('.equipamentos-conteudo').html(md);
                    });
                }
            }
        });

        $('.cbRelease').combogrid({
            panelWidth: '100%',
            panelMaxWidth: 550,
            panelHeight: 308,
            url: home_uri + '/modulo/suporte/view/ReleaseView.php',
            idField: 'spchamado_release_id',
            textField: 'spchamado_release_id',
            loadMsg: 'Carregando! Aguarde ...',
            mode: 'remote',
            fitColumns: true,
            pagination: true,
            striped: true,
            columns: [[
                    {field: 'spchamado_release_dt_fmt', title: 'Data', sortable: 'true', width: "30%"},
                    {field: 'spchamado_produto_desc', title: 'Produto', sortable: 'true', width: "40%"},
                    {field: 'spchamado_release_num', title: 'Release', width: "30%"}
                ]],
            onLoadSuccess: function (data) {
                if ($('#tbChamados').length < 1) {
                    var g = $('.cbRelease').combogrid('grid');
                    var row = g.datagrid('getSelected');
                    if (row) {
                        $(".spchamado_release_num").val(row.spchamado_release_num);
                    }
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    var g = p.find('.cbRelease').combogrid('grid');
                    var row = g.datagrid('getSelected');
                    if (row) {
                        p.find(".spchamado_release_num").val(row.spchamado_release_num);
                    }
                }
            },
            onSelect: function (index, row) {
                if ($('#tbChamados').length < 1) {
                    $(".spchamado_release_num").val(row.spchamado_release_num);
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    p.find(".spchamado_release_num").val(row.spchamado_release_num);
                }
            }
        });

        $('.cbOrigem').combobox({
            url: home_uri + '/modulo/suporte/view/OrigemChamadoCombo.php',
            valueField: 'spchamado_origem_id',
            textField: 'spchamado_origem_desc',
            editable: false
        });

        $('.cbSLA').combobox({
            url: home_uri + '/modulo/suporte/view/SLAChamadoCombo.php',
            valueField: 'spchamado_sla_id',
            textField: 'spchamado_sla_desc',
            editable: false,
            onSelect: function (row) {
                if ($('#tbChamados').length < 1) {
                    $('.spchamado_sla_data_vto_nft').textbox('clear');
                    if (row.spchamado_sla_id === 4) {
                        $('.spchamado_sla_data_vto_nft').textbox('enable');
                    } else {
                        $('.spchamado_sla_data_vto_nft').textbox('disable');
                    }
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    p.find('.spchamado_sla_data_vto_nft').textbox('clear');
                    if (row.spchamado_sla_id === 4) {
                        p.find('.spchamado_sla_data_vto_nft').textbox('enable');
                    } else {
                        p.find('.spchamado_sla_data_vto_nft').textbox('disable');
                    }
                }
            }
        });

        $('.cbClass').combobox({
            url: home_uri + '/modulo/suporte/view/ClassificacaoChamadoCombo.php',
            valueField: 'spchamado_class_id',
            textField: 'spchamado_class_desc',
            editable: false,
            onLoadSuccess: function (data) {
                if ($('#tbChamados').length < 1) {
                    var pos = $('.cbClass').combobox('getValue');
					if (data[pos - 1].spchamado_class_id === 3) {
						$(".spchamado_ocorrencia").attr('rows', '20');
					}
                    $('.info-class').qtip({
                        content: {
                            title: 'Descrição da Classificação',
                            text: data[pos - 1].spchamado_class_obs
                        },
                        position: {
                            my: 'top left',
                            at: 'bottom center'
                        },
                        style: {
                            classes: 'qtip-dark qtip-shadow'
                        }
                    });
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    var pos = p.find('.cbClass').combobox('getValue');
					if (data[pos - 1].spchamado_class_id === 3) {
						p.find(".spchamado_ocorrencia").attr('rows', '20');
					}
                    p.find('.info-class').qtip({
                        content: {
                            title: 'Descrição da Classificação',
                            text: data[pos - 1].spchamado_class_obs
                        },
                        position: {
                            my: 'top left',
                            at: 'bottom center'
                        },
                        style: {
                            classes: 'qtip-dark qtip-shadow'
                        }
                    });
                }
            },
            onSelect: function (row) {
                if ($('#tbChamados').length < 1) {
					if (row.spchamado_class_id === 3) {
						$(".spchamado_ocorrencia").html("DADOS CLIENTE \nContato da pessoa que irá utilizar o sistema EPM: \nTelefone: \nE-mail: \nResponsável pelo T.I da empresa: \nEndereço para implantação presencial (quando presencial):] \n\nPLANO CONTRATADO \nN° FUNCIONÁRIOS: \nN° MOBILE: \nFACIAL: \nQR CODE: \nEQUIPAMENTO: \n\nDADOS CONTABILIDADE \nEscritório contábil: \nPessoa responsável pela folha de pagamento: \nTelefone: \nE-mail:");
						$(".spchamado_ocorrencia").attr('rows', '20');
					}
                    $('.info-class').qtip({
                        content: {
                            title: 'Descrição da Classificação',
                            text: row.spchamado_class_obs
                        },
                        position: {
                            my: 'top left',
                            at: 'bottom center'
                        },
                        style: {
                            classes: 'qtip-dark qtip-shadow'
                        }
                    });
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
					if (row.spchamado_class_id === 3) {
						p.find(".spchamado_ocorrencia").html("DADOS CLIENTE \nContato da pessoa que irá utilizar o sistema EPM: \nTelefone: \nE-mail: \nResponsável pelo T.I da empresa: \nEndereço para implantação presencial (quando presencial):] \n\nPLANO CONTRATADO \nN° FUNCIONÁRIOS: \nN° MOBILE: \nFACIAL: \nQR CODE: \nEQUIPAMENTO: \n\nDADOS CONTABILIDADE \nEscritório contábil: \nPessoa responsável pela folha de pagamento: \nTelefone: \nE-mail:");
						p.find(".spchamado_ocorrencia").attr('rows', '20');
					}
                    p.find('.info-class').qtip({
                        content: {
                            title: 'Descrição da Classificação',
                            text: row.spchamado_class_obs
                        },
                        position: {
                            my: 'top left',
                            at: 'bottom center'
                        },
                        style: {
                            classes: 'qtip-dark qtip-shadow'
                        }
                    });
                }
            }
        });

        $('.cbProduto').combobox({
            url: home_uri + '/modulo/suporte/view/ProdutoChamadoCombo.php',
            valueField: 'spchamado_produto_id',
            textField: 'spchamado_produto_desc',
            editable: false,
            onLoadSuccess: function (data) {
                if ($('#tbChamados').length < 1) {
                    var pos = $('.cbProduto').combobox('getValue');
                    var url = home_uri + '/modulo/suporte/view/GrupoChamadoCombo.php?pid=' + pos;
                    $('.cbGrupo').combobox('reload', url);
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    var pos = p.find('.cbProduto').combobox('getValue');
                    var url = home_uri + '/modulo/suporte/view/GrupoChamadoCombo.php?pid=' + pos;
                    p.find('.cbGrupo').combobox('reload', url);
                }
            },
            onSelect: function (row) {
                if ($('#tbChamados').length < 1) {
                    $('.cbGrupo').combobox('clear');
                    $('.cbSubGrupo').combobox('clear');
                    var url = home_uri + '/modulo/suporte/view/GrupoChamadoCombo.php?pid=' + row.spchamado_produto_id;
                    $('.cbGrupo').combobox('reload', url);
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    p.find('.cbGrupo').combobox('clear');
                    p.find('.cbSubGrupo').combobox('clear');
                    var url = home_uri + '/modulo/suporte/view/GrupoChamadoCombo.php?pid=' + row.spchamado_produto_id;
                    p.find('.cbGrupo').combobox('reload', url);
                }
            }
        });

        $(".cbGrupo").combobox({
            valueField: 'spchamado_grupo_id',
            textField: 'spchamado_grupo_desc',
            onLoadSuccess: function (data) {
                if ($('#tbChamados').length < 1) {
                    var pos = $('.cbGrupo').combobox('getValue');
                    var url = home_uri + '/modulo/suporte/view/SubGrupoChamadoCombo.php?gid=' + pos;
                    $('.cbSubGrupo').combobox('reload', url);
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    var pos = p.find('.cbGrupo').combobox('getValue');
                    var url = home_uri + '/modulo/suporte/view/SubGrupoChamadoCombo.php?gid=' + pos;
                    p.find('.cbSubGrupo').combobox('reload', url);
                }
            },
            onSelect: function (row) {
                if ($('#tbChamados').length < 1) {
                    $('.cbSubGrupo').combobox('clear');
                    var url = home_uri + '/modulo/suporte/view/SubGrupoChamadoCombo.php?gid=' + row.spchamado_grupo_id;
                    $('.cbSubGrupo').combobox('reload', url);
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    p.find('.cbSubGrupo').combobox('clear');
                    var url = home_uri + '/modulo/suporte/view/SubGrupoChamadoCombo.php?gid=' + row.spchamado_grupo_id;
                    p.find('.cbSubGrupo').combobox('reload', url);
                }
            }
        });

        $(".cbSubGrupo").combobox({
            valueField: 'spchamado_subgrupo_id',
            textField: 'spchamado_subgrupo_desc'
        });

        $('.cbTipo').combobox({
            editable: false,
            onSelect: function (row) {
                if ($('#tbChamados').length < 1) {
                    if (row.value === '2') {
                        $('.cbUsuario').combobox('enable');
                    } else {
                        $('.cbUsuario').combobox('disable');
                    }
                } else {
                    var p = $('#tbChamados').tabs('getSelected');
                    if (row.value === '2') {
                        p.find('.cbUsuario').combobox('enable');
                    } else {
                        p.find('.cbUsuario').combobox('disable');
                    }
                }
            }
        });

        $('.cbUsuario').combobox({
            url: home_uri + '/modulo/geral/view/UsuariosTecCombo.php',
            valueField: 'id',
            textField: 'nome',
            editable: false,
            disabled: true
        });

        $('.cbUsuarioTarefa').combobox({
            url: home_uri + '/modulo/geral/view/UsuariosTecCombo.php',
            valueField: 'id',
            textField: 'nome',
            editable: false
        });

        $('.dlgOBSImplantacao').dialog({
            buttons: '.dlg-obs-implantacao'
        });

        $('.info-cliente').qtip({
            content: {
                title: 'Dica',
                text: 'Pesquise pelo nome fantasia, razão social ou CNPJ (Sem pontuação) para encontrar o cliente facilmente. Acentuação faz diferença na hora da busca.'
            },
            position: {
                my: 'top left',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-dark qtip-shadow'
            }
        });

        $('.info-email').qtip({
            content: {
                title: 'Pesquisa de Satisfação',
                text: 'O e-mail cadastrado no Junsoft será preenchido automaticamente. Em caso de divergência fazer a edição. Ele será o e-mail utilizado para a pesquisa de satisfação'
            },
            position: {
                my: 'top left',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-dark qtip-shadow'
            }
        });

        $('.info-release').qtip({
            content: {
                title: 'Informação',
                text: 'Este campo é para uso exclusivo da programação, não é necessário preencher na abertura de um chamado normal'
            },
            position: {
                my: 'top left',
                at: 'bottom center'
            },
            style: {
                classes: 'qtip-dark qtip-shadow'
            }
        });

        spchamado_aberto.iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square'
        });

        spchamado_transferir.iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square'
        });

        spchamado_sla_data_vto_nft.datetimebox({
            disabled: true,
            formatter: function (date) {
                var y = date.getFullYear();
                var m = date.getMonth() + 1;
                var d = date.getDate();
                var h = date.getHours();
                var mim = date.getMinutes();
                var sec = date.getSeconds();
                return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y + ' ' + (h < 10 ? ('0' + h) : h) + ':' + (mim < 10 ? ('0' + mim) : mim) + ':' + (sec < 10 ? ('0' + sec) : sec);
            },
            parser: function (s) {
                if (!s) {
                    return new Date();
                }
                var dt = s.substring(0, 10);
                var hr = s.substring(11);
                var ss = dt.split('/');
                var hrs = hr.split(':');
                var y = parseInt(ss[0], 10);
                var m = parseInt(ss[1], 10);
                var d = parseInt(ss[2], 10);
                var h = parseInt(hrs[0], 10);
                var mim = parseInt(hrs[1], 10);
                var sec = parseInt(hrs[2], 10);
                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                    return new Date(d, m - 1, y, h, mim, sec);
                } else {
                    return new Date();
                }
            }
        }).textbox('textbox').mask("99/99/9999 99:99:99");

        sptarefa_dt_tarefa.datetimebox({
            showSeconds: false,
            formatter: function (date) {
                var y = date.getFullYear();
                var m = date.getMonth() + 1;
                var d = date.getDate();
                var h = date.getHours();
                var mim = date.getMinutes();
                return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y + ' ' + (h < 10 ? ('0' + h) : h) + ':' + (mim < 10 ? ('0' + mim) : mim);
            },
            parser: function (s) {
                if (!s) {
                    return new Date();
                }
                var dt = s.substring(0, 10);
                var hr = s.substring(11);
                var ss = dt.split('/');
                var hrs = hr.split(':');
                var y = parseInt(ss[0], 10);
                var m = parseInt(ss[1], 10);
                var d = parseInt(ss[2], 10);
                var h = parseInt(hrs[0], 10);
                var mim = parseInt(hrs[1], 10);
                if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                    return new Date(d, m - 1, y, h, mim);
                } else {
                    return new Date();
                }
            }
        }).textbox('textbox').mask("99/99/9999 99:99");

        sptarefa_duracao.mask("99:99");

        if ($('#tbChamados').length < 1) {
            if ($(".crcliente_cnpj").length > 0) {
                if ($(".crcliente_cnpj").val().length === 14) {
                    $(".crcliente_cnpj").mask("99.999.999/9999-99");
                } else {
                    $(".crcliente_cnpj").mask("999.999.999-99");
                }

                if ($(".crcliente_telefone").val().length > 9) {
                    $(".crcliente_telefone").mask("(99) 9999-9999?9");
                }
            }
            carregaGridAnexoChamado(cid, null);
            carregaGridChamadoFollowup(cid, null);
            carregaGridChamadoTarefa(cid, null);
            carregaGridImplantacao(cid, null);
            carregaEtapaImplantacaoInfo(cid, null);
            carregarDropZone('div.dropzone.dzAnexoChamado', cid, 'e');
        }

    } else {
        $('#tbChamados').tabs({
            border: false,
            onSelect: function (title, index) {
                var p = $('#tbChamados').tabs('getSelected');
                if (title !== 'Novo') {
                    var gridf = p.find('table.dgFollowupChamado');
                    var grida = p.find('table.dgAnexoChamado');
                    gridf.datagrid('load', home_uri + '/modulo/suporte/view/FollowupChamadoView.php?id=' + title);
                    grida.datagrid('load', home_uri + '/modulo/suporte/view/AnexoChamadoView.php?id=' + title);
                }
            },
            onLoad: function (panel) {
                var p = $('#tbChamados').tabs('getSelected');
                var chamado = panel.panel('options').title;
                carregaGridChamadoFollowup(chamado, p);
                carregaGridAnexoChamado(chamado, p);
                carregaGridChamadoTarefa(chamado, p);
                carregaGridImplantacao(chamado, p);
                carregaEtapaImplantacaoInfo(chamado, p);
                carregarDropZone(p, chamado, 't');

                if (p.find(".crcliente_cnpj").length > 0) {
                    if (p.find(".crcliente_cnpj").val().length === 14) {
                        p.find(".crcliente_cnpj").mask("99.999.999/9999-99");
                    } else {
                        p.find(".crcliente_cnpj").mask("999.999.999-99");
                    }

                    if (p.find(".crcliente_telefone").val().length > 9) {
                        p.find(".crcliente_telefone").mask("(99) 9999-9999?9");
                    }
                }
            }
        });

        $('#dgChamado').datagrid({
            url: home_uri + '/modulo/suporte/view/ChamadoView.php',
            singleSelect: true,
            pagination: true,
            collapsible: false,
            toolbar: '#toolbar',
            border: false,
            onDblClickCell: function () {
                editarChamadoPg();
            },
            rowStyler: function (index, row) {
                if (row.spchamado_cancelado === true) {
                    return 'background-color:#ff5252;';
                } else if (row.spchamado_aberto === false) {
                    return 'background-color:#BDBDBD;';
                } else if (row.spchamado_sla_vencido === true) {
                    return 'background-color:#FFAB40;';
                }
            },
            columns: [[
                    {field: 'spchamado_id', title: 'ID', sortable: 'true', width: "5%"},
                    {field: 'spchamado_dt_abertura_nft', title: 'Aberto em', sortable: 'true', width: "15%"},
                    {field: 'spchamado_ocorrencia', title: 'Ocorrência', width: "30%"},
                    {field: 'crcliente_fantasia', title: 'Cliente', sortable: 'true', width: "20%"},
                    {field: 'spchamado_responsavel_nome', title: 'Aberto por', sortable: 'true', width: "7%"},
                    {field: 'spchamado_resp_atual_nome', title: 'Responsável', sortable: 'true', width: "8%"},
                    {field: 'spchamado_aberto', title: 'Situação', sortable: 'true', formatter: formatterSituacao, width: "10%"},
					{field: 'temanexo', title: 'Anexo', sortable: 'true', formatter: formatterAnexo, width: "5%"}
                ]]
        });

        $('#cbUsuarioFiltro').combobox({
            url: home_uri + '/modulo/geral/view/UsuariosTecCombo.php?users=todos',
            valueField: 'id',
            textField: 'nome',
            editable: false,
            onLoadSuccess: function (data) {
                pesquisarChamado();
            },
            onSelect: function (row) {
                pesquisarChamado();
            }
        });

        $('#statusBusca').combobox({
            editable: false,
            onSelect: function (row) {
                pesquisarChamado();
            }
        });

        if (checkCookie('filtroChamado')) {
            $('#statusBusca').combobox('setValue', getCookie('filtroChamado'));
            pesquisarChamado();
        }

    }

    if ($(document).height() > $(window).height()) {
        $("body").panel("doLayout");
    }

});

function carregarDropZone(p, chamado, src) {
    var elemento;
    var dg;
    if (src === 'e') {
        elemento = p;
        dg = $('table.dgAnexoChamado');
    } else {
        var dz = p.find('div.dropzone.dzAnexoChamado');
        dg = p.find('table.dgAnexoChamado');
        elemento = dz.get(0);
    }
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone(elemento, {
        url: home_uri + "/modulo/suporte/controller/AnexoChamadoController.php",
        maxFilesize: 100,
        acceptedFiles: 'image/*,.txt,.zip,.rar,.backup,.pdf',
        success: function (file, response, action) {
            var retorno = jQuery.parseJSON(response);
            if (retorno.erro) {
                emitirMensagemErro(retorno.erro);
            }
        },
        error: function (file, response) {
            emitirMensagemErro(response);
        }
    });

    myDropzone.on("sending", function (file, xhr, formData) {
        formData.append("op", "cadastrar");
        formData.append("chamado_id", chamado);
    });

    myDropzone.on("queuecomplete", function () {
        emitirMensagemSucesso("Arquivos enviados com sucesso!");
        dg.datagrid('reload');
    });
}

function assumirChamado() {
    var op = 'assumir';
    salvarChamado(op);
}

function cadastrarChamado() {
    var op = 'cadastrar';
    salvarChamado(op);
}

function cadastrarChamadoPg() {
    $('#tbChamados').tabs('add', {
        title: "Novo",
        href: home_uri + "/suporte/chamado/cadastrar/?pop=1",
        closable: true,
        border: false,
        extractor: function (data) {
            data = $.fn.panel.defaults.extractor(data);
            var tmp = $('<div></div>').html(data);
            data = tmp.find('.extractor').html();
            tmp.remove();
            return data;
        }
    });
}

function cadastrarFollowupChamado() {
    var op = 'cadastrar';
    salvarFollowupChamado(op);
}

function editarChamado() {
    var op = 'editar';
    salvarChamado(op);
}

function editarChamadoPg() {
    var row = $('#dgChamado').datagrid('getSelected');
    if (row) {
        if ($('#tbChamados').tabs('exists', "" + row.spchamado_id + "")) {
            $('#tbChamados').tabs('select', "" + row.spchamado_id + "");
        } else {
            $('#tbChamados').tabs('add', {
                title: "" + row.spchamado_id + "",
                href: home_uri + "/suporte/chamado/editar/" + row.spchamado_id + "?pop=1",
                closable: true,
                border: false,
                extractor: function (data) {
                    data = $.fn.panel.defaults.extractor(data);
                    var tmp = $('<div></div>').html(data);
                    data = tmp.find('.extractor').html();
                    tmp.remove();
                    return data;
                }
            });
        }

    } else {
        emitirMensagemAviso('Selecione o chamado que deseja editar!');
    }
}

function editarFollowupChamado() {
    var op = 'editar';
    salvarFollowupChamado(op);
}

function cancelarChamado() {
    var row = $('#dgChamado').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja cancelar este chamado?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/ChamadoController.php?op=cancelar',
                    dataType: 'json',
                    data: {spchamado_id: row.spchamado_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        $('#dgChamado').datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosChamado(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione a manutenção que deseja excluir');
    }
}

function excluirFollowupChamado(chamado_id, gridf) {
    var row = gridf.datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja cancelar este followup?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/FollowupChamadoController.php?op=excluir',
                    dataType: 'json',
                    data: {spfollowup_id: row.spfollowup_id, spchamado_id: chamado_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        gridf.datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosFollowupChamado(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o followup que deseja cancelar');
    }
}

function excluirTarefaChamado(chamado_id, gridt) {
    var row = gridt.datagrid('getSelected');
    if (row) {
        if (row.sptarefa_status === true) {
            emitirMensagemAviso('Tarefas concluídas não podem ser excluidas');
        } else {
            $.messager.confirm('Confirme', 'Tem certeza que deseja cancelar esta tarefa?', function (r) {
                if (r) {
                    $.ajax({
                        type: "POST",
                        url: home_uri + '/modulo/suporte/controller/TarefaChamadoController.php?op=excluir',
                        dataType: 'json',
                        data: {sptarefa_id: row.sptarefa_id, spchamado_id: chamado_id}
                    }).done(function (retorno) {
                        if (retorno.sucesso) {
                            gridt.datagrid('reload');
                            emitirMensagemSucesso(retorno.sucesso);
                        } else {
                            emitirErrosTarefaChamado(retorno.erro, retorno.errocod);
                        }
                    });
                }
            });
        }
    } else {
        emitirMensagemAviso('Primeiro selecione o agendamento que deseja excluir');
    }
}

function excluirAnexoChamado(chamado_id, grida) {
    var row = grida.datagrid('getSelected');
    if (row) {
        $.messager.confirm('Confirme', 'Tem certeza que deseja excluir este anexo?', function (r) {
            if (r) {
                $.ajax({
                    type: "POST",
                    url: home_uri + '/modulo/suporte/controller/AnexoChamadoController.php?op=excluir',
                    dataType: 'json',
                    data: {spanexo_id: row.spanexo_id, spanexo_caminho: row.spanexo_caminho, chamado_id: chamado_id}
                }).done(function (retorno) {
                    if (retorno.sucesso) {
                        grida.datagrid('reload');
                        emitirMensagemSucesso(retorno.sucesso);
                    } else {
                        emitirErrosAnexoChamado(retorno.erro, retorno.errocod);
                    }
                });
            }
        });
    } else {
        emitirMensagemAviso('Primeiro selecione o anexo que deseja excluir');
    }
}

function salvarChamado(op) {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.load').html('<img src="' + home_uri + '/images/bt-loader.gif" /> ' + op);
    var fm;
    var p;
    if ($('#tbChamados').length < 1) {
        p = 'e';
        fm = $('form.fmChamado');
    } else {
        p = $('#tbChamados').tabs('getSelected');
        fm = p.find('form.fmChamado');
    }
    var dados = fm.serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/ChamadoController.php?op=' + op,
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if (p === 'e') {
                location.reload();
            } else {
                if (retorno.lastid) {
                    var lastID = retorno.lastid;
                    $('#tbChamados').tabs('update', {
                        tab: p,
                        options: {
                            title: lastID
                        }
                    });
                    p.panel('refresh', home_uri + '/suporte/chamado/editar/' + lastID + '?pop=1');
                    $('#dgChamado').datagrid('reload');
                } else {
                    p.panel('refresh');
                    $('#dgChamado').datagrid('reload');
                }
            }
        } else {
            emitirErrosChamado(retorno.erro, retorno.errocod);
        }
        $('.load').html('<span class="glyphicon glyphicon-ok"></span> ' + op);
        $('button').removeAttr('disabled');
    });
}

function salvarChamadoFollowup() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.loadf').html('<img src="' + home_uri + '/images/bt-loader.gif" /> Salvar');
    var fm;
    var gridf;
    var p;
    if ($('#tbChamados').length < 1) {
        p = 'e';
        fm = $('form.fmChamado');
        gridf = $('table.dgFollowupChamado');
    } else {
        p = $('#tbChamados').tabs('getSelected');
        fm = p.find('form.fmChamado');
        gridf = p.find('table.dgFollowupChamado');
    }
    var dados = fm.serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/FollowupChamadoController.php',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if (retorno.troca === 'S' && p === 'e') {
                location.reload();
            } else if (retorno.troca === 'S') {
                p.panel('refresh');
                $('#dgChamado').datagrid('reload');
            } else {
                fm.form('load', {
                    spfollowup_id: '',
                    spfollowup_tipo: '1',
                    spfollowup_usuario_trans: '',
                    spfollowup_conteudo: ''
                });
                gridf.datagrid('reload');
            }
        } else {
            emitirErrosFollowupChamado(retorno.erro, retorno.errocod);
        }
        $('.loadf').html('<span class="glyphicon glyphicon-ok"></span> Salvar');
        $('button').removeAttr('disabled');
    });
}

function salvarChamadoTarefa() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.loadt').html('<img src="' + home_uri + '/images/bt-loader.gif" /> Salvar');
    var fm;
    var gridt;
    var p;
    if ($('#tbChamados').length < 1) {
        p = 'e';
        fm = $('form.fmChamado');
        gridt = $('table.dgTarefaChamado');
    } else {
        p = $('#tbChamados').tabs('getSelected');
        fm = p.find('form.fmChamado');
        gridt = p.find('table.dgTarefaChamado');
    }
    var dados = fm.serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/TarefaChamadoController.php',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if (p === 'e') {
                location.reload();
            } else {
                fm.form('load', {
                    sptarefa_id: '',
                    sptarefa_dt_tarefa: '',
                    sptarefa_duracao: '',
                    sptarefa_u_atribuido: '',
                    sptarefa_status: '0',
                    sptarefa_titulo: '',
                    sptarefa_desc: ''
                });
                gridt.datagrid('reload');
            }
        } else {
            emitirErrosTarefaChamado(retorno.erro, retorno.errocod);
        }
        $('.loadt').html('<span class="glyphicon glyphicon-ok"></span> Salvar');
        $('button').removeAttr('disabled');
    });
}

function concluirEtapa() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.loadtc').html('<img src="' + home_uri + '/images/bt-loader.gif" /> Concluir');
    var fm;
    var gridt;
    var p;
    if ($('#tbChamados').length < 1) {
        p = 'e';
        fm = $('form.fmChamado');
        gridt = $('table.dgImplantacaoChamado');
    } else {
        p = $('#tbChamados').tabs('getSelected');
        fm = p.find('form.fmChamado');
        gridt = p.find('table.dgImplantacaoChamado');
    }
    var dados = fm.serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/EtapaImplantacaoController.php?op=concluir',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if (p === 'e') {
                $(".fmEtapaAprovada").css("display", "none");
                fm.form('load', {
                    etapa_id: '',
                    etapa_obs: ''
                });
                gridt.datagrid('reload');
            } else {
                p.find(".fmEtapaAprovada").css("display", "none");
                fm.form('load', {
                    etapa_id: '',
                    etapa_obs: ''
                });
                gridt.datagrid('reload');
            }
        } else {
            emitirErrosEtapaImplantacao(retorno.erro, retorno.errocod);
        }
        $('.loadtc').html('<span class="glyphicon glyphicon-ok"></span> Concluir');
        $('button').removeAttr('disabled');
    });
}

function salvarEtapa() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.loadts').html('<img src="' + home_uri + '/images/bt-loader.gif" /> Salvar');
    var fm;
    var gridt;
    var p;
    if ($('#tbChamados').length < 1) {
        p = 'e';
        fm = $('form.fmChamado');
        gridt = $('table.dgImplantacaoChamado');
    } else {
        p = $('#tbChamados').tabs('getSelected');
        fm = p.find('form.fmChamado');
        gridt = p.find('table.dgImplantacaoChamado');
    }
    var dados = fm.serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/EtapaImplantacaoController.php?op=salvar',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if (p === 'e') {
                $(".fmEtapaAprovada").css("display", "none");
                fm.form('load', {
                    etapa_id: '',
                    etapa_obs: ''
                });
                gridt.datagrid('reload');
            } else {
                p.find(".fmEtapaAprovada").css("display", "none");
                fm.form('load', {
                    etapa_id: '',
                    etapa_obs: ''
                });
                gridt.datagrid('reload');
            }
        } else {
            emitirErrosEtapaImplantacao(retorno.erro, retorno.errocod);
        }
        $('.loadts').html('<span class="fa fa-floppy-o"></span> Salvar');
        $('button').removeAttr('disabled');
    });
}

function concluirEtapaPendente(chamado_id, gridt, fmeta, fmetr) {
    var row = gridt.datagrid('getSelected');
    if (row) {
        if (row.etapa_status_id !== 3) {
            emitirMensagemAviso('Somente etapas pendentes podem ser alteradas');
        } else {
            $.messager.confirm('Confirme', 'Tem certeza que deseja aprovar esta etapa?', function (r) {
                if (r) {
                    $.ajax({
                        type: "POST",
                        url: home_uri + '/modulo/suporte/controller/EtapaImplantacaoController.php?op=aprovar',
                        dataType: 'json',
                        data: {etapa_id: row.id, spchamado_id: chamado_id}
                    }).done(function (retorno) {
                        if (retorno.sucesso) {
                            fmeta.css("display", "none");
                            fmetr.css("display", "none");
                            gridt.datagrid('reload');
                            emitirMensagemSucesso(retorno.sucesso);
                        } else {
                            emitirErrosTarefaChamado(retorno.erro, retorno.errocod);
                        }
                    });
                }
            });
        }
    } else {
        emitirMensagemAviso('Primeiro selecione a etapa que deseja aprovar');
    }
}

function recusarEtapaPendente() {
    limparErros();
    $('button').attr('disabled', 'disabled');
    $('.loadt').html('<img src="' + home_uri + '/images/bt-loader.gif" /> Salvar');
    var fm;
    var gridt;
    var p;
    if ($('#tbChamados').length < 1) {
        p = 'e';
        fm = $('form.fmChamado');
        gridt = $('table.dgImplantacaoChamado');
    } else {
        p = $('#tbChamados').tabs('getSelected');
        fm = p.find('form.fmChamado');
        gridt = p.find('table.dgImplantacaoChamado');
    }
    var dados = fm.serialize();
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/controller/EtapaImplantacaoController.php?op=recusar',
        dataType: 'json',
        data: dados
    }).done(function (retorno) {
        if (retorno.sucesso) {
            emitirMensagemSucesso(retorno.sucesso);
            if (p === 'e') {
                $(".fmEtapaRecusada").css("display", "none");
                fm.form('load', {
                    etapa_id_r: '',
                    etapa_obs_r: ''
                });
                gridt.datagrid('reload');
            } else {
                p.find(".fmEtapaRecusada").css("display", "none");
                fm.form('load', {
                    etapa_id_r: '',
                    etapa_obs_r: ''
                });
                gridt.datagrid('reload');
            }
        } else {
            emitirErrosEtapaImplantacao(retorno.erro, retorno.errocod);
        }
        $('.loadt').html('<span class="glyphicon glyphicon-ok"></span> Salvar');
        $('button').removeAttr('disabled');
    });
}

function pesquisarChamadoCont() {
    if ($('#busca').val().length > 2) {
        pesquisarChamado();
    }
}

function pesquisarChamado() {
    setCookie('filtroChamado', $('#statusBusca').combobox('getValue'), 1);
    $('#dgChamado').datagrid('load', {
        q: $('#busca').val(),
        status: $('#statusBusca').combobox('getValue'),
        user: $("#cbUsuarioFiltro").combobox('getValue')
    });
}

function carregaGridChamadoFollowup(chamado_id, p) {
    var gridf;
    var fm;
    if (p === null) {
        gridf = $('table.dgFollowupChamado');
        fm = $('form.fmChamado');
    } else {
        gridf = p.find('table.dgFollowupChamado');
        fm = p.find('form.fmChamado');
    }
    gridf.datagrid({
        url: home_uri + '/modulo/suporte/view/FollowupChamadoView.php?id=' + chamado_id,
        nowrap: false,
        singleSelect: true,
        pagination: true,
        rowStyler: function (index, row) {
            if (row.cancelado === true) {
                return 'background-color:#f44336;';
            } else if (row.spfollowup_tipo === 2) {
                return 'background-color:#B0BEC5;';
            }
        },
        columns: [[
                {field: 'spfollowup_dt_ft', title: 'Data', sortable: 'true', width: "20%"},
                {field: 'spfollowup_conteudo', title: 'Conteudo', width: "50%"},
                {field: 'spfollowup_usuario_nome', title: 'Usuário', sortable: 'true', width: "10%"},
                {field: 'spfollowup_usuario_trans_nome', title: 'Transferido para', sortable: 'true', width: "20%"}
            ]]
    });
    var pager = gridf.datagrid().datagrid('getPager');
    pager.pagination({
        buttons: [{
                iconCls: 'icon-edit',
                handler: function () {
                    var row = gridf.datagrid('getSelected');
                    if (row) {
                        if (row.cancelado === true) {
                            emitirMensagemAviso('Follow-ups cancelados não podem ser editados');
                        } else {
                            fm.form('load', {
                                spfollowup_id: row.spfollowup_id,
                                spfollowup_conteudo: row.spfollowup_conteudo
                            });
                        }
                    } else {
                        emitirMensagemAviso('Primeiro selecione o follow-up que deseja editar');
                    }
                }
            }, {
                iconCls: 'icon-remove',
                handler: function () {
                    excluirFollowupChamado(chamado_id, gridf);
                }
            }]
    });
}

function carregaGridChamadoTarefa(chamado_id, p) {
    var gridt;
    var fm;
    if (p === null) {
        gridt = $('table.dgTarefaChamado');
        fm = $('form.fmChamado');
    } else {
        gridt = p.find('table.dgTarefaChamado');
        fm = p.find('form.fmChamado');
    }
    gridt.datagrid({
        url: home_uri + '/modulo/suporte/view/TarefaChamadoView.php?id=' + chamado_id,
        nowrap: false,
        singleSelect: true,
        pagination: true,
        rowStyler: function (index, row) {
            if (row.sptarefa_status === true && row.sptarefa_cancelada === false) {
                return 'background-color:#A5D6A7;';
            } else if (row.sptarefa_status === true && row.sptarefa_cancelada === true) {
                return 'background-color:#f44336;';
            }
        },
        columns: [[
                {field: 'sptarefa_dt_tarefa_ft', title: 'Data', sortable: 'true', width: "20%"},
                {field: 'sptarefa_desc', title: 'Conteudo', width: "50%"},
                {field: 'sptarefa_u_atribuido_nome', title: 'Atribuido para', sortable: 'true', width: "10%"},
                {field: 'sptarefa_status', title: 'Status', sortable: 'true', formatter: formatterSituacaoTarefa, width: "20%"}
            ]]
    });
    var pager = gridt.datagrid().datagrid('getPager');
    pager.pagination({
        buttons: [{
                iconCls: 'icon-edit',
                handler: function () {
                    var row = gridt.datagrid('getSelected');
                    if (row) {
                        if (row.sptarefa_status === true) {
                            emitirMensagemAviso('Tarefas concluídas não podem ser editadas');
                        } else {
                            fm.form('load', {
                                sptarefa_id: row.sptarefa_id,
                                sptarefa_dt_tarefa: row.sptarefa_dt_tarefa_ft,
                                sptarefa_duracao: row.sptarefa_duracao,
                                sptarefa_u_atribuido: row.sptarefa_u_atribuido,
                                sptarefa_status: row.sptarefa_status,
                                sptarefa_titulo: row.sptarefa_titulo,
                                sptarefa_desc: row.sptarefa_desc
                            });
                        }
                    } else {
                        emitirMensagemAviso('Primeiro selecione a tarefa que deseja editar');
                    }
                }
            }, {
                iconCls: 'icon-remove',
                handler: function () {
                    excluirTarefaChamado(chamado_id, gridt);
                }
            }]
    });
}

function carregaGridImplantacao(chamado_id, p) {
    var gridt;
    var fm;
    var fmetr;
    var fmeta;
    if (p === null) {
        gridt = $('table.dgImplantacaoChamado');
        fm = $('form.fmChamado');
        fmetr = $(".fmEtapaRecusada");
        fmeta = $(".fmEtapaAprovada");
    } else {
        gridt = p.find('table.dgImplantacaoChamado');
        fm = p.find('form.fmChamado');
        fmetr = p.find(".fmEtapaRecusada");
        fmeta = p.find(".fmEtapaAprovada");
    }
    gridt.datagrid({
        url: home_uri + '/modulo/suporte/view/ImplantacaoChamadoView.php?id=' + chamado_id,
        nowrap: false,
        singleSelect: true,
        pagination: true,
        rowStyler: function (index, row) {
            if (row.etapa_status_id === 1) {
                return 'background-color:#4CAF50;';
            } else if (row.etapa_status_id === 4) {
                return 'background-color:#f44336;';
            } else if (row.etapa_status_id === 3) {
                return 'background-color:#FF9800;';
            }
        },
        columns: [[
                {field: 'etapa_seq', title: '#', sortable: 'true', width: "5%"},
                {field: 'etapa_dt_ft', title: 'Data Início', width: "10%"},
                {field: 'etapa_desc', title: 'Etapa', width: "30%"},
                {field: 'etapa_obs', title: 'OBS', width: "35%"},
                {field: 'etapa_resp_nome', title: 'Responsável', sortable: 'true', width: "10%"},
                {field: 'etapa_status_desc', title: 'Status', sortable: 'true', width: "10%"}
            ]]
    });
    var pager = gridt.datagrid().datagrid('getPager');
    pager.pagination({
        buttons: [{
                iconCls: 'icon-edit',
                handler: function () {
                    var row = gridt.datagrid('getSelected');
                    if (row) {
                        if (row.etapa_status_id !== 2) {
                            emitirMensagemAviso('Somente etapas "Em Andamento" podem ser editadas');
                        } else {
                            fmeta.css("display", "");
                            fm.form('load', {
                                etapa_id: row.id,
                                etapa_obs: row.etapa_obs
                            });
                        }
                    } else {
                        emitirMensagemAviso('Primeiro selecione a etapa que deseja editar');
                    }
                }
            }, {
                iconCls: 'icon-ok',
                handler: function () {
                    concluirEtapaPendente(chamado_id, gridt, fmeta, fmetr);
                }
            }, {
                iconCls: 'icon-remove',
                handler: function () {
                    var row = gridt.datagrid('getSelected');
                    if (row) {
                        if (row.etapa_status_id !== 3) {
                            emitirMensagemAviso('Somente etapas "Pendentes" podem ser recusadas');
                        } else {
                            fmetr.css("display", "");
                            fm.form('load', {
                                etapa_id_r: row.id,
                                etapa_obs_r: row.etapa_obs_recusada
                            });
                        }
                    } else {
                        emitirMensagemAviso('Primeiro selecione a etapa que deseja recusar');
                    }
                }
            }]
    });
}

function carregaEtapaImplantacaoInfo(chamado_id, p) {
    var etapa_atual;
    var prox_etapas;
    if (p === null) {
        etapa_atual = $('.etapaAtualInfo');
        prox_etapas = $('.proximasEtapasInfo');
    } else {
        etapa_atual = p.find('.etapaAtualInfo');
        prox_etapas = p.find('.proximasEtapasInfo');
    }
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/view/EtapaAtualInfoView.php?cid=' + chamado_id,
        dataType: 'html'
    }).done(function (retorno) {
        etapa_atual.html(retorno);
    });
    $.ajax({
        type: "POST",
        url: home_uri + '/modulo/suporte/view/EtapaAtualInfoView.php?cid=' + chamado_id,
        dataType: 'html'
    }).done(function (retorno) {
        prox_etapas.html(retorno);
    });
}

function carregaGridAnexoChamado(chamado_id, p) {
    var grida;
    var fm;
    if (p === null) {
        grida = $('table.dgAnexoChamado');
        fm = $('form.fmChamado');
    } else {
        grida = p.find('table.dgAnexoChamado');
        fm = p.find('form.fmChamado');
    }
    grida.datagrid({
        url: home_uri + '/modulo/suporte/view/AnexoChamadoView.php?id=' + chamado_id,
        nowrap: false,
        singleSelect: true,
        pagination: true,
        collapsible: false,
        title: 'Anexos Disponíveis',
        columns: [[
                {field: 'spanexo_dt_up', title: 'Data', sortable: 'true', width: "20%"},
                {field: 'spanexo_nome', title: 'Nome', sortable: 'true', width: "40%"},
                {field: 'spanexo_u_nome', title: 'Usuário', sortable: 'true', width: "10%"},
                {field: 'spanexo_caminho', title: 'Baixar', formatter: formaterAnexoChamado, width: "15%"},
				{field: 'caminho2', title: 'Visualizar', formatter: formaterAnexoVisualizar, width: "15%"}
            ]]
    });
    var pager = grida.datagrid().datagrid('getPager');
    pager.pagination({
        buttons: [{
                iconCls: 'icon-remove',
                handler: function () {
                    excluirAnexoChamado(chamado_id, grida);
                }
            }]
    });
}

function emitirErrosChamado(erro, errocod) {
    if ($('#tbChamados').length < 1) {
        $.messager.alert('Erro', erro, 'error', function () {
            if (errocod === 101) {
                $(".cbCliente").textbox('textbox').focus();
            }
        });
    } else {
        $.messager.alert('Erro', erro, 'error', function () {
            var tab = $('#tbChamados').tabs('getSelected');
            if (errocod === 101) {
                tab.find(".cbCliente").textbox('textbox').focus();
            }
        });
    }
}

function emitirErrosFollowupChamado(erro, errocod) {
    if (errocod === 106) {
        $(".cbUsuario").textbox('textbox').focus();
        $(".hb-usuario-trans").html(erro);
    } else if (errocod === 104) {
        $(".spfollowup_conteudo").focus();
        $(".hb-followup-conteudo").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function emitirErrosTarefaChamado(erro, errocod) {
    if (errocod === 106) {
        $(".cbUsuario").textbox('textbox').focus();
        $(".hb-usuario-trans").html(erro);
    } else if (errocod === 104) {
        $(".spfollowup_conteudo").focus();
        $(".hb-followup-conteudo").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function emitirErrosEtapaImplantacao(erro, errocod) {
    if (errocod === 106) {
        $(".cbUsuario").textbox('textbox').focus();
        $(".hb-usuario-trans").html(erro);
    } else if (errocod === 104) {
        $(".spfollowup_conteudo").focus();
        $(".hb-followup-conteudo").html(erro);
    } else {
        emitirMensagemErro(erro);
    }
}

function emitirErrosAnexoChamado(erro, errocod) {
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

function cadastrarReleaseExterno() {
    $('.mwRelease').window({
        href: home_uri + "/suporte/release/cadastrar",
        title: 'Cadastrar Release',
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

function formatterCNPJCPF(val) {
    if (val.length === 14) {
        return maskCnpj(val);
    } else {
        return maskCpf(val);
    }
}

function formatterSituacao(val, row) {
    if (row.spchamado_cancelado) {
        return 'Cancelado';
    } else if (val === false) {
        return 'Finalizado';
    } else {
        return 'Aberto';
    }
}

function formatterSituacaoTarefa(val) {
    if (val === false) {
        return 'Em Aberto';
    } else {
        return 'Concluida';
    }
}

function formatterAnexo(val) {
    if (val === false) {
        return '';
    } else {
        return '<i class="fa fa-paperclip" aria-hidden="true"></i>';
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

function styleManutencao(val) {
    if (val === false) {
        return 'background-color:green;color:white;font-weight:bold;';
    } else {
        return 'background-color:red;color:white;font-weight:bold;';
    }
}

function formaterAnexoChamado(val) {
    return "<a href='" + home_uri + "/modulo/suporte/arquivos/baixar.php?arquivo=" + val + "' title='Clique para baixar' class='btn btn-sm btn-primary btn-labeled fa fa-download'>Baixar</a>";
}

function formaterAnexoVisualizar(val) {
    return "<a href='" + home_uri + "/modulo/suporte/arquivos/" + val + "' title='Clique para Visualizar' class='btn btn-sm btn-primary btn-labeled fa fa-eye' target='_blank'>Visualizar</a>";
}

//function testeConclusaoEtapa(ietapa) {
//    etapa = ietapa;
//    console.log(dgBoxEtapa);
//    dgBoxEtapa.find('.dlgOBSImplantacao').dialog('open');
//}
//
//function testeGravarEtapa() {
//    alert(etapa);
//}

//function carregaImplantacaoHistorico(p) {
//    var elemento;
//    if (p === null) {
//        elemento = $('.implantacaoHistorico');
//    } else {
//        elemento = p.find('.implantacaoHistorico');
//    }
//    $.ajax({
//        type: "POST",
//        url: home_uri + '/suporte/includes/implantacaoHistorico.php',
//        dataType: 'html'
//    }).done(function (retorno) {
//        elemento.html(retorno);
//    });
//}
