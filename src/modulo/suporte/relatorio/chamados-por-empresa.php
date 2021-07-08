<?php 

include '../../../seguranca.php';
include '../model/Data.Util.class.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dataUtil = new DataUtil();

$dtInicial = filter_input(INPUT_POST, "dtInicial");
$dtFinal = filter_input(INPUT_POST, "dtFinal");

if (!empty($dtInicial) && !empty($dtFinal)) {
    $dtI = $dataUtil->dtFormatoBanco($dtInicial);
    $dtF = date('Y-m-d', strtotime($dataUtil->dtFormatoBanco($dtFinal) . ' +1 day'));
} else {
    $dtI = date('Y-m-d');
    $dtF = date('Y-m-d', strtotime('+1 day'));
}

if(isset($_POST['spchamado_produto_id'])) {
    $produtos = implode(',', $_POST['spchamado_produto_id']);
} else {
    $produtos = '1,2';
}

if(isset($_POST['spchamado_class_id'])) {
    $class = implode(',', $_POST['spchamado_class_id']);
} else {
    $class = '1,2';
}

if(isset($_POST['spchamado_aberto'])) {
    $aberto = implode(',', $_POST['spchamado_aberto']);
} else {
    $aberto = 'true,false';
}

if(isset($_POST['crcliente_id'])) {
	if (!empty($_POST['crcliente_id'])) {
		$empresa = 'AND vw_spchamado.crcliente_id = ' . $_POST['crcliente_id'];
	} else {
		$empresa = '';
	}
} else {
    $empresa = '';
}

$where = "spchamado_produto_id IN ($produtos) AND spchamado_class_id IN ($class) AND spchamado_aberto IN ($aberto) $empresa AND spchamado_dt_abertura between '$dtI' and '$dtF'";

$query = "select vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia, count(vw_spchamado.crcliente_id) as qtd from vw_spchamado where $where 
group by vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia
order by qtd desc";
$stmt = $conexao->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="5" style="width:90%;"><?php echo $row['crcliente_razao'] . ' (' . $row['crcliente_fantasia'] . ')'; ?></th>
                <th style="width:10%;"><?php echo $row['qtd'], $row['qtd'] > 1 ? ' Chamados' : ' Chamado'; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "select spchamado_id, spchamado_dt_abertura_nft, spchamado_ocorrencia, spchamado_resolver, spchamado_contato, spchamado_resp_atual_nome from vw_spchamado where $where AND vw_spchamado.crcliente_id = " . $row['crcliente_id'];
            $stmt = $conexao->prepare($query);
            $stmt->execute();
            $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($chamados as $chamado) {
                ?>
                <tr>
                    <td style="width:10%;"><?php echo $chamado['spchamado_id']; ?></td>
                    <td style="width:10%;"><?php echo $chamado['spchamado_dt_abertura_nft']; ?></td>
                    <td style="width:30%;"><?php echo $chamado['spchamado_ocorrencia']; ?></td>
                    <td style="width:40%;"><?php echo $chamado['spchamado_resolver']; ?></td>
					<td style="width:40%;"><?php echo $chamado['spchamado_contato']; ?></td>
                    <td style="width:10%;"><?php echo $chamado['spchamado_resp_atual_nome']; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>