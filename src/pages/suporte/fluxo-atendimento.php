<?php
if (!defined('ABSPATH')) {
    exit;
}
$conexao = new Conexao;
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT id, nome FROM usuario WHERE crperfil_id = 2 AND ativo = true ORDER BY nome ASC';
$stmt = $conexao->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow">Fluxo de Atendimento</h1>
    </div>
    <div id="page-content">
        <div class="bt-panel">
            <div class="bt-panel-heading">
                <h3 class="bt-panel-title">
                    <div id="container-prioridade"></div>
                </h3>
            </div>
            <form role="form" name="fmFluxo" id="fmFluxo" method="post" action="">
                <div class="bt-panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">                          
                                <label>Nome</label>
                                <select class="easyui-combobox" name="tecnico" id="tecnico" data-options="editable: false" style="width:100%;">
                                    <option></option>
                                    <?php
                                    foreach ($rows as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <p id="hb-fluxo-nome" class="help-block hb-erro"></p>
                            </div>
                            <div class="col-md-9">                          
                                <label>Cliente</label>
                                <input type="text" class="form-control" name="crcliente_id" id="cbCliente" style="width: 100%;" />
                                <p id="hb-fluxo-empresa" class="help-block hb-erro"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bt-panel-footer">
                    <button type="button" name="salvar" class="btn btn-lg btn-success load" onclick="salvarAtendimento();"><span class="glyphicon glyphicon-ok"></span> SALVAR</button>
                </div>
            </form>
        </div>
        <table id="dgFluxo" style="width:100%;"></table>
    </div>
    <?php echo '<script src="' . HOME_URI . '/modulo/suporte/js/app/fluxo-atendimento.app.js"></script>'; ?>
    <div id="mensagem"></div>
</div>