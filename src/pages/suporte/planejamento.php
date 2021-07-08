<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div id="mensagem"></div>

    <ol class="breadcrumb">
        <li><a href="<?php echo HOME_URI; ?>/suporte/chamado">Chamados</a></li>
        <li class="active">Planejamento da Agenda</li>
    </ol>

    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Planejamento da Agenda</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <select class="easyui-combobox cbUsuarioFiltro" id="cbUsuarioFiltro" name="cbUsuarioFiltro" style="width:100%;"></select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">
                                <div id="mensagem"></div>
                                <div id="calendar"></div>
                                <p style="margin-top: 20px;">Legenda:</p>
                                <div style="background-color:#000000;width:12px;height:12px;float:left;margin-right:5px;"></div> <p style="line-height:12px;">Tarefa Concluída</p>
                                <div style="background-color:#2196F3;width:12px;height:12px;float:left;margin-right:5px;"></div> <p style="line-height:12px;">Tarefa em Aberto</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="mwChamado" class="mw"></div>
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/agenda.app.js"></script>'; ?>
</div>
