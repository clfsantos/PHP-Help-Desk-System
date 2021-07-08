<?php

include '../../../seguranca.php';
$conexao = new Conexao();

$op = filter_input(INPUT_GET, "op") ? filter_input(INPUT_GET, "op") : '';
$usuario = $_SESSION['usuarioID'];

if ($op === 'fila') {
    try {
        $query = "SELECT count(spchamado_fila_id) AS fila FROM spchamado_fila WHERE spchamado_fila_atendido = false";
        $stmt = $conexao->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['fila'] > 4) {
            $badge = 'badge-danger';
        } elseif ($row['fila'] > 2) {
            $badge = 'badge-warning';
        } else {
            $badge = 'badge-success';
        }
        echo '<span class="pull-right badge ' . $badge . '">' . $row['fila'] . '</span>';
    } catch (Exception $ex) { }
} elseif ($op === 'ch') {
    try {
        $query = "SELECT qtd FROM db_chamados_aberto_por_tecnico WHERE spchamado_resp_atual_id = ?";
        $stmt = $conexao->prepare($query);
        $stmt->bindValue(1, $usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<span class="pull-right badge badge-primary">' . $row['qtd'] . '</span>';
    } catch (Exception $ex) { }
}
