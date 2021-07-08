<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <div id="page-content">
            <div class="row">
                <div class="col-lg-12">
                    <div style="height: 37px;"></div>
                </div>
            </div>
            <button type="button" class="btn btn-success" onclick="testeDialog();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
            
        </div>
        <div id="mwEstado" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/teste.app.js"></script>'; ?>
        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
