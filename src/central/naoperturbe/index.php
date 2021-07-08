<?php

include '../../Conexao.php';

$conexao = new Conexao();
 
date_default_timezone_set('America/Sao_Paulo');
$ramal = filter_input(INPUT_GET, "ramal");
$naoperturbe = filter_input(INPUT_GET, "naoperturbe");
$dt = date('Y-m-d H:i:s');

if(!empty($ramal)) {
	$sql = "UPDATE ramal_status SET status = $naoperturbe WHERE ramal = $ramal";
    $stmt = $conexao->query($sql);
	$fp = fopen('data.txt', 'a+');
	fwrite($fp, "$dt - $ramal - $naoperturbe\n");
	fclose($fp);
} else {
	$fp = fopen('data.txt', 'a+');
	fwrite($fp, "Consulta sem parâmetros\n");
	fclose($fp);
	http_response_code(403);
}