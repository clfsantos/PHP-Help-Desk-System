<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/mkt/home">MKT</a></li>
            <li class="active">Envios de Newsletter</li>
        </ol>
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12" style="padding-bottom:13px;">
                    <div id="toolbar">
                        <div class="row">
                            <div class="col-sm-8">
                                <button type="button" class="btn btn-default" onclick="verMensagem();"><i class="fa fa-eye fa-fw"></i> Ver Mensagem</button>
                                <button type="button" class="btn btn-default" onclick="verEstatisticas();"><i class="fa fa-area-chart fa-fw"></i> Estatísticas</button>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="has-feedback">
                                            <input type="text" class="form-control" id="busca" onkeyup="pesquisarEnvio();" placeholder="Buscar...">
                                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="dgEnvio" style="width:100%;height:369px;"></table>
                </div>
            </div>
        </div>

        <div id="mwMensagem" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/modulo/mkt/js/app/envio.app.js"></script>'; ?>

    </div>
</div><!--extractor-->
