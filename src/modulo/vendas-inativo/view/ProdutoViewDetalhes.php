<?php
include '../../seguranca.php';
include '../dao/ProdutoDAO.php';
$id = filter_input(INPUT_GET, "id");
$conexao = new Conexao();
$produtoDAO = new ProdutoDAO();
$stmt = $produtoDAO->listarProduto($id);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);
$statributos = $produtoDAO->listarAtributos($id);
$atributos = $statributos->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-hover table-vcenter">
    <thead>
        <tr>
            <th class="min-width">Foto</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"><img src="<?php echo HOME_URI . '/vendas/images/produtos/' . $produto['vdproduto_foto']; ?>" width="100" alt="" /></td>
            <td>
                <span class="text-semibold"><?php echo $produto['vdproduto_desc']; ?></span>
                <br />
                <small class="text-muted"><b>OBSERVAÇÃO: </b><?php echo $produto['vdproduto_obs']; ?></small>
                <br />
                <small class="text-muted"><b>ÚLTIMA ATUALIZAÇÃO: </b><?php echo $produto['vdproduto_dt_atu']; ?><b> POR: </b><?php echo $produto['vdproduto_usuario_atu_nome']; ?></small>
                <br />
                <small class="text-muted"><b>ETIQUETAS: </b><?php echo $produto['vdproduto_cats']; ?></small>
            </td>
        </tr>
    </tbody>
</table>


<table class="table table-hover table-striped">
    <tbody>
        <?php foreach ($atributos as $atributo) { ?>
        <tr>
            <td><?php echo $atributo['vdatributo_desc']; ?></td>
            <td><?php echo $atributo['resposta']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>