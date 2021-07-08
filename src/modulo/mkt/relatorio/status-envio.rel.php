<?php

include '../../../seguranca.php';

$envio = filter_input(INPUT_POST, "envio");

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conexao->prepare("select count(contato_id) as qtd from envio_mala where envio_id = ?");
$stmt->bindValue(1, $envio, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$enviadas = $row['qtd'];

$stmt = $conexao->prepare("select count(contato_id) as qtd from envio_leitura "
        . "inner join contato on (contato.id = envio_leitura.contato_id) "
        . "where envio_id = ? group by contato_id");
$stmt->bindValue(1, $envio, PDO::PARAM_INT);
$stmt->execute();
$lidas = $stmt->rowCount();

$stmt = $conexao->prepare("select count(contato_id) as qtd from envio_baixa where envio_id = ?");
$stmt->bindValue(1, $envio, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$baixas = $row['qtd'];

$stmt = $conexao->prepare("select retornado from envio where id = ?");
$stmt->bindValue(1, $envio, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$retornados = $row['retornado'];

$stmt = $conexao->prepare("select porcentagemlidos(?,?) as percent_lidas");
$stmt->bindValue(1, $retornados, PDO::PARAM_INT);
$stmt->bindValue(2, $envio, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$percent_lidas = $row['percent_lidas'];

echo '[{
        "label": "Enviadas",
        "value": ' . $enviadas . '
    }, {
        "label": "Leituras",
        "value": ' . $lidas . '
    }, {
        "label": "Baixas",
        "value": ' . $baixas . '
    }, {
        "label": "Retornadas",
        "value": ' . $retornados . '
    }, {
        "label": "% Lidas",
        "value": ' . $percent_lidas . '
    }]';
