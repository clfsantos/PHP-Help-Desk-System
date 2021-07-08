<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div class="extractor">
        <?php
        include ABSPATH . '/modulo/suporte/dao/ReleaseDAO.php';

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
                $releaseDAO = new ReleaseDAO();
                $stmt = $releaseDAO->listarRelease($pid);
                $release = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Release";
            } else {
                $op = "Cadastrar Release";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/suporte/home">Suporte</a></li>
                <li><a href="<?php echo HOME_URI; ?>/suporte/release">Releases</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmRelease" id="fmRelease" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="spchamado_release_id" value="<?php
                                        if (isset($release['spchamado_release_id'])) {
                                            echo $release['spchamado_release_id'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb_spchamado_release_id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Produto</label>
                                        <select class="easyui-combobox cbProduto" name="spchamado_produto_id" data-options="value:<?php
                                        if (isset($release['spchamado_produto_id'])) {
                                            echo $release['spchamado_produto_id'];
                                        } else {
                                            echo 1;
                                        }
                                        ?>" style="width:100%;">
                                        </select>
                                        <p id="hb_spchamado_produto_id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Versão</label>
                                        <input type="text" class="form-control" name="spchamado_release_num" id="spchamado_release_num" value="<?php
                                        if (isset($release['spchamado_release_num'])) {
                                            echo $release['spchamado_release_num'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb_spchamado_release_num" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-4">                          
                                        <label>Data da Release</label>
                                        <input type="text" class="form-control calendario" name="spchamado_release_dt_fmt" id="spchamado_release_dt_fmt" value="<?php
                                        if (isset($release['spchamado_release_dt_fmt'])) {
                                            echo $release['spchamado_release_dt_fmt'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb_spchamado_release_dt_fmt" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">                          
                                        <label>Alterações</label>
                                        <textarea class="form-control" name="spchamado_release_desc" id="spchamado_release_desc" rows="5"><?php
                                            if (isset($release['spchamado_release_desc'])) {
                                                echo $release['spchamado_release_desc'];
                                            }
                                            ?></textarea>
                                        <p id="hb_spchamado_release_desc" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarRelease();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarRelease();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarReleasePg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarReleasePg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirRelease();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarRelease();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgRelease" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/release.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div><!--extractor-->
</div>