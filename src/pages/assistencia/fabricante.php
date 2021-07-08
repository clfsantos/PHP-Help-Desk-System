<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/assistencia/dao/FabricanteDAO.php';

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
                $fabricanteDAO = new FabricanteDAO();
                $stmt = $fabricanteDAO->listarFabricante($pid);
                $fabricante = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Fabricante";
            } else {
                $op = "Cadastrar Fabricante";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/assistencia/home">Assistência</a></li>
                <li><a href="<?php echo HOME_URI; ?>/assistencia/fabricante">Fabricantes</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmFabricante" id="fmFabricante" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="codigo_fabricante" value="<?php
                                        if (isset($fabricante['codigo_fabricante'])) {
                                            echo $fabricante['codigo_fabricante'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-id-fabricante" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-10">                          
                                        <label>Fabricante</label>
                                        <input type="text" class="form-control" name="nome_fabricante" id="nome_fabricante" value="<?php
                                        if (isset($fabricante['nome_fabricante'])) {
                                            echo $fabricante['nome_fabricante'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-fabricante" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarFabricante();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarFabricante();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarFabricantePg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarFabricantePg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirFabricante();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarFabricante();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgFabricante" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/fabricante.app.js"></script>'; ?>
        
        <div id="mensagem"></div>
    </div>
</div><!--extractor-->

