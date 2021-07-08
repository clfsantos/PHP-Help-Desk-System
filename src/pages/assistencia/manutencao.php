<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/assistencia/dao/ManutencaoDAO.php';

        $uri = $_SERVER["REQUEST_URI"];
        $getVars = explode('?', $uri);
        if (!empty($getVars[1])) {
            parse_str($getVars[1]);
            if (isset($pop)) {
                $pop = $pop;
            }
        } else {
            $pop = '';
        }

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
                $manutencaoDAO = new ManutencaoDAO();
                $stmt = $manutencaoDAO->listarManutencao($pid);
                $manutencao = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Assistência";
            } else {
                $op = "Cadastrar Assistência";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/assistencia/home">Assistência</a></li>
                <li><a href="<?php echo HOME_URI; ?>/assistencia/manutencao">Assistências</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmManutencao" id="fmManutencao" method="post" action="">
                        <div class="bt-panel-body">

                            <div id="guias" class="easyui-tabs" style="width:100%;border:1px solid #cccccc;">

                                <div title="Manutenção" style="padding:15px 0;">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">                          
                                                <label>ID</label>
                                                <input type="text" class="form-control" readonly="readonly" name="id_manutencao" value="<?php
                                                if (isset($manutencao['id_manutencao'])) {
                                                    echo $manutencao['id_manutencao'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-id-manutencao" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Equipamento <i class="fa fa-info-circle fa-fw" id="info-equipamento"></i></label>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" class="easyui-textbox" name="codigo_equipamento" id="cbEquipamento" value="<?php
                                                if (isset($manutencao['codigo_equipamento'])) {
                                                    echo $manutencao['codigo_equipamento'];
                                                }
                                                ?>" style="width: 100%;" />
                                            </div>
                                            <div class="col-lg-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="descricao" id="descricao_manutencao_cb" value="<?php
                                                    if (isset($manutencao['descricao'])) {
                                                        echo $manutencao['descricao'] . ' (' . $manutencao['nr_serie'] . ') -' . ' (' . $manutencao['crcliente_fantasia'] . ')';
                                                    }
                                                    ?>" disabled />
                                                    <div class="input-group-addon"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarEquipamentoExterno();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                                </div>
                                                <p id="hb-equipamento-cb" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Categoria Problema <i class="fa fa-info-circle fa-fw" id="info-problema"></i></label>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" class="easyui-textbox" name="id_problema" id="cbProblemaManutencao" value="<?php
                                                if (isset($manutencao['id_problema'])) {
                                                    echo $manutencao['id_problema'];
                                                }
                                                ?>" style="width: 100%;" />
                                            </div>
                                            <div class="col-lg-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="descricao_problema" id="descricao_problema_cb" value="<?php
                                                    if (isset($manutencao['descricao_problema'])) {
                                                        echo $manutencao['descricao_problema'];
                                                    }
                                                    ?>" disabled />
                                                    <div class="input-group-addon"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarProblemaManutencaoExterno();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                                </div>
                                                <p id="hb-problema-cb" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">                          
                                                <label>Problema Inicial</label>
                                                <input type="text" class="form-control" name="problema_inicial" id="problema_inicial" value="<?php
                                                if (isset($manutencao['problema_inicial'])) {
                                                    echo $manutencao['problema_inicial'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-pinicial" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">                          
                                                <label>Data de Entrada</label>
                                                <input type="text" class="form-control calendario" name="data_entrada" id="data_entrada" value="<?php
                                                if (isset($manutencao['data_entrada'])) {
                                                    echo $manutencao['data_entrada'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-dtentrada" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-8">                          
                                                <label>Nota Fiscal</label>
                                                <input type="text" class="form-control" name="nota_fiscal" id="nota_fiscal" value="<?php
                                                if (isset($manutencao['nota_fiscal'])) {
                                                    echo $manutencao['nota_fiscal'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-nfiscal" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div title="Laudo Técnico" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">                          
                                                <label>Laudo Técnico</label>
                                                <textarea class="form-control" name="laudo_tecnico" id="laudo_tecnico" rows="5"><?php
                                                    if (isset($manutencao['laudo_tecnico'])) {
                                                        echo $manutencao['laudo_tecnico'];
                                                    }
                                                    ?></textarea>
                                                <p id="hb-laudo" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Finalizado?</label>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="checkbox">
                                                    <input type="checkbox" name="manutencao_ativa" id="manutencao_ativa" <?php
                                                    if (isset($manutencao['manutencao_ativa']) && $manutencao['manutencao_ativa'] === false) {
                                                        echo "checked";
                                                    }
                                                    ?> /> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2">                          
                                                <label>Data de Devolução</label>
                                                <input type="text" class="form-control calendario" name="data_devolucao" id="data_devolucao" value="<?php
                                                if (isset($manutencao['data_devolucao'])) {
                                                    echo $manutencao['data_devolucao'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-dtdevolucao" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Followup" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12"> 
                                                <table id="dgFollowup" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Arquivos" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12"> 
                                                <table id="dgArquivo" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Dados Adicionais" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                Dados de Rede
                                                <hr />
                                            </div>
                                            <div class="col-lg-4"> 
                                                <label>IP</label>
                                                <input type="text" class="form-control" name="nr_ip" id="nr_ip" value="" style="width: 100%;" />
                                                <p id="hb-nrip" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <label>Máscara</label>
                                                <input type="text" class="form-control" name="mascara" id="mascara" value="" style="width: 100%;" />
                                                <p id="hb-mascara" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <label>Gateway</label>
                                                <input type="text" class="form-control" name="gateway" id="gateway" value="" style="width: 100%;" />
                                                <p id="hb-gateway" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12" style="margin-top:30px;">
                                                Dados Adicionais
                                                <hr />
                                            </div>
                                            <div class="col-lg-12">
                                                <label>Veio com:</label>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div class="checkbox">
                                                    <input type="checkbox" name="bateria" id="bateria" />
                                                    <label>Bateria</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div class="checkbox">
                                                    <input type="checkbox" name="chave" id="chave" />
                                                    <label>Chave</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <div class="checkbox">
                                                    <input type="checkbox" name="bobina" id="bobina" />
                                                    <label>Bobina</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12"> 
                                                <label>Outros</label>
                                                <input type="text" class="form-control" name="outros" id="outros" value="" style="width: 100%;" />
                                                <p id="hb-outros" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12" style="margin-top:30px;">
                                                Dados Fiscais
                                                <hr />
                                            </div>
                                            <div class="col-lg-4"> 
                                                <label>Lacre Antigo</label>
                                                <input type="text" class="form-control" name="lacre_antigo" id="lacre_antigo" value="" style="width: 100%;" />
                                                <p id="hb-lacre-antigo" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <label>Lacre Novo</label>
                                                <input type="text" class="form-control" name="lacre_novo" id="lacre_novo" value="" style="width: 100%;" />
                                                <p id="hb-lacre-novo" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-4"> 
                                                <label>Número de Série Novo</label>
                                                <input type="text" class="form-control" name="novo_nsr" id="novo_nsr" value="" style="width: 100%;" />
                                                <p id="hb-novo-nsr" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 bt-form">                                   
                                                <button type="button" name="editar" class="btn btn-success" onclick="salvarDados();"><span class="glyphicon glyphicon-ok"></span> Salvar</button>                             
                                                <button type="button" name="limpar" class="btn btn-danger" onclick="desvincularDados();"><span class="glyphicon glyphicon-trash"></span> Desvincular Dados</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div title="Histórico" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <?php
                                        if ($action === 'editar') {
                                            $rhs = $manutencaoDAO->historicoManutencao($manutencao['codigo_equipamento'], $manutencao['id_manutencao']);
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <?php
                                                    if (empty($rhs)) {
                                                        echo 'Não existem históricos de manutenção para este equipamento até a presente assistência!';
                                                    } else {
                                                        foreach ($rhs as $rh) {
                                                            $dassistencia = $manutencaoDAO->detalhesManutencao($rh['id_manutencao']);
                                                            $dfollowup = $manutencaoDAO->detalhesManutencaoFollowup($rh['id_manutencao']);
                                                            ?>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped clfs-dm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Assistência nº <?php echo $rh['id_manutencao']; ?></th>
                                                                            <th>Detalhes da Assistência</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="clfs-left">Data da entrada:</td>
                                                                            <td class="clfs-right"><?php echo $dassistencia['data_entrada']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="clfs-left">Problema inicial:</td>
                                                                            <td class="clfs-right"><?php echo $dassistencia['problema_inicial']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="clfs-left">Tempo em manutencao:</td>
                                                                            <td class="clfs-right"><?php echo $dassistencia['dias_manutencao']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="clfs-left">Status:</td>
                                                                            <td class="clfs-right">
                                                                                <?php
                                                                                if ($dassistencia['manutencao_ativa'] === true) {
                                                                                    echo "Em andamento";
                                                                                } else {
                                                                                    echo "Finalizado";
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="clfs-left">Laudo técnico:</td>
                                                                            <td class="clfs-right">
                                                                                <?php
                                                                                if ($dassistencia['laudo_tecnico'] === null) {
                                                                                    echo "O equipamento ainda está em manutenção!";
                                                                                } else {
                                                                                    echo $dassistencia['laudo_tecnico'];
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="clfs-left">Data de devolução:</td>
                                                                            <td class="clfs-right">
                                                                                <?php
                                                                                if ($dassistencia['data_devolucao'] === null) {
                                                                                    echo "Ainda não foi devolvido!";
                                                                                } else {
                                                                                    echo $dassistencia['data_devolucao'];
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped clfs-dm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th colspan=3>Followups da Assistência nº <?php echo $rh['id_manutencao']; ?></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($dfollowup as $f) { ?>
                                                                            <tr>
                                                                                <td class="clfs-left"><?php echo $f['data_followup']; ?></td>
                                                                                <td class="clfs-fcenter"><b><?php echo $f['descricao_evento']; ?></b><div><?php echo $f['followup_conteudo']; ?></div></td>
                                                                                <td class="clfs-fright"><?php echo $f['nome']; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div title="Histórico Chamado" style="padding:15px 0;" <?php
                                if ($action === 'cadastrar') {
                                    echo 'data-options="disabled:true"';
                                }
                                ?>>
                                    <div class="container-fluid">
                                        <?php
                                        if ($action === 'editar') {
                                            $chamados = $manutencaoDAO->historicoChamado($manutencao['crcliente_id'], $manutencao['data_entrada_nft']);
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <?php
                                                    if (empty($chamados)) {
                                                        echo 'Não existem históricos de chamados para este cliente até a presente assistência!';
                                                    } else {
                                                        ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-striped clfs-dm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Chamado #</th>
                                                                        <th>Data</th>
                                                                        <th>Título</th>
                                                                        <th>Ocorrência</th>
                                                                        <th>Responsável</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($chamados as $chamado) { ?>
                                                                        <tr>
                                                                            <td><a class="btn-link" href="#" onclick="editarChamadoExterno(<?php echo $chamado['spchamado_id']; ?>)" title=""><?php echo $chamado['spchamado_id']; ?></a></td>
                                                                            <td><?php echo $chamado['spchamado_dt_abertura_nft']; ?></td>
                                                                            <td><?php echo $chamado['spchamado_titulo']; ?></td>
                                                                            <td><?php echo $chamado['spchamado_ocorrencia']; ?></td>
                                                                            <td><?php echo $chamado['spchamado_resp_atual_nome']; ?></td>
                                                                        </tr>
                                                                    <?php } ?>                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load acao" onclick="editarManutencao();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load acao" onclick="cadastrarManutencao();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>

        <?php } else { ?>

            <div id="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="height: 37px;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="padding-bottom:13px;">
                        <div id="toolbar">
                            <div class="row">
                                <div class="col-sm-8">   
                                    <button type="button" class="btn btn-success" onclick="cadastrarManutencaoPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarManutencaoPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirManutencao();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                    <button type="button" class="btn btn-default" onclick="visualisarManutencao();"><span class="glyphicon glyphicon-eye-open"></span> Detalhes</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control" id="statusBusca" onchange="pesquisarManutencao();" style="height:31px !important;">
                                                <option value="aberto">Em Aberto</option>
                                                <option value="finalizado">Finalizado</option>
                                                <option value="tudo">Tudo</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarManutencao();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgManutencao" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="mwFollowup" class="mw"></div>
        <div id="mwArquivo" class="mw"></div>
        <div id="mwEquipamento" class="mw"></div>
        <div id="mwProblemaManutencao" class="mw"></div>
        <div id="mwChamado" class="mw"></div>

        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/manutencao.app.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/followup.app.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/arquivo.app.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/dados.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
