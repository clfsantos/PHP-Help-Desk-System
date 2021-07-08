<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/geral/dao/CidadeDAO.php';

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
                $cidadeDAO = new CidadeDAO();
                $stmt = $cidadeDAO->listarCidade($pid);
                $cidade = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Cidade";
            } else {
                $op = "Cadastrar Cidade";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
                <li><a href="<?php echo HOME_URI; ?>/geral/cidade">Cidades</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmCidade" id="fmCidade" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="cidade_id" value="<?php
                                        if (isset($cidade['cidade_id'])) {
                                            echo $cidade['cidade_id'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-cidade-id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-10">                          
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="cidade_nome" id="cidade_nome" value="<?php
                                        if (isset($cidade['cidade_nome'])) {
                                            echo $cidade['cidade_nome'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-cidade-nome" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Estado <i class="fa fa-info-circle fa-fw" id="info-estado"></i></label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="estado_id" id="cbEstado" value="<?php
                                        if (isset($cidade['estado_id'])) {
                                            echo $cidade['estado_id'];
                                        }
                                        ?>" style="width:100%;" />
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="estado_nome" id="cbestado_nome" value="<?php
                                            if (isset($cidade['estado_nome'])) {
                                                echo $cidade['estado_nome'];
                                            }
                                            ?>" disabled />
                                            <div class="input-group-addon"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarEstadoExterno();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                        </div>
                                        <p id="hb-cbestado" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarCidade();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarCidade();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarCidadePg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarCidadePg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirCidade();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarCidade();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgCidade" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div id="mwEstado" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/cidade.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
