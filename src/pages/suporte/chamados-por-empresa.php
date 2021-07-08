<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow">Chamados por Empresa</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Filtros</h3>
                    </div>
                    <div class="bt-panel-body">
                        <form role="form" name="fmFiltroChamados" id="fmFiltroChamados" method="post" action="<?php echo HOME_URI . '/modulo/suporte/relatorio/chamados-por-empresa-export.php'; ?>">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>Data Inicial</label>
                                        <input type="text" class="form-control" name="dtInicial" id="dtInicial" style="width: 100%;" />
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-2">                          
                                        <label>Data Final</label>
                                        <input type="text" class="form-control" name="dtFinal" id="dtFinal" style="width: 100%;" />
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Produto</label>
                                        <select class="easyui-combobox cbProduto" name="spchamado_produto_id[]" data-options="value:'1,2'" style="width:100%;"></select>
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Classificação</label>
                                        <select class="easyui-combobox cbClass" name="spchamado_class_id[]" data-options="value:'1,2'" style="width:100%;"></select>
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-2">                          
                                        <label>Situação</label>
                                        <select class="easyui-combobox" name="spchamado_aberto[]" data-options="multiple:true,value:'true,false'" style="width:100%;">
                                        <option value="true">Aberto</option>
                                        <option value="false">Fechado</option>
                                        </select>
                                        <p class="help-block hb-erro"></p>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-md-7">                          
										<label>Cliente</label>
										<input type="text" class="form-control" name="crcliente_id" id="cbCliente" style="width: 100%;" />
										<p id="hb-fluxo-empresa" class="help-block hb-erro"></p>
									</div>
								</div>
                                <div class="row">
                                    <div class="col-lg-12">                          
                                        <button type="button" name="editar" class="btn btn-success load" onclick="geraChamadosPorEmpresaGrade();"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-export"></span> Exportar</button>
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
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/charts/chamados-por-empresa.js"></script>'; ?>
</div>