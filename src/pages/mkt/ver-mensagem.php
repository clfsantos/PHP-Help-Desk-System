<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="extractor">
    <div id="content-container">

        <?php
        $conexao = new Conexao();
        $url[2] = (empty($url[2]) ? null : $url[2]);

        $stmt = $conexao->prepare("SELECT encode(mensagem, 'base64') as mensagem FROM envio WHERE id = ?");
        $stmt->bindValue(1, $url[2], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo base64_decode(base64_decode($row['mensagem']));
        ?>

    </div>
</div><!--extractor-->
