<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div id="content-container">
    <div id="mensagem"></div>
    <div class="extractor">
        <?php
        include ABSPATH . '/modulo/suporte/dao/ChamadoDAO.php';

        /*
        $uri = $_SERVER["REQUEST_URI"];
        echo $uri;
        $getVars = explode('?', $uri);
        print_r($getVars);
        if (!empty($getVars[1])) {
            parse_str($getVars[1]);
            if (isset($pop)) {
                $pop = $pop;
            }
        } else {
            $pop = '';
        }
        */

        $pop = '1';

        if ($contagem > 1) {
            $action = (empty($url[2]) ? null : $url[2]);
            $pid = (empty($url[3]) ? null : $url[3]);
        } else {
            $action = (empty($url[1]) ? null : $url[1]);
            $pid = (empty($url[2]) ? null : $url[2]);
        }
        
        if (!empty($pid)) {
            echo '<script>var cid = ' . $pid . ';</script>';
        } else {
            echo '<script>var cid = 0;</script>';
        }

        if ($action === 'editar' || $action === 'cadastrar') {
            if ($action === 'editar') {
                $conexao = new Conexao();
                $chamadoDAO = new ChamadoDAO();
                $stmt = $chamadoDAO->listarChamado($pid);
                $chamado = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Chamado";
            } else {
                $op = "Cadastrar Chamado";
            }
            ?>

            <?php if ($pop !== '1') { ?>
                <ol class="breadcrumb">
                    <li><a href="<?php echo HOME_URI; ?>/suporte/home">Suporte</a></li>
                    <li><a href="<?php echo HOME_URI; ?>/suporte/chamado">Chamados</a></li>
                    <li class="active"><?php echo $op; ?></li>
                </ol>
                <div id="page-content">
                    <div class="bt-panel" style="margin-bottom:0;">
                        <div class="bt-panel-heading">
                            <h3 class="bt-panel-title">
                                <?php echo $op; ?>
                            </h3>
                        </div>
                    <?php } ?>
                    <form role="form" name="fmChamado" class="fmChamado" method="post" action="">
                        <?php if ($pop !== '1') { ?>
                            <div class="bt-panel-body">
                            <?php } ?>
                            <div class="guias" style="width:100%;<?php
                            if ($pop !== '1') {
                                echo 'border:1px solid #cccccc;';
                            }
                            ?>">
                                <div title="Chamado" style="padding:15px 0;">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-6">

                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <label>Cliente <i class="fa fa-info-circle fa-fw info-cliente"></i> <span class="ultima-pesquisa"></span></label>
                                                        <input type="hidden" class="dt_ultima_pesquisa" name="dt_ultima_pesquisa" value="" />
                                                        <input type="text" class="form-control cbCliente" name="crcliente_id" value="<?php
                                                        if (isset($chamado['crcliente_id'])) {
                                                            echo $chamado['crcliente_id'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-cliente-cb"></p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Contato</label>
                                                        <input type="text" class="form-control spchamado_contato" name="spchamado_contato" value="<?php
                                                        if (isset($chamado['spchamado_contato'])) {
                                                            echo $chamado['spchamado_contato'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-contato-chamado"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Produto</label>
                                                        <select class="easyui-combobox cbProduto" name="spchamado_produto_id" data-options="value:<?php
                                                        if (isset($chamado['spchamado_produto_id'])) {
                                                            echo $chamado['spchamado_produto_id'];
                                                        } else {
                                                            echo 1;
                                                        }
                                                        ?>" style="width:100%;">
                                                        </select>
                                                        <p class="help-block hb-erro hb-produto"></p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Grupo</label>
                                                        <?php
                                                        if (isset($chamado['spchamado_grupo_id'])) {
                                                            $value = 'data-options="value:' . $chamado['spchamado_grupo_id'] . '"';
                                                        } else {
                                                            $value = '';
                                                        }
                                                        ?>
                                                        <select class="easyui-combobox cbGrupo" name="spchamado_grupo_id" <?php echo $value; ?> style="width:100%;"></select>
                                                        <p class="help-block hb-erro hb-grupo"></p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Sub-Grupo</label>
                                                        <?php
                                                        if (isset($chamado['spchamado_subgrupo_id'])) {
                                                            $value = 'data-options="value:' . $chamado['spchamado_subgrupo_id'] . '"';
                                                        } else {
                                                            $value = '';
                                                        }
                                                        ?>
                                                        <select class="easyui-combobox cbSubGrupo" name="spchamado_subgrupo_id" <?php echo $value; ?> style="width:100%;"></select>
                                                        <p class="help-block hb-erro hb-subgrupo"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Origem</label>
                                                        <select class="easyui-combobox cbOrigem" name="spchamado_origem_id" data-options="value:<?php
                                                        if (isset($chamado['spchamado_origem_id'])) {
                                                            echo $chamado['spchamado_origem_id'];
                                                        } else {
                                                            echo 1;
                                                        }
                                                        ?>" style="width:100%;">
                                                        </select>
                                                        <p class="help-block hb-erro hb-origem"></p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Classificação <i class="fa fa-info-circle fa-fw info-class"></i></label>
                                                        <select class="easyui-combobox cbClass" name="spchamado_class_id" data-options="value:<?php
                                                        if (isset($chamado['spchamado_class_id'])) {
                                                            echo $chamado['spchamado_class_id'];
                                                        } else {
                                                            echo 2;
                                                        }
                                                        ?>" style="width:100%;">
                                                        </select>
                                                        <p class="help-block hb-erro hb-class"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>SLA</label>
                                                        <select class="easyui-combobox cbSLA" <?php
                                                        if ($action === 'editar') {
                                                            echo 'disabled="disabled"';
                                                        }
                                                        ?> name="spchamado_sla_prioridade_id" data-options="value:<?php
                                                                if (isset($chamado['spchamado_sla_prioridade_id'])) {
                                                                    echo $chamado['spchamado_sla_prioridade_id'];
                                                                } else {
                                                                    echo 1;
                                                                }
                                                                ?>" style="width:100%;">
                                                        </select>
                                                        <p class="help-block hb-erro hb-sla"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Vencimento</label>
                                                        <input type="text" class="form-control spchamado_sla_data_vto_nft" name="spchamado_sla_data_vto_nft" value="<?php
                                                        if (isset($chamado['spchamado_sla_data_vto_nft'])) {
                                                            echo $chamado['spchamado_sla_data_vto_nft'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-vencimento-sla"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Título</label>
                                                        <input type="text" class="form-control spchamado_titulo" name="spchamado_titulo" value="<?php
                                                        if (isset($chamado['spchamado_titulo'])) {
                                                            echo $chamado['spchamado_titulo'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-titulo"></p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>E-mail <i class="fa fa-info-circle fa-fw info-email"></i></label>
                                                        <input type="text" class="form-control crcliente_email" name="crcliente_email" value="<?php
                                                        if (isset($chamado['email_ultima_pesquisa'])) {
                                                            echo $chamado['email_ultima_pesquisa'];
                                                        } elseif (isset($chamado['crcliente_email'])) {
                                                            echo $chamado['crcliente_email'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-email-j"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Financeiro</label>
                                                        <select class="easyui-combobox spchamado_financeiro" name="spchamado_financeiro" data-options="editable:false,value:<?php
                                                        if (isset($chamado['spchamado_financeiro'])) {
                                                            if ($chamado['spchamado_financeiro'] === true) {
                                                                echo 1;
                                                            } else {
                                                                echo 0;
                                                            }
                                                        } else {
                                                            echo 0;
                                                        }
                                                        ?>" style="width:100%;">
                                                            <option value="0">Não</option>
                                                            <option value="1">Sim</option>
                                                        </select>
                                                        <p class="help-block hb-erro hb-financeiro"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>O.S.</label>
                                                        <input type="text" class="form-control spchamado_osrel" name="spchamado_osrel" value="<?php
                                                        if (isset($chamado['spchamado_osrel'])) {
                                                            echo $chamado['spchamado_osrel'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-osrel"></p>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-lg-6">

                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>Mensalista</label>
                                                        <input type="text" class="form-control crcliente_cd_junsoft" disabled="disabled" name="crcliente_cd_junsoft" value="<?php
                                                        if (isset($chamado['is_cliente_mensalista'])) {
                                                            if(!empty($chamado['is_cliente_mensalista'])) {
                                                                echo "Sim";
                                                            } else {
                                                                echo "Não";
                                                            }
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-junsoft"></p>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label>Razão Social</label>
                                                        <input type="text" class="form-control crcliente_razao" disabled="disabled" name="crcliente_razao" value="<?php
                                                        if (isset($chamado['crcliente_razao'])) {
                                                            echo $chamado['crcliente_razao'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-razao"></p>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <label>Fantasia</label>
                                                        <input type="text" class="form-control crcliente_fantasia" disabled="disabled" name="crcliente_fantasia" value="<?php
                                                        if (isset($chamado['crcliente_fantasia'])) {
                                                            echo $chamado['crcliente_fantasia'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-fantasia"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label>CPNJ / CPF</label>
                                                        <input type="text" class="form-control crcliente_cnpj" disabled="disabled" name="crcliente_cnpj" value="<?php
                                                        if (isset($chamado['crcliente_cnpj'])) {
                                                            echo $chamado['crcliente_cnpj'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-cnpjcpf"></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Telefone</label>
                                                        <input type="text" class="form-control crcliente_telefone" disabled="disabled" name="crcliente_telefone" value="<?php
                                                        if (isset($chamado['crcliente_telefone'])) {
                                                            echo $chamado['crcliente_telefone'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-telefone-j"></p>
                                                    </div>                             
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label>Contratos</label>
                                                        <p class="form-control-static"><a href="#" class="btn btn-link modal-toggle-c">VER CONTRATOS</a></p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Equipamentos</label>
                                                        <p class="form-control-static"><a href="#" class="btn btn-link modal-toggle-e">VER EQUIPAMENTOS</a></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-1">
                                                        <label>ID</label>
                                                        <input type="text" class="form-control spchamado_id" readonly="readonly" name="spchamado_id" value="<?php
                                                        if (isset($chamado['spchamado_id'])) {
                                                            echo $chamado['spchamado_id'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-id-chamado"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Situação</label>
                                                        <input type="text" class="form-control" disabled="disabled" name="spchamado_aberto_ready" value="<?php
                                                        if (isset($chamado['spchamado_aberto'])) {
                                                            if ($chamado['spchamado_cancelado'] === true) {
                                                                echo 'Cancelado';
                                                            } elseif ($chamado['spchamado_aberto'] === false) {
                                                                echo 'Fechado';
                                                            } else {
                                                                echo 'Aberto';
                                                            }
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-situacao"></p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>Abertura</label>
                                                        <input type="text" class="form-control spchamado_dt_abertura_nft" disabled="disabled" name="spchamado_dt_abertura_nft" value="<?php
                                                        if (isset($chamado['spchamado_dt_abertura_nft'])) {
                                                            echo $chamado['spchamado_dt_abertura_nft'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-dt-abertura"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Fechamento</label>
                                                        <input type="text" class="form-control spchamado_dt_encerramento_nft" disabled="disabled" name="spchamado_dt_encerramento_nft" value="<?php
                                                        if (isset($chamado['spchamado_dt_encerramento_nft'])) {
                                                            echo $chamado['spchamado_dt_encerramento_nft'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-dt-encerramento"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Criador</label>
                                                        <input type="text" class="form-control spchamado_responsavel_nome" disabled="disabled" name="spchamado_responsavel_nome" value="<?php
                                                        if (isset($chamado['spchamado_responsavel_nome'])) {
                                                            echo $chamado['spchamado_responsavel_nome'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-responsavel"></p>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Responsável</label>
                                                        <input type="text" class="form-control spchamado_resp_atual_nome" disabled="disabled" name="spchamado_resp_atual_nome" value="<?php
                                                        if (isset($chamado['spchamado_resp_atual_nome'])) {
                                                            echo $chamado['spchamado_resp_atual_nome'];
                                                        }
                                                        ?>" style="width: 100%;" />
                                                        <p class="help-block hb-erro hb-responsavel-atual"></p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Ocorrência</label>
                                                <textarea class="form-control spchamado_ocorrencia" name="spchamado_ocorrencia" rows="5"><?php
                                                    if (isset($chamado['spchamado_ocorrencia'])) {
                                                        echo $chamado['spchamado_ocorrencia'];
                                                    }
                                                    ?></textarea>
                                                <p class="help-block hb-erro hb-ocorrencia-chamado"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Resolução" style="padding:15px 0;">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Parecer Final</label>
                                                <textarea class="form-control spchamado_resolver" name="spchamado_resolver" rows="5"><?php
                                                    if (isset($chamado['spchamado_resolver'])) {
                                                        echo $chamado['spchamado_resolver'];
                                                    }
                                                    ?></textarea>
                                                <p class="help-block hb-erro hb-resolver"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Release <i class="fa fa-info-circle fa-fw info-release"></i></label>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control cbRelease" name="spchamado_release_id" value="<?php
                                                if (isset($chamado['spchamado_release_id'])) {
                                                    echo $chamado['spchamado_release_id'];
                                                }
                                                ?>" style="width: 100%;" />
                                            </div>
                                            <div class="col-lg-10">
                                                <input type="text" class="form-control spchamado_release_num" name="spchamado_release_num" disabled />
                                                <p id="hb-cbrelease" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Finalizar?</label>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="checkbox">
                                                    <input type="checkbox" class="spchamado_aberto" name="spchamado_aberto" <?php
                                                    if (isset($chamado['spchamado_aberto']) && $chamado['spchamado_aberto'] === false) {
                                                        echo 'checked disabled="disabled"';
                                                    }
                                                    ?> />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label>Finalizado por</label>
                                                <input type="text" class="form-control spchamado_resp_fechamento_nome" readonly="readonly" name="spchamado_resp_fechamento_nome" value="<?php
                                                if (isset($chamado['spchamado_resp_fechamento_nome'])) {
                                                    echo $chamado['spchamado_resp_fechamento_nome'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p class="help-block hb-erro hb-fechadopor"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Followups" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>ID</label>
                                                <input type="text" class="form-control spfollowup_id" readonly="readonly" name="spfollowup_id" />
                                                <p class="help-block hb-erro hb-followupc-id"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label>Tipo</label>
                                                <select class="easyui-combobox cbTipo" name="spfollowup_tipo" style="width:100%;">
                                                    <option value="1">Followup de Seguimento</option>
                                                    <option value="2">Transferência de Chamado</option>
                                                </select>
                                                <p class="help-block hb-erro hb-followup-tipo"></p>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>Transferir para</label>
                                                <select class="easyui-combobox cbUsuario" name="spfollowup_usuario_trans" style="width:100%;"></select>
                                                <p class="help-block hb-erro hb-usuario-trans"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Followup</label>
                                                <textarea class="form-control spfollowup_conteudo" name="spfollowup_conteudo" rows="5"></textarea>
                                                <p class="help-block hb-erro hb-followup-conteudo"></p>
                                            </div>
                                        </div>
                                        <?php if ($chamado['spchamado_aberto'] === true) { ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" name="salvar" class="btn btn-success loadf" onclick="salvarChamadoFollowup();"><span class="glyphicon glyphicon-ok"></span> Salvar</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-lg-12">
                                                <table class="dgFollowupChamado" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Tarefas" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label>ID</label>
                                                <input type="text" class="form-control sptarefa_id" readonly="readonly" name="sptarefa_id" />
                                                <p class="help-block hb-erro hb-sptarefa-id"></p>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Data da Tarefa</label>
                                                <input type="text" class="form-control sptarefa_dt_tarefa" name="sptarefa_dt_tarefa" style="width: 100%;" />
                                                <p class="help-block hb-erro hb-sptarefa-dt-tarefa"></p>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Duração (Horas)</label>
                                                <input type="text" class="form-control sptarefa_duracao" name="sptarefa_duracao" style="width: 100%;" />
                                                <p class="help-block hb-erro hb-sptarefa-duracao"></p>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Responsável</label>
                                                <select class="easyui-combobox cbUsuarioTarefa" name="sptarefa_u_atribuido" style="width:100%;"></select>
                                                <p class="help-block hb-erro hb-usuario-tarefa"></p>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Status</label>
                                                <select class="easyui-combobox sptarefa_status" name="sptarefa_status" data-options="editable:false" style="width:100%;">
                                                    <option value="0">Em Aberto</option>
                                                    <option value="1">Concluído</option>
                                                    <option value="2">Cancelada</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Título</label>
                                                <input type="text" class="form-control sptarefa_titulo" name="sptarefa_titulo" style="width:100%;" />
                                                <p class="help-block hb-erro hb-sptarefa-titulo"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Descrição da Tarefa</label>
                                                <textarea class="form-control sptarefa_desc" name="sptarefa_desc" rows="5"></textarea>
                                                <p class="help-block hb-erro hb-sptarefa-desc"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Transferir o chamado?</label>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="checkbox">
                                                    <input type="checkbox" class="spchamado_transferir" name="spchamado_transferir" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($chamado['spchamado_aberto'] === true) { ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" name="salvar" class="btn btn-success loadt" onclick="salvarChamadoTarefa();"><span class="glyphicon glyphicon-ok"></span> Salvar</button>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-lg-12">
                                                <table class="dgTarefaChamado" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <?php
                                if (isset($chamado['spchamado_class_id'])) {
                                    $chamado_classe = $chamado['spchamado_class_id'];
                                } else {
                                    $chamado_classe = 0;
                                }
                                if ($chamado_classe === 3) {
                                    $display = true;
                                } else {
                                    $display = false;
                                }
                                ?>
                                <div title="Implantação" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar' || $display === false) {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>> 
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-4 fmEtapaAprovada" style="display:none;">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>ID</label>
                                                        <input type="text" class="form-control etapa_id" readonly="readonly" name="etapa_id" />
                                                        <p class="help-block hb-erro hb-etapa-id"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label>Observação</label>
                                                        <textarea class="form-control etapa_obs" name="etapa_obs" rows="5"></textarea>
                                                        <p class="help-block hb-erro hb-etapa-obs"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" name="salvar" class="btn btn-success loadts" onclick="salvarEtapa();"><span class="fa fa-floppy-o"></span> Salvar</button>
                                                        <button type="button" name="concluir" class="btn btn-success loadtc" onclick="concluirEtapa();"><span class="glyphicon glyphicon-ok"></span> Concluir</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 fmEtapaRecusada" style="display:none;">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>ID</label>
                                                        <input type="text" class="form-control etapa_id" readonly="readonly" name="etapa_id_r" />
                                                        <p class="help-block hb-erro hb-etapa-id-r"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label>Observação</label>
                                                        <textarea class="form-control etapa_obs" name="etapa_obs_r" rows="5"></textarea>
                                                        <p class="help-block hb-erro hb-etapa-obs-r"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" name="recusar" class="btn btn-danger loadt" onclick="recusarEtapaPendente();"><span class="glyphicon glyphicon-remove"></span> Recusar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="etapaAtualInfo"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-lg-12">
                                                <table class="dgImplantacaoChamado" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Anexos" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="dropzone dzAnexoChamado">
                                                    <div class="dz-default dz-message">
                                                        <div class="dz-icon icon-wrap icon-circle icon-wrap">
                                                            <i class="fa fa-cloud-upload fa-3x"></i>
                                                        </div>
                                                        <div>
                                                            <span class="dz-text">Arraste os arquivos para fazer upload</span>
                                                            <p class="text-muted">ou clique para abrir o explorador</p>
                                                        </div>
                                                    </div>
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-lg-12">
                                                <table class="dgAnexoChamado" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Log" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <?php
                                        if ($action === 'editar') {
                                            $logs = $chamadoDAO->logChamado($chamado['spchamado_id']);
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped clfs-dm">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan=3>Logs do Chamado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($logs as $log) { ?>
                                                                    <tr>
                                                                        <td><?php echo $log['spchamado_log_dt']; ?></td>
                                                                        <td><?php echo $log['spchamado_log_usuario_nome']; ?></td>
                                                                        <td><?php echo $log['spchamado_log_desc']; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($pop !== '1') { ?>
                            </div>
                        <?php } ?>
                        <div class="bt-panel-footer">
                            <?php
                            if ($action === 'editar') {
                                if ($chamado['spchamado_aberto'] === false || $chamado['spchamado_cancelado'] === true) {
                                    echo '<p>O chamado está encerrado! Só poderá ser utilizado para consultas.</p> ';
                                } elseif ($_SESSION['usuarioID'] === $chamado['spchamado_resp_atual_id']) {
                                    echo '<button type="button" name="editar" class="btn btn-success load editar" onclick="editarChamado();"><span class="glyphicon glyphicon-ok"></span> Editar</button> ';
                                } else {
                                    echo '<button type="button" name="assumir" class="btn btn-primary load" onclick="assumirChamado();"><span class="glyphicon glyphicon-transfer"></span> Assumir Chamado</button> ';
                                }
                            } else {
                                echo '<button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarChamado();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button> ';
                            }
                            ?>
                        </div>
                    </form>
                    <?php if ($pop !== '1') { ?>
                    </div>
                </div>
            <?php } ?>

            <div class="modal md-equipamentos" role="dialog" tabindex="-1" aria-labelledby="md-equipamentos-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Equipamentos do Cliente</h4>
                        </div>
                        <div class="modal-body">
                            <div class="equipamentos-conteudo">
                                <?php
                                    if ($action === 'editar') {
                                        $stmt = $chamadoDAO->equipamentoClienteCombo($chamado['crcliente_id']);
                                        $equipamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        if(!empty($equipamentos)) {
                                            echo '<hr />';
                                            foreach ($equipamentos as $equipamento) {
                                                if ($equipamento['inativo']) {
                                                    echo '<span style="text-decoration:line-through;">' . $equipamento['desc_nsr'] . '</span>' . '<hr />';
                                                } else {
                                                    echo $equipamento['desc_nsr'] . '<hr />';
                                                }
                                            }
                                        } else {
                                            echo '<hr />Sem equipamentos cadastrados!<hr />';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal md-contratos" role="dialog" tabindex="-1" aria-labelledby="md-contratos-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Contratos do Cliente</h4>
                        </div>
                        <div class="modal-body">
                            <div class="contratos-conteudo">
                                <?php
                                if ($action === 'editar') {
                                    $stmt = $chamadoDAO->clienteContratos($chamado['crcliente_id']);
                                    $contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if(!empty($contratos)) {
                                        echo '<hr />';
                                        foreach ($contratos as $contrato) {
                                            echo $contrato['contrato_desc'] . ' - ' . $contrato['contrato_qtd'] . '<hr />';
                                        }
                                    } else {
                                        echo '<hr />Sem contratos cadastrados!<hr />';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>

            <div id="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="height: 37px;"></div>
                    </div>
                </div>
                <div id="tbChamados" style="width:100%;border:1px solid #cccccc;">
                    <div title="Chamados">
                        <div id="toolbar">
                            <div class="row">
                                <div class="col-sm-7">
                                    <button type="button" class="btn btn-success" onclick="cadastrarChamadoPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarChamadoPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="cancelarChamado();"><span class="glyphicon glyphicon-circle-arrow-down"></span> Cancelar</button>
                                </div>
                                <div class="col-sm-5">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?php
                                            if (isset($_SESSION['usuarioID'])) {
                                                $value = 'data-options="value:' . $_SESSION['usuarioID'] . '"';
                                            } else {
                                                $value = '';
                                            }
                                            ?>
                                            <select class="easyui-combobox cbUsuarioFiltro" id="cbUsuarioFiltro" name="cbUsuarioFiltro" <?php echo $value; ?> style="width:100%;"></select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="easyui-combobox" id="statusBusca" style="width:100%;">
                                                <option value="aberto">Aberto</option>
                                                <option value="fechado">Fechado</option>
                                                <option value="cancelado">Cancelado</option>
                                                <option value="tudo">Tudo</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarChamadoCont();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgChamado" style="width:100%;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="mwFollowupChamado" class="mw"></div>
        <div id="mwAnexoChamado" class="mw"></div>

        <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/chamado.app.js"></script>'; ?>

    </div><!--extractor-->
</div>
