<?php
if (!defined('ABSPATH')) {
    exit;
}
$usuarioID = $_SESSION['usuarioID'];
$p_users = array(7, 35);
?>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow"></h1>
    </div>
    <div id="page-content">
        <div class="bt-panel">
            <div class="bt-panel-heading">
                <h3 class="bt-panel-title">
                    Fila de Espera
                </h3>
            </div>
            <form role="form" name="fmFila" id="fmFila" method="post" action="">
                <div class="bt-panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">                          
                                <label>Cliente</label>
                                <input type="hidden" name="spchamado_fila_id" id="spchamado_fila_id" />
                                <input type="text" class="form-control" name="crcliente_id" id="cbCliente" style="width: 100%;" />
                                <p id="hb-fila-empresa" class="help-block hb-erro"></p>
                            </div>
                            <div class="col-md-12">
                                <label>Observação</label>
                                <textarea class="form-control" name="fila_obs" rows="3"></textarea>
                                <p class="help-block hb-erro"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bt-panel-footer">
                    <button type="button" name="salvar" class="btn btn-success load" onclick="salvarFila();"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
                </div>
            </form>
        </div>
        <div id="toolbar">
            <div class="row">
                <div class="col-sm-8">                     
                    <button type="button" class="btn btn-primary" onclick="editarAtendimento();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
					<?php if (in_array($usuarioID, $p_users)) { ?>
                    <button type="button" class="btn btn-danger" onclick="cancelarAtendimento();"><span class="glyphicon glyphicon-remove"></span> Cancelar Atendimento</button>
					<?php } ?>
                </div>
            </div>
        </div>
        <table id="dgFila" style="width:100%;"></table>
    </div>
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/fila-espera.app.js"></script>'; ?>
    <div id="mensagem"></div>
</div>