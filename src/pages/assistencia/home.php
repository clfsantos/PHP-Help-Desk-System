<?php
if (!defined('ABSPATH')) {
    exit;
}
include ABSPATH . '/modulo/assistencia/dao/PainelDAO.php';
$painelDAO = new PainelDAO();
$media = $painelDAO->mediaDiasAssistencia();
$total = $painelDAO->totalGeralAssistencia();
$slavencidoqtd = $painelDAO->slaAssistenciaVencido();
$abertas = $painelDAO->assistenciasAbertas();
$slavencido = $painelDAO->slaVencido();
$abertasMais30 = $painelDAO->abertasMais30Dias();
?>
<div id="content-container">

    <div id="page-title">
        <h1 class="page-header text-overflow">Painel de Assistência</h1>
    </div>

    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Assistências nos últimos 7 dias</h3>
                    </div>
                    <div class="bt-panel-body">

                        <!--Morris Line Chart placeholder-->
                        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                        <div id="painel-assistencia" style="height:200px"></div>
                        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

                    </div>
                </div>
            </div>
        </div>
        <!--Tiles - Bright Version-->
        <!--===================================================-->
        <div class="row">
            <div class="col-sm-6 col-lg-3">

                <!--Registered User-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-success">
                            <i class="fa fa-database fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo $total; ?></p>
                        <a href="<?php echo HOME_URI; ?>/assistencia/manutencao#tudo"><p class="text-muted mar-no">Total geral de assistências</p></a>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>
            <div class="col-sm-6 col-lg-3">

                <!--New Order-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-info">
                            <i class="fa fa-exchange fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo $media; ?></p>
                        <p class="text-muted mar-no">Média dos dias em manutenção</p>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>
            <div class="col-sm-6 col-lg-3">

                <!--Comments-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-warning">
                            <i class="fa fa-wrench fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo $abertas; ?></p>
                        <a href="<?php echo HOME_URI; ?>/assistencia/manutencao#aberto"><p class="text-muted mar-no">Assistências abertas</p></a>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>
            <div class="col-sm-6 col-lg-3">

                <!--Sales-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="bt-panel media pad-all">
                    <div class="media-left">
                        <span class="icon-wrap icon-wrap-xs bg-danger">
                            <i class="fa fa-calendar-times-o fa-3x"></i>
                        </span>
                    </div>

                    <div class="media-body">
                        <p class="text-2x mar-no text-semibold"><?php echo $slavencidoqtd; ?></p>
                        <p class="text-muted mar-no">SLAs vencidos</p>
                    </div>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

            </div>
        </div>
        <!--===================================================-->
        <!--End Tiles - Bright Version-->
        <?php if (!empty($slavencido)) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Assistências com SLA vencido</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Data Entrada</th>
                                        <th>Empresa</th>
                                        <th>Dias em Assistência</th>
                                        <th>Último Followup</th>
                                        <th>Followup</th>
                                        <th>Usuário</th>
                                        <th>SLA Vencido em</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($slavencido as $row) { ?>
                                        <tr>
                                            <td><a href="<?php echo HOME_URI . '/assistencia/detalhes-manutencao/' . $row['assistencia_id']; ?>" class="btn-link"><?php echo $row['assistencia_id']; ?></a></td>
                                            <td><?php echo $row['data_entrada']; ?></td>
                                            <td><?php echo $row['nome_fantasia']; ?></td>
                                            <td><?php echo $row['dias_manutencao']; ?></td>
                                            <td><?php echo $row['data_followup'] . ' ('.$row['dias_ultimo_up'].' dias)'; ?></td>
                                            <td><b><?php echo $row['descricao_evento']; ?></b><div><?php echo $row['followup_conteudo']; ?></div></td>
                                            <td><?php echo $row['nome_tecnico']; ?></td>
                                            <td><?php echo $row['sla']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($abertasMais30)) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Assistências abertas a mais de 30 dias</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Data Entrada</th>
                                        <th>Empresa</th>
                                        <th>Dias em Assistência</th>
                                        <th>Último Followup</th>
                                        <th>Followup</th>
                                        <th>Usuário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($abertasMais30 as $row) { ?>
                                        <tr>
                                            <td><a href="<?php echo HOME_URI . '/assistencia/detalhes-manutencao/' . $row['assistencia_id']; ?>" class="btn-link"><?php echo $row['assistencia_id']; ?></a></td>
                                            <td><?php echo $row['data_entrada']; ?></td>
                                            <td><?php echo $row['nome_fantasia']; ?></td>
                                            <td><?php echo $row['dias_manutencao']; ?></td>
                                            <td><?php echo $row['data_followup'] . ' ('.$row['dias_ultimo_up'].' dias)'; ?></td>
                                            <td><b><?php echo $row['descricao_evento']; ?></b><div><?php echo $row['followup_conteudo']; ?></div></td>
                                            <td><?php echo $row['nome_tecnico']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>

    <?php echo '<script src="' . HOME_URI . '/plugins/morris-js/morris.min.js"></script>'; ?>
    <?php echo '<script src="' . HOME_URI . '/plugins/morris-js/raphael.min.js"></script>'; ?>
    <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/charts/painel-assistencia.js"></script>'; ?>
</div>
