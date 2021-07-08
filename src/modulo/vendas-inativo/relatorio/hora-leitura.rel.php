<?php

include '../../seguranca.php';

$envio = filter_input(INPUT_POST, "envio");

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conexao->prepare("select extract(hour from dt_leitura) as hora, count(dt_leitura) as value "
        . "from envio_leitura "
        . "where envio_id = ? "
        . "group by hora "
        . "order by hora");
$stmt->bindValue(1, $envio, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$obj = array();
$items = array();

foreach ($rows as $row) {
    switch ($row['hora']) {
        case '0':
            $hora = '00:00';
            break;
        case '1':
            $hora = '01:00';
            break;
        case '2':
            $hora = '02:00';
            break;
        case '3':
            $hora = '03:00';
            break;
        case '4':
            $hora = '04:00';
            break;
        case '5':
            $hora = '05:00';
            break;
        case '6':
            $hora = '06:00';
            break;
        case '7':
            $hora = '07:00';
            break;
        case '8':
            $hora = '08:00';
            break;
        case '9':
            $hora = '09:00';
            break;
        case '10':
            $hora = '10:00';
            break;
        case '11':
            $hora = '11:00';
            break;
        case '12':
            $hora = '12:00';
            break;
        case '13':
            $hora = '13:00';
            break;
        case '14':
            $hora = '14:00';
            break;
        case '15':
            $hora = '15:00';
            break;
        case '16':
            $hora = '16:00';
            break;
        case '17':
            $hora = '17:00';
            break;
        case '18':
            $hora = '18:00';
            break;
        case '19':
            $hora = '19:00';
            break;
        case '20':
            $hora = '20:00';
            break;
        case '21':
            $hora = '21:00';
            break;
        case '22':
            $hora = '22:00';
            break;
        case '23':
            $hora = '23:00';
            break;
    }
    $obj = array("hora" => $hora, "value" => (int)$row['value']);
    array_push($items, $obj);
}

echo json_encode($items);
