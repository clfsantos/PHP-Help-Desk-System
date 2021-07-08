<?php

include '../../../seguranca.php';
$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$crcliente_id = filter_input(INPUT_POST, "crcliente_id");

$query = "select spchamado_dt_abertura_nft, spchamado_ocorrencia, spchamado_resp_atual_nome "
        . "from vw_spchamado "
        . "where spchamado_produto_id = 1 and crcliente_id = ? "
        . "order by spchamado_dt_abertura desc";
$stmt = $conexao->prepare($query);
$stmt->bindValue(1, $crcliente_id, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data Abertura</th>
                <th>Ocorrência</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td><?php echo $row['spchamado_dt_abertura_nft']; ?></td>
                    <td><?php echo $row['spchamado_ocorrencia']; ?></td>
                    <td><?php echo $row['spchamado_resp_atual_nome']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
