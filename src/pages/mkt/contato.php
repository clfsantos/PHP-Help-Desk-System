<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/mkt/dao/ContatoDAO.php';

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
                $contatoDAO = new ContatoDAO();
                $stmt = $contatoDAO->listarContato($pid);
                $contato = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Contato";
            } else {
                $op = "Cadastrar Contato";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/mkt/home">MKT</a></li>
                <li><a href="<?php echo HOME_URI; ?>/mkt/contato">Contatos</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmContato" id="fmContato" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">                          
                                                <label>ID</label>
                                                <input type="text" class="form-control" readonly="readonly" name="id" value="<?php
                                                if (isset($contato['id'])) {
                                                    echo $contato['id'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-id-contato" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-10">                          
                                                <label>Nome</label>
                                                <input type="text" class="form-control" name="nome" id="nome" value="<?php
                                                if (isset($contato['nome'])) {
                                                    echo $contato['nome'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-nome-contato" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">                          
                                                <label>E-mail</label>
                                                <input type="text" class="form-control" name="email" id="email" value="<?php
                                                if (isset($contato['email'])) {
                                                    echo $contato['email'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-email-contato" class="help-block hb-erro"></p>
                                            </div>   
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label>Cidade <i class="fa fa-info-circle fa-fw" id="info-cidade"></i></label>
                                            </div>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control" name="cidade_id" id="cbCidade" value="<?php
                                                if (isset($contato['cidade_id'])) {
                                                    echo $contato['cidade_id'];
                                                }
                                                ?>" style="width: 100%;" />
                                            </div>
                                            <div class="col-lg-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="cidade_nome" id="cidade_nome_cb" value="<?php
                                                    if (isset($contato['cidade_nome'])) {
                                                        echo $contato['cidade_nome'];
                                                    }
                                                    ?>" disabled />
                                                    <div class="input-group-addon"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarCidadeExterna();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                                </div>
                                                <p id="hb-cidade-cb" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">                          
                                                <label>Baixa</label>
                                                <input type="text" class="form-control" disabled="true" name="email" id="email" value="<?php
                                                if (isset($contato['baixa'])) {
                                                    if ($contato['baixa'] === true) {
                                                        echo "Sim";
                                                    } else {
                                                        echo "Não";
                                                    }
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-email-contato" class="help-block hb-erro"></p>
                                            </div>   
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mar-lft">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>Lista <i class="fa fa-info-circle fa-fw" id="info-lista"></i></label>
                                                    <div class="pull-right"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarListaExterna();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                                    <div id="dlContato" style="width: 100%;"></div>
                                                    <p id="hb-lista" class="help-block hb-erro"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($action === 'editar') {
                                    $hcs = $contatoDAO->historicoLeitura($pid);
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>Histórico de Leituras</h4>
                                            <hr />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped clfs-dm">
                                                    <thead>
                                                        <tr>
                                                            <th>ID Envio</th>
                                                            <th>Campanha</th>
                                                            <th>Quantidade Leituras</th>
                                                            <th>Data Envio</th>
                                                            <th>Mensagem</th>
                                                            <th>Estatísticas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($hcs as $hc) { ?>
                                                            <tr>
                                                                <td><?php echo $hc['id']; ?></td>
                                                                <td><?php echo $hc['titulo']; ?></td>
                                                                <td><?php echo $hc['qtd']; ?></td>
                                                                <td><?php echo $hc['data_envio']; ?></td>
                                                                <td><a href="<?php echo HOME_URI . '/mkt/ver-mensagem/' . $hc['id']; ?>" class="btn-link">ver</a></td>
                                                                <td><a href="<?php echo HOME_URI . '/mkt/ver-estatisticas/' . $hc['id']; ?>" class="btn-link">ver</a></td>
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
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarContato();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarContato();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                            <?php } ?>
                            <button type="button" name="limpar" class="btn btn-warning" onclick="limparContato();"><i class="fa fa-refresh fa-fw"></i> Limpar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarContatoPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-success" onclick="cadastrarEmailsMultiplos();"><span class="glyphicon glyphicon-plus"></span> Cadastrar Múltiplos</button>
                                    <button type="button" class="btn btn-primary" onclick="editarContatoPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirContato();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control" id="statusBusca" onchange="pesquisarContato();" style="height:31px !important;">
                                                <option value="tudo">Tudo</option>
                                                <option value="ativo">Ativos</option>
                                                <option value="baixa">Baixas</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarContato();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgContato" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
            <div id="dlgCadastroEmailMultiplo" class="easyui-dialog" title="Cadastrar E-mails em Massa" style="width:100%;max-width:600px;" data-options="resizable:false,modal:true,closed:true">
                <form role="form" name="fmContatoMultiplo" id="fmContatoMultiplo" method="post" action="">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">                          
                                            <label>E-mails</label>
                                            <textarea class="form-control" rows="3" name="emails" id="emails" placeholder="Entre com um e-mail ou vários e-mails separados por vírgula(,) ou por ponto e vírgula (;)"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Cidade <i class="fa fa-info-circle fa-fw" id="info-cidade"></i></label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control" name="cidade_id" id="cbCidade" value="<?php
                                            if (isset($contato['cidade_id'])) {
                                                echo $contato['cidade_id'];
                                            }
                                            ?>" style="width: 100%;" />
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="cidade_nome" id="cidade_nome_cb" value="<?php
                                                if (isset($contato['cidade_nome'])) {
                                                    echo $contato['cidade_nome'];
                                                }
                                                ?>" disabled />
                                                <div class="input-group-addon"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarCidadeExterna();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                            </div>
                                            <p id="hb-cidade-cb" class="help-block hb-erro"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">                          
                                            <label>Caso o e-mail já exista, deseja atualizar a lista?</label>
                                            <select class="form-control" name="atualizar_lista" id="atualizar_lista">
                                                <option value="s">Sim, remover das existentes e adicionar nas novas</option>
                                                <option value="sn">Sim, não remover das existentes, apenas adicionar nas novas</option>
                                                <option value="n">Não atualizar, deixar como está</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Lista <i class="fa fa-info-circle fa-fw" id="info-lista"></i></label>
                                            <div class="pull-right"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarListaExterna();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                            <div id="dlContato" style="width: 100%;"></div>
                                            <p id="hb-lista" class="help-block hb-erro"></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="dlg-cadastra-multiplo-buttons">
                                    <button type="button" class="btn btn-success" onclick="salvarContatoMultiplo();"><i class="fa fa-database fa-fw"></i> Cadastrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>

        <div id="mwLista" class="mw"></div>
        <div id="mwCidade" class="mw"></div>

        <?php echo '<script src="' . HOME_URI . '/modulo/mkt/js/app/contato.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
