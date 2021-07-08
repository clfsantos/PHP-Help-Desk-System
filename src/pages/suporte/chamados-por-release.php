<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow">Chamados por Release</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Filtros</h3>
                    </div>
                    <div class="bt-panel-body">
                        <form role="form" name="fmFiltroChamados" id="fmFiltroChamados" method="post" action="#">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-3">                          
                                        <label>Produto</label>
                                        <select class="easyui-combobox" id="cbProduto" name="spchamado_produto_id" data-options="value:'2'" style="width:100%;"></select>
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Release</label>
                                        <select class="easyui-combobox" id="cbRelease" name="spchamado_release_id[]" style="width:100%;"></select>
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">                          
                                        <button type="button" name="editar" class="btn btn-success load" onclick="geraChamadosPorEmpresaGrade();"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Chamados</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div id="gradeChamados"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id="mwChamado" class="mw"></div>
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/charts/chamados-por-release.js"></script>'; ?>
</div>