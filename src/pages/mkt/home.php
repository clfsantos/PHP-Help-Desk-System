<?php
if (!defined('ABSPATH')) {
    exit;
}

$conexao = new Conexao();
$query = "SELECT count(id) as contatos from contato";
$stmt = $conexao->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$qtd_contatos = $row['contatos'];

$query = "SELECT count(id) as baixas from contato where baixa = true";
$stmt = $conexao->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$qtd_baixas = $row['baixas'];

$query = "select count(contato_id) as leituras from envio_leitura";
$stmt = $conexao->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$qtd_leituras = $row['leituras'];

$query = "select count(contato_id) as envios from envio_mala";
$stmt = $conexao->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$qtd_envios = $row['envios'];
?>

<!--CONTENT CONTAINER-->
<!--===================================================-->
<div id="content-container">

    <div id="page-title">
        <h1 class="page-header text-overflow">Painel de Marketing</h1>
    </div>

    <!--Page content-->
    <!--===================================================-->
    <div id="page-content">

        <div class="row">
            <div class="col-sm-6 col-lg-4">

                <!--Registered User-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-success">
                            <i class="fa fa-database fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo $qtd_contatos; ?></p>
                        <div class="pull-left">
                            <span class="text-muted mar-no">Contatos Cadastrados</span>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo HOME_URI; ?>/mkt/contato#tudo">Ver contatos</a>
                        </div>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>
            <div class="col-sm-6 col-lg-4">

                <!--New Order-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-info">
                            <i class="fa fa-percent fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo round((($qtd_leituras * 100) / $qtd_envios), 2) . '%'; ?></p>
                        <div class="pull-left">
                            <span class="text-muted mar-no">Geral de Leituras</span>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo HOME_URI; ?>/mkt/contato#ativo">Ver contatos</a>
                        </div>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>
            <div class="col-sm-6 col-lg-4">

                <!--Comments-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-danger">
                            <i class="fa fa-close fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo $qtd_baixas; ?></p>
                        <div class="pull-left">
                            <span class="text-muted mar-no">Baixa nos Envios</span>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo HOME_URI; ?>/mkt/contato#baixa">Ver contatos</a>
                        </div>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>

        </div>


        



    </div>
    <!--===================================================-->
    <!--End page content-->


</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->
