<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
            <li class="active">Integração Omie - Rápida</li>
        </ol>
        <div id="page-content">
            <div class="bt-panel">
                <div class="bt-panel-heading">
                    <h3 class="bt-panel-title">
                        Integração Omie
                    </h3>
                </div>
                <form role="form" name="fmIOmieR" id="fmIOmieR" method="post" action="">
                    <div class="bt-panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <button type="button" id="iomie" class="btn btn-lg btn-primary btn-labeled fa fa-gears fa-2x">Rodar Integração</button>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <div id="mensagem"></div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div id="ijprogress" class="bt-panel-footer">
                        <p>A integração rápida da Omie irá incluir somente novos cadastrados.</p>
                    </div>
                </form>
            </div>
        </div>

        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/integracao-omie-r.app.js"></script>'; ?>

    </div>
</div><!--extractor-->
