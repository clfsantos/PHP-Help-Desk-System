<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
            <li class="active">Integração Junsoft</li>
        </ol>
        <div id="page-content">
            <div class="bt-panel">
                <div class="bt-panel-heading">
                    <h3 class="bt-panel-title">
                        Integração Junsoft
                    </h3>
                </div>
                <form role="form" name="fmIJunsoft" id="fmIJunsoft" method="post" action="">
                    <div class="bt-panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <button type="button" id="ijunsoft" class="btn btn-lg btn-primary btn-labeled fa fa-gears fa-2x">Rodar Integração</button>
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
                        <p>A integração do Junsoft irá incluir novos cadastrados e também atualizar o cadastro dos já existentes. Também irá atualizar ou incluir o perfil de cada cliente.</p>
                    </div>
                </form>
            </div>
        </div>

        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/integracao-junsoft.app.js"></script>'; ?>

    </div>
</div><!--extractor-->
