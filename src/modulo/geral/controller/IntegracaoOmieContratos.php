<?php

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$erros = '';

try {
    $stmt = $conexao->query("DELETE FROM contrato");
} catch (PDOException $ex) {
    $erros .= $ex->getMessage() . '<br/>';
}

$retorno = retornaContratos(0);
$pg = 1;
while ($pg <= $retorno->total_de_paginas) {
    $retorno = retornaContratos($pg);
    foreach ($retorno->contratoCadastro as $contrato) {
        foreach ($contrato->itensContrato as $itens) {
            try {
                $stmt = $conexao->prepare("INSERT INTO contrato(contrato_cod_item,contrato_cod_cliente,contrato_desc,contrato_qtd) VALUES(?,?,?,?)");
                $stmt->bindValue(1, $itens->itemCabecalho->codItem, PDO::PARAM_INT);
                $stmt->bindValue(2, $contrato->cabecalho->nCodCli, PDO::PARAM_INT);
                $stmt->bindValue(3, $itens->itemDescrServ->descrCompleta, PDO::PARAM_STR);
                $stmt->bindValue(4, $itens->itemCabecalho->quant, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $ex) {
                $erros .= $ex->getMessage() . '<br/>';
            }
        }
    }
    $pg++;
}

if(empty($erros)) {
    echo "Sincronização realizada com sucesso!";
} else {
    echo "Erros gerados: <br />" . $erros;
}

function retornaContratos($pagina) {
	$json = '{"call":"ListarContratos","app_key":"38333295000","app_secret":"4cea520a0e2a2ecdc267b75d3424a0ed","param":[{"pagina":'.$pagina.',"registros_por_pagina":20,"apenas_importado_api":"N"}]}';
	$ch = curl_init('https://app.omie.com.br/api/v1/servicos/contrato/');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($json))
	);
	$jsonRet = json_decode(curl_exec($ch));
	return $jsonRet;
}
