<?php
if (!defined('ABSPATH')) {
    exit;
}
include ABSPATH . '/modulo/geral/dao/PainelDAO.php';
$painelDAO = new PainelDAO();
$andamento = $painelDAO->implantacaoAndamento($_SESSION['usuarioID']);
$pendente = $painelDAO->implantacaoPendente($_SESSION['usuarioID']);
$finalizacao = $painelDAO->implantacaoPendenteFinalizacao();
?>
<div id="content-container">

    <div id="page-title">
        <h1 class="page-header text-overflow">Painel do Usuário</h1>
    </div>

    <div id="page-content">

        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Atalhos</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <a href="<?php echo HOME_URI; ?>/assistencia/home">
                                    <div class="bt-panel media pad-all">
                                        <div class="media-left">
                                            <span class="icon-wrap icon-wrap-xs bg-trans">
                                                <i class="fa fa-wrench fa-3x"></i>
                                            </span>
                                        </div>

                                        <div class="media-body" style="vertical-align: middle;">
                                            <p class="text-2x mar-no text-semibold">Assistência</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="<?php echo HOME_URI; ?>/suporte/chamado">
                                    <div class="bt-panel media pad-all">
                                        <div class="media-left">
                                            <span class="icon-wrap icon-wrap-xs bg-trans">
                                                <i class="fa fa-support fa-3x"></i>
                                            </span>
                                        </div>

                                        <div class="media-body" style="vertical-align: middle;">
                                            <p class="text-2x mar-no text-semibold">Chamados</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="<?php echo HOME_URI; ?>/suporte/home">
                                    <div class="bt-panel media pad-all">
                                        <div class="media-left">
                                            <span class="icon-wrap icon-wrap-xs bg-trans">
                                                <i class="fa fa-dashboard fa-3x"></i>
                                            </span>
                                        </div>

                                        <div class="media-body" style="vertical-align: middle;">
                                            <p class="text-2x mar-no text-semibold">Suporte</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Implantações com Fluxo Pendente de Aprovação</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Chamado</th>
                                        <th>Etapa</th>
                                        <th>Empresa</th>
                                        <th>SLA Vencido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendente as $row) { ?>
                                        <tr>
                                            <td><a href="<?php echo HOME_URI . '/suporte/chamado/editar/' . $row['spchamado_id']; ?>" class="btn-link"><?php echo $row['spchamado_id']; ?></a></td>
                                            <td><?php echo $row['etapa_desc']; ?></td>
                                            <td><?php echo $row['crcliente_fantasia']; ?></td>
                                            <td>
                                                <?php 
                                                if ($row['etapa_imp_hrs_sla'] == 1) { 
                                                    echo 'Sim ' . $row['etapa_imp_hrs'] . ' Horas / ' . $row['etapa_hrs'] . ' Horas';
                                                } else {
                                                    echo 'Não ' . $row['etapa_imp_hrs'] . ' Horas / ' . $row['etapa_hrs'] . ' Horas';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Implantações Pendentes de Finalização</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Chamado</th>
                                        <th>Etapa</th>
                                        <th>Empresa</th>
                                        <th>SLA Vencido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($finalizacao as $row) { ?>
                                        <tr>
                                            <td><a href="<?php echo HOME_URI . '/suporte/chamado/editar/' . $row['spchamado_id']; ?>" class="btn-link"><?php echo $row['spchamado_id']; ?></a></td>
                                            <td><?php echo $row['etapa_desc']; ?></td>
                                            <td><?php echo $row['crcliente_fantasia']; ?></td>
                                            <td>
                                                <?php 
                                                if ($row['etapa_imp_hrs_sla'] == 1) { 
                                                    echo 'Sim ' . $row['etapa_imp_hrs'] . ' Horas / ' . $row['etapa_hrs'] . ' Horas';
                                                } else {
                                                    echo 'Não ' . $row['etapa_imp_hrs'] . ' Horas / ' . $row['etapa_hrs'] . ' Horas';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Implantações com Fluxo em Andamento</h3>
                    </div>
                    <div class="bt-panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Chamado</th>
                                        <th>Etapa</th>
                                        <th>Empresa</th>
                                        <th>SLA Vencido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($andamento as $row) { ?>
                                        <tr>
                                            <td><a href="<?php echo HOME_URI . '/suporte/chamado/editar/' . $row['spchamado_id']; ?>" class="btn-link"><?php echo $row['spchamado_id']; ?></a></td>
                                            <td><?php echo $row['etapa_desc']; ?></td>
                                            <td><?php echo $row['crcliente_fantasia']; ?></td>
                                            <td>
                                                <?php 
                                                if ($row['etapa_imp_hrs_sla'] == 1) { 
                                                    echo 'Sim ' . $row['etapa_imp_hrs'] . ' Horas / ' . $row['etapa_hrs'] . ' Horas';
                                                } else {
                                                    echo 'Não ' . $row['etapa_imp_hrs'] . ' Horas / ' . $row['etapa_hrs'] . ' Horas';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>

    <div id="mwChamado" class="mw"></div>
    <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/painel.app.js"></script>'; ?>
</div>
