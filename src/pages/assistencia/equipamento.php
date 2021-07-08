<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/assistencia/dao/EquipamentoDAO.php';

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

        if ($action === 'editar' || $action === 'cadastrar') {
            if ($action === 'editar') {
                $conexao = new Conexao();
                $equipamentoDAO = new EquipamentoDAO();
                $stmt = $equipamentoDAO->listarEquipamento($pid);
                $equipamento = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Equipamento";
            } else {
                $op = "Cadastrar Equipamento";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/assistencia/home">Assistência</a></li>
                <li><a href="<?php echo HOME_URI; ?>/assistencia/equipamento">Equipamentos</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmEquipamento" id="fmEquipamento" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="codigo_equipamento" value="<?php
                                        if (isset($equipamento['codigo_equipamento'])) {
                                            echo $equipamento['codigo_equipamento'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-equipamento-id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-10">                          
                                        <label>Número de Série</label>
                                        <input type="text" class="form-control" name="nr_serie" id="nr_serie" value="<?php
                                        if (isset($equipamento['nr_serie'])) {
                                            echo $equipamento['nr_serie'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-nsr" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label><a href="<?php echo HOME_URI; ?>/cliente">Cliente</a> <i class="fa fa-info-circle fa-fw" id="info-cliente"></i></label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="crcliente_id" id="cbCliente" value="<?php
                                        if (isset($equipamento['crcliente_id'])) {
                                            echo $equipamento['crcliente_id'];
                                        }
                                        ?>" style="width: 100%;" />
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="crcliente_fantasia" id="crcliente_fantasia_cb" value="<?php
                                        if (isset($equipamento['crcliente_fantasia'])) {
                                            echo $equipamento['crcliente_fantasia'];
                                        }
                                        ?>" disabled />   
                                        <p id="hb-cbcliente" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label><a href="<?php echo HOME_URI; ?>/assistencia/modelo">Modelo</a> <i class="fa fa-info-circle fa-fw" id="info-modelo"></i></label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="id_modelo" id="cbModelo" value="<?php
                                        if (isset($equipamento['id_modelo'])) {
                                            echo $equipamento['id_modelo'];
                                        }
                                        ?>" style="width: 100%;" />
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="descricao" id="descricao_modelo_cb" value="<?php
                                            if (isset($equipamento['descricao'])) {
                                                echo $equipamento['descricao'];
                                            }
                                            ?>" disabled />
                                            <div class="input-group-addon"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarModeloExterno();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                        </div>
                                        <p id="hb-cbmodelo" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Teste OK</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="checkbox">
                                            <input type="checkbox" name="teste_ok" id="teste_ok" <?php
                                            if (isset($equipamento['teste_ok']) && $equipamento['teste_ok'] === true) {
                                                echo "checked";
                                            }
                                            ?> /> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Inativar</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="checkbox">
                                            <input type="checkbox" name="inativo" id="inativo" <?php
                                            if (isset($equipamento['inativo']) && $equipamento['inativo'] === true) {
                                                echo "checked";
                                            }
                                            ?> /> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarEquipamento();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarEquipamento();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarEquipamentoPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarEquipamentoPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirEquipamento();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarEquipamento();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgEquipamento" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="mwEmpresa" class="mw"></div>
        <div id="mwModelo" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/equipamento.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->


