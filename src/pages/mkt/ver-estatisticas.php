<?php
if (!defined('ABSPATH')) {
    exit;
}

$url[2] = (empty($url[2]) ? null : $url[2]);
echo '<script>var envio = ' . $url[2] . ';</script>';
?>

<div class="extractor">
    <div id="content-container">
        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/mkt/home">MKT</a></li>
            <li class="active">Estatísticas do Envio</li>
        </ol>
        <div id="page-content">

            <div class="row">
                <div class="col-md-8">
                    <div class="bt-panel">
                        <div class="bt-panel-heading">
                            <div class="bt-panel-control">
                                <i class="fa fa-info-circle fa-fw" id="info-leituras-hora"></i> 
                            </div>
                            <h3 class="bt-panel-title"><i class="fa fa-line-chart fa-fw"></i> Leituras de E-mails por Hora</h3>
                        </div>
                        <div class="bt-panel-body">
                            <div id="morris-line-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bt-panel">
                        <div class="bt-panel-heading">
                            <div class="bt-panel-control">
                                <i class="fa fa-info-circle fa-fw" id="info-status"></i>
                            </div>
                            <h3 class="bt-panel-title"><i class="fa fa-pie-chart fa-fw"></i> Status do Envio dos E-mails</h3>
                        </div>
                        <div class="bt-panel-body">
                            <div id="morris-donut-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="toolbar">
                        <div class="row">
                            <div class="col-sm-8">   
                                <button type="button" class="btn btn-primary" onclick="editarContatoEstatisticaExterno();"><span class="glyphicon glyphicon-edit"></span> Editar Contato</button>
                                <button type="button" class="btn btn-warning" onclick="limparFiltroEstatisticas();"><span class="glyphicon glyphicon-refresh"></span> Limpar</button>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="has-feedback">
                                            <input type="text" class="form-control" id="busca" onkeyup="pesquisarEstatisticas();" placeholder="Buscar...">
                                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="dgEstatisticas" style="width:100%;height:369px;"></table>
                </div>
            </div>

        </div>

        <div id="mwContato" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/plugins/morris-js/morris.min.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/plugins/morris-js/raphael.min.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/mkt/js/charts/status-envio.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/mkt/js/charts/hora-leitura.js"></script>'; ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/mkt/js/app/estatisticas.app.js"></script>'; ?>
        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
