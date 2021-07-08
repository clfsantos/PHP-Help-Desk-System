<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div id="mensagem"></div>
    <div class="extractor">        
        <?php
        include ABSPATH . '/modulo/suporte/dao/GrupoChamadoDAO.php';

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
            echo '<script>var gid = ' . $pid . ';</script>';
        } else {
            echo '<script>var gid = 0;</script>';
        }

        if ($action === 'editar' || $action === 'cadastrar') {
            if ($action === 'editar') {
                $conexao = new Conexao();
                $grupoDAO = new GrupoChamadoDAO();
                $stmt = $grupoDAO->listarGrupo($pid);
                $grupo = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Grupo";
            } else {
                $op = "Cadastrar Grupo";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/suporte/home">Suporte</a></li>
                <li><a href="<?php echo HOME_URI; ?>/suporte/grupo">Grupos</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmGrupo" id="fmGrupo" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">                          
                                                <label>ID</label>
                                                <input type="text" class="form-control" readonly="readonly" name="spchamado_grupo_id" value="<?php
                                                if (isset($grupo['spchamado_grupo_id'])) {
                                                    echo $grupo['spchamado_grupo_id'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-grupo-id" class="help-block hb-erro"></p>
                                            </div>
                                            <div class="col-lg-10">                          
                                                <label>Descrição</label>
                                                <input type="text" class="form-control" name="spchamado_grupo_desc" id="spchamado_grupo_desc" value="<?php
                                                if (isset($grupo['spchamado_grupo_desc'])) {
                                                    echo $grupo['spchamado_grupo_desc'];
                                                }
                                                ?>" style="width: 100%;" />
                                                <p id="hb-grupo-desc" class="help-block hb-erro"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mar-lft">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>Produtos do Grupo <i class="fa fa-info-circle fa-fw" id="info-produto"></i></label>
                                                    <div class="pull-right"><a href="javascript:void(0);" title="Adicionar" onclick="cadastrarProdutoExterno();"><span class="glyphicon glyphicon-plus"></span></a></div>
                                                    <div id="dlProduto" style="width: 100%;"></div>
                                                    <p id="hb-lista-produtos" class="help-block hb-erro"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarGrupo();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarGrupo();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarGrupoPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarGrupoPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirGrupo();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">

                                    <div class="has-feedback">
                                        <input type="text" class="form-control" id="busca" onkeyup="pesquisarGrupo();" placeholder="Buscar...">
                                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <table id="dgGrupo" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="mwProduto" class="mw"></div>

        <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/grupo.app.js"></script>'; ?>

    </div><!--extractor-->
</div>
