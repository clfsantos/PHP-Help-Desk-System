<?php
include '../../../seguranca.php';
include '../dao/ImplantacaoChamadoDAO.php';

$chamadoID = filter_input(INPUT_GET, "cid") ? filter_input(INPUT_GET, "cid") : 0;

$implantacaoChamadoDAO = new ImplantacaoChamadoDAO();
$row = $implantacaoChamadoDAO->etapaAtualInfo($chamadoID);
if (empty($row)) {
    echo '<p><b>Etapa Atual:</b></p>';
    echo '<p><b>Implantação concluída ou pendente de aprovação</b></p>';
} else {
    ?>

    <p><b>Etapa Atual:</b></p>
    <p><?php echo '<b>#' . $row['etapa_seq'] . '</b> ' . $row['etapa_desc']; ?></p>
    <p><?php echo '<b>Iniciada em: </b> ' . $row['etapa_dt_ft']; ?></p>
    <p><?php echo '<b>Status: </b> ' . $row['etapa_status_desc']; ?></p>
    <p><?php echo '<b>Responsável: </b> ' . $row['etapa_resp_nome']; ?></p>

<?php } ?>