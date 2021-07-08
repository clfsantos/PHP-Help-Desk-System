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

            <div id="dlgRecado" style="width:80%;max-width:800px;padding-top:10px;display:none;">

                <form role="form" name="fmRecado" id="fmRecado" method="post" action="">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-1">                          
                                <label>ID</label>
                                <input type="text" class="form-control" readonly="readonly" name="recado_id" style="width: 100%;" />
                                <p id="hb-id" class="help-block hb-erro"></p>
                            </div>
                            <div class="col-lg-5">                          
                                <label>Empresa</label>
                                <input type="text" class="form-control" name="recado_empresa" id="recado_empresa" style="width: 100%;" />
                                <p id="hb-empresa" class="help-block hb-erro"></p>
                            </div>
                            <div class="col-lg-3">                          
                                <label>Contato</label>
                                <input type="text" class="form-control" name="recado_contato" id="recado_contato" style="width: 100%;" />
                                <p id="hb-contato" class="help-block hb-erro"></p>
                            </div>
                            <div class="col-lg-3">
                                <label>Departamento</label>
                                <select class="easyui-combobox" id="recado_destino" name="recado_destino" style="width:100%;">
                                    <option value="Comercial">Comercial</option>
                                    <option value="Desenvolvimento">Desenvolvimento</option>
                                    <option value="Financeiro">Financeiro</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Suporte">Suporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Recado</label>
                                <textarea class="form-control" name="recado_desc" id="recado_desc" rows="3"></textarea>
                                <p id="hb-recado" class="help-block hb-erro"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="dlg-buttons-recado">
                                    <span id="hb-erro" class="help-block hb-erro" style="text-align: left;float: left;"></span>
                                    <button type="button" name="salvar" class="btn btn-success load" onclick="salvarRecado();"><span class="glyphicon glyphicon-ok"></span> Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

            <div class="row">
                <div class="col-lg-12" style="padding-bottom:13px;">
                    <div id="toolbar">
                        <div class="row">
                            <div class="col-sm-8">   
                                <button type="button" class="btn btn-success" onclick="cadastrarRecado();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                <button type="button" class="btn btn-primary" onclick="editarRecado();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                <button type="button" class="btn btn-success" title="Marcar Atendido" onclick="atenderRecado();"><span class="fa fa-check-square-o"></span> </button>
                                <button type="button" class="btn btn-info" title="Marcar Não Atendido" onclick="marcarNaoAtendido();"><span class="fa fa-eye-slash"></span> </button>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="has-feedback">
                                            <input type="text" class="form-control" id="busca" onkeyup="pesquisarRecado();" placeholder="Buscar...">
                                            <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="dgRecado" style="width:100%;height:369px;"></table>
                </div>
            </div>
        </div>

        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/recado.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
