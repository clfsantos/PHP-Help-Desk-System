<?php

include '../../../seguranca.php';
$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requestData = $_REQUEST;
$columns = array(
// datatable column index  => database column name
    0 => '',
    1 => 'crcliente_razao',
    2 => 'crcliente_fantasia',
    3 => 'qtd'
);

$sort = $columns[$requestData['order'][0]['column']];
$order = $requestData['order'][0]['dir'];
$offset = $requestData['start'];
$limit = $requestData['length'];

//$busca = $requestData['search']['value'];
$busca = $requestData['busca'];
$perfil_id = $requestData['perfil_id'];


$query = "select vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia, count(vw_spchamado.crcliente_id) as qtd "
        . "from crcliente_perfil "
        . "inner join vw_spchamado on (vw_spchamado.crcliente_id = crcliente_perfil.crcliente_id) "
        . "where perfil_id = :perfil and spchamado_produto_id = 1 "
        . "AND LOWER(crcliente_razao) LIKE LOWER(:busca) "
        . "group by vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia";
$stmt = $conexao->prepare($query);
$busca = "%" . $busca . "%";
$stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
$stmt->bindValue(':perfil', $perfil_id, PDO::PARAM_INT);
$stmt->execute();
$totalData = $stmt->rowCount();
$totalFiltered = $totalData;

$query = "select vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia, count(vw_spchamado.crcliente_id) as qtd "
        . "from crcliente_perfil "
        . "inner join vw_spchamado on (vw_spchamado.crcliente_id = crcliente_perfil.crcliente_id) "
        . "where perfil_id = :perfil and spchamado_produto_id = 1 "
        . "AND LOWER(crcliente_razao) LIKE LOWER(:busca) "
        . "group by vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia "
        . "ORDER BY $sort $order "
        . "LIMIT $limit OFFSET $offset";
$stmt = $conexao->prepare($query);
$busca = "%" . $busca . "%";
$stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
$stmt->bindValue(':perfil', $perfil_id, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);



$data = array();
foreach ($rows as $row) {  // preparing an array
    $nestedData = array();
    $nestedData['crcliente_razao'] = $row["crcliente_razao"];
    $nestedData['crcliente_fantasia'] = $row["crcliente_fantasia"];
    $nestedData['qtd'] = $row["qtd"];
    $nestedData['crcliente_id'] = $row["crcliente_id"];

    $data[] = $nestedData;
}
$json_data = array(
    "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal" => intval($totalData), // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $data   // total data array
);
echo json_encode($json_data);  // send data as json format
