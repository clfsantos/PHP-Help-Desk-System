<?php 

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if(isset($_POST['spchamado_produto_id'])) {
    $produto = $_POST['spchamado_produto_id'];
} else {
    $produto = 2;
}

if(isset($_POST['spchamado_release_id'])) {
    $release = implode(',', $_POST['spchamado_release_id']);
} else {
    $release = 0;
}

if(!empty($release)) {
	$complemento = "AND vw_spchamado_release.spchamado_release_id IN ($release)";
} else {
	$complemento = '';
}

$where = "vw_spchamado_release.spchamado_produto_id = $produto";

$query = "SELECT * FROM vw_spchamado_release WHERE $where $complemento ORDER BY vw_spchamado_release.spchamado_release_id DESC";
$stmt = $conexao->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th colspan="1" style="width:10%;"><?php echo $row['spchamado_release_num']; ?></th>
				<th colspan="6" style="width:90%;"><?php echo $row['spchamado_release_desc']; ?></th>
            </tr>
			<tr>
                <th>Chamado</th>
				<th>Data</th>
				<th>Empresa</th>
				<th>Ocorrência</th>
				<th>Resolução</th>
				<th>Técnico</th>
				<th>Classificação</th>
            </tr>
        </thead>
        <tbody>
            <?php			
            $query = "SELECT * FROM vw_spchamado INNER JOIN vw_spchamado_release ON (vw_spchamado_release.spchamado_release_id=vw_spchamado.spchamado_release_id) WHERE $where AND vw_spchamado_release.spchamado_release_id = " . $row['spchamado_release_id'];
			$stmt = $conexao->prepare($query);
            $stmt->execute();
            $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
			foreach ($chamados as $chamado) {
                ?>
                <tr>
                    <td style="width:10%;"><a href="javascript:void(0);" class="btn-link" onclick="editarChamadoExterno(<?php echo $chamado['spchamado_id']; ?>);"><?php echo $chamado['spchamado_id']; ?></a></td>
                    <td style="width:10%;"><?php echo $chamado['spchamado_dt_abertura_nft']; ?></td>
                    <td style="width:20%;"><?php echo $chamado['crcliente_fantasia']; ?></td>
					<td style="width:20%;"><?php echo $chamado['spchamado_ocorrencia']; ?></td>
                    <td style="width:20%;"><?php echo $chamado['spchamado_resolver']; ?></td>
                    <td style="width:10%;"><?php echo $chamado['spchamado_responsavel_nome']; ?></td>
					<td style="width:10%;"><?php echo $chamado['spchamado_class_desc']; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}

?>