<?php
if (!defined('ABSPATH')) {
    exit;
}
$id = (empty($url[2]) ? null : $url[2]);
include ABSPATH . '/modulo/assistencia/dao/ManutencaoDAO.php';
$manutencaoDAO = new ManutencaoDAO();
$dassistencia = $manutencaoDAO->detalhesManutencao($id);
$dfollowup = $manutencaoDAO->detalhesManutencaoFollowup($id);
?>
<div id="content-container">
    
    <ol class="breadcrumb">
        <li><a href="<?php echo HOME_URI; ?>/assistencia/home">Assistência</a></li>
        <li><a href="<?php echo HOME_URI; ?>/assistencia/manutencao">Assistências</a></li>
        <li class="active">Detalhes da Manutenção</li>
    </ol>

    <div id="page-content">

        <div class="row">
            <div class="col-md-12">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">Detalhes da Manutenção</h3>
                    </div>

                    <!-- Striped Table -->
                    <!--===================================================-->
                    <div class="bt-panel-body">
                        <div style="padding: 0 20px 0 20px;"><a href="<?php echo HOME_URI . '/assistencia/manutencao/editar/' . $id; ?>" class="btn btn-primary btn-labeled fa fa-pencil">Editar Manutenção</a></div>
                        <div class="table-responsive">
                            <table class="table table-striped clfs-dm">
                                <thead>
                                    <tr>
                                        <th colspan=2 style="text-align: center;">Detalhes da Assistência</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="clfs-left">Número de série:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['nr_serie']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Modelo do equipamento:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['descricao']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Data da entrada:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['data_entrada']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Problema inicial:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['problema_inicial']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Tempo em manutencao:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['dias_manutencao']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Status:</td>
                                        <td class="clfs-right">
                                            <?php
                                            if ($dassistencia['manutencao_ativa'] === true) {
                                                echo "Em andamento";
                                            } else {
                                                echo "Finalizado";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Laudo técnico:</td>
                                        <td class="clfs-right">
                                            <?php
                                            if ($dassistencia['laudo_tecnico'] === null) {
                                                echo "O equipamento ainda está em manutenção!";
                                            } else {
                                                echo $dassistencia['laudo_tecnico'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Data de devolução:</td>
                                        <td class="clfs-right">
                                            <?php
                                            if ($dassistencia['data_devolucao'] === null) {
                                                echo "Ainda não foi devolvido!";
                                            } else {
                                                echo $dassistencia['data_devolucao'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped clfs-dm">
                                <thead>
                                    <tr>
                                        <th colspan=2 style="text-align: center;">Detalhes da Empresa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="clfs-left">CNPJ:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['crcliente_cnpj']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Razão social:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['crcliente_razao']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Nome fantasia:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['crcliente_fantasia']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">E-mail:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['crcliente_email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Telefone:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['crcliente_telefone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="clfs-left">Contato:</td>
                                        <td class="clfs-right"><?php echo $dassistencia['crcliente_contato']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped clfs-dm">
                                <thead>
                                    <tr>
                                        <th colspan=3 style="text-align: center;">Andamento da Assistência - Followup</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dfollowup as $f) { ?>
                                        <tr>
                                            <td class="clfs-left"><?php echo $f['data_followup']; ?></td>
                                            <td class="clfs-fcenter"><b><?php echo $f['descricao_evento']; ?></b><div><?php echo $f['followup_conteudo']; ?></div></td>
                                            <td class="clfs-fright"><?php echo $f['nome']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!-- End Striped Table -->

                </div>
            </div>

        </div>

    </div>
</div>
