<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow">Painel de Chamados</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-md-8">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <div class="bt-panel-control">
                            <div id="dlgDatas" class="easyui-dialog" style="display:none;width:100%;max-width:400px;">
                                <div class="container-fluid">
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-6">                          
                                            <label>Data Inicial</label>
                                            <input type="text" class="easyui-datebox" name="data_inicial" id="data_inicial" style="width: 100%;" />
                                            <p id="hb-dtinicial" class="help-block hb-erro"></p>
                                        </div>
                                        <div class="col-md-6">                          
                                            <label>Data Final</label>
                                            <input type="text" class="easyui-datebox" name="data_final" id="data_final" style="width: 100%;" />
                                            <p id="hb-dtfinal" class="help-block hb-erro"></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="dlg-buttons-data">
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="filtrarDatas();"><span class="glyphicon glyphicon-filter"></span> Aplicar</a>
                                </div>
                            </div>
                            <select id="cbChamadosData" class="easyui-combobox" name="cbChamadosData" data-options="value:'u30'" style="width:100%;">
                                <option value="u1">Ontem</option>
                                <option value="u7">Últimos 7 Dias</option>
                                <option value="u30">Últimos 30 Dias</option>
                                <option value="dts">Personalizado</option>
                            </select>
                        </div>
                        <h3 class="bt-panel-title"><i class="fa fa-line-chart fa-fw"></i> Chamados por Data</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div id="chamados-mes" style="height:200px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title"><i class="fa fa-pie-chart fa-fw"></i> Por técnico</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div id="chamados-tecnico-mes" style="height:200px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <div class="bt-panel-control">
                            <select class="easyui-combobox" name="spchamado_dt_ano" id="cbChamadoAno" data-options="value:<?php echo date('Y'); ?>" style="width:100%;"></select>
                        </div>
                        <h3 class="bt-panel-title"><i class="fa fa-bar-chart fa-fw"></i> Chamados por Ano</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div id="chamados-por-ano" style="height:200px;"></div>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="easyui-combobox" name="perfil" id="cbPerfil" style="width:100%;">
                                        <option value="4">Sem Contrato</option>
                                        <option value="1">Contrato</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="easyui-combobox" name="comp" id="cbComp" style="width:100%;">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="25">25</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="has-feedback">
                                        <input type="text" class="form-control" id="busca" placeholder="Buscar...">
                                        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        
                        <h3 class="bt-panel-title">Teste</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="table-responsive">
                            <table id="tbClientesRecorrentes" class="table table-striped table-bordered" cellspacing="0" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Razão Social</th>
                                        <th>Nome Fantasia</th>
                                        <th>Chamados</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <?php echo '<script src="' . HOME_URI . '/plugins/morris-js/morris.min.js"></script>'; ?>
    <?php echo '<script src="' . HOME_URI . '/plugins/morris-js/raphael.min.js"></script>'; ?>
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/charts/painel-charts.js"></script>'; ?>
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/painel.app.js"></script>'; ?>
</div>