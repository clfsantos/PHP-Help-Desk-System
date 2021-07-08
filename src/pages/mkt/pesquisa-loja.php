<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow">Envio da Pesquisa de Satisfação (Loja Tecsmart)</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-body">
                        <form role="form" name="fmEnvioPesquisa" id="fmEnvioPesquisa" method="post" action="">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">                          
                                                    <label>E-mails</label>
                                                    <textarea class="form-control" rows="3" name="email" id="email" placeholder="Entre com um e-mail ou vários e-mails separados por vírgula(,) ou por ponto e vírgula (;)"></textarea>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="button" name="salvar" class="btn btn-success btn-social load" onclick="enviarEmail();"><i class="fa fa-paper-plane"></i> Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo '<script src="' . HOME_URI . '/modulo/mkt/js/app/pesquisa-loja.app.js"></script>'; ?>