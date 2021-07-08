<?php

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$retorno = retornaClientes(0);
$pg = 1;
while ($pg <= $retorno->total_de_paginas) {
    $retorno = retornaClientes($pg);
    foreach ($retorno->clientes_cadastro as $cliente) {
    
        if (empty($cliente->nome_fantasia)) {
            $fantasia = $cliente->razao_social;
        } else {
            $fantasia = $cliente->nome_fantasia;
        }
    
        $cnpj = trim($cliente->cnpj_cpf);
        $cnpj = str_replace(".", "", $cnpj);
        $cnpj = str_replace("-", "", $cnpj);
        $cnpj = str_replace("/", "", $cnpj);
    
        $cep = trim($cliente->cep);
        $cep = str_replace("-", "", $cep);
    
        if (isset($cliente->telefone1_numero)) {
			if(isset($cliente->telefone1_ddd)) {
				$telefone = $cliente->telefone1_ddd . $cliente->telefone1_numero;
			} else {
				$telefone = $cliente->telefone1_numero;
			}
            $telefone = trim($telefone);
            $telefone = str_replace("(", "", $telefone);
            $telefone = str_replace(")", "", $telefone);
            $telefone = str_replace("-", "", $telefone);
            $telefone = str_replace(".", "", $telefone);
            $telefone = str_replace(" ", "", $telefone);
            if (strlen($telefone) === 8 || strlen($telefone) === 9) {
                $telefone = '45' . $telefone;
            }
        } else {
            $telefone = null;
        }
    
        $ibge = substr(trim($cliente->cidade_ibge), 0, -1);
    
        if (isset($cliente->email)) {
            if (!filter_var($cliente->email, FILTER_VALIDATE_EMAIL)) {
                $email = null;
            } else {
                $email = trim($cliente->email);
            }
        } else {
            $email = null;
        }
    
        if (isset($cliente->contato)) {
            $contato = $cliente->contato;
        } else {
            $contato = null;
        }
    
        if (is_int($cliente->endereco_numero)) {
            $endereco_numero = $cliente->endereco_numero;
        } else {
            $endereco_numero = 0;
        }
    
        try {
            $stmt = $conexao->query("SELECT crcliente_id FROM crcliente WHERE crcliente_cnpj = '".$cnpj."'");
			$row = $stmt->fetch(PDO::FETCH_NUM);
			$clienteID = $row[0];
        } catch (PDOException $ex) {
            $ex->getMessage();
        }
    
        if ($stmt->rowCount() > 0) {
            try {
                $conexao->beginTransaction();
                $stmt = $conexao->prepare("UPDATE crcliente SET crcliente_razao=?,crcliente_fantasia=?,crcliente_email=?,crcliente_cidade_id=get_cidade_id_ibge(?),crcliente_end_rua=?,crcliente_end_num=?,crcliente_end_bairo=?,crcliente_end_complemento=?,crcliente_end_cep=?,crcliente_telefone=?,crcliente_contato=? WHERE crcliente_cnpj=?");
                $stmt->bindValue(1, $cliente->razao_social, PDO::PARAM_STR);
                $stmt->bindValue(2, $fantasia, PDO::PARAM_STR);
                $stmt->bindValue(3, $email, PDO::PARAM_STR);
                $stmt->bindValue(4, $ibge, PDO::PARAM_INT);
                $stmt->bindValue(5, $cliente->endereco, PDO::PARAM_STR);
                $stmt->bindValue(6, $endereco_numero, PDO::PARAM_INT);
                $stmt->bindValue(7, $cliente->bairro, PDO::PARAM_STR);
                $stmt->bindValue(8, $cliente->complemento, PDO::PARAM_STR);
                $stmt->bindValue(9, $cep, PDO::PARAM_STR);
                $stmt->bindValue(10, $telefone, PDO::PARAM_STR);
                $stmt->bindValue(11, $contato, PDO::PARAM_STR);
                $stmt->bindValue(12, $cnpj, PDO::PARAM_STR);
                $stmt->execute();
                $conexao->commit();
            } catch (PDOException $ex) {
                $conexao->rollBack();
                echo $ex->getMessage() . '<br /><br />';
            }
			
			try {
				$stmt = $conexao->prepare("DELETE FROM crcliente_tag WHERE crcliente_id = ?");
				$stmt->bindValue(1, $clienteID, PDO::PARAM_INT);
				$stmt->execute();
            } catch (PDOException $ex) {
                $ex->getMessage();
            }
    
            $tgs = cadastraTagsCliente($cliente->tags, $conexao);
    
            foreach ($tgs as $tg) {
                try {
                    $stmt = $conexao->prepare("INSERT INTO crcliente_tag(tag_id, crcliente_id) VALUES(?,?)");
                    $stmt->bindValue(1, $tg, PDO::PARAM_INT);
                    $stmt->bindValue(2, $clienteID, PDO::PARAM_INT);
                    $stmt->execute();
                } catch (PDOException $ex) {
                    $ex->getMessage();
                }
            }
        }
    
    }
    $pg++;
}


function retornaClientes($pagina) {
	$json = '{"call":"ListarClientes","app_key":"38333295000","app_secret":"4cea520a0e2a2ecdc267b75d3424a0ed","param":[{"pagina":'.$pagina.',"registros_por_pagina":50,"apenas_importado_api":"N"}]}';
	$ch = curl_init('https://app.omie.com.br/api/v1/geral/clientes/');
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

function cadastraTagsCliente($tags,$conexao) {
    $tgs = array();
	foreach ($tags as $tg) {
        try {
            $stmt = $conexao->prepare("SELECT tag_id FROM tag WHERE tag_descricao = ? LIMIT 1");
            $stmt->bindValue(1, trim($tg->tag), PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $ex) {
            $ex->getMessage();
        }
        if ($stmt->rowCount() < 1) {
            try {
                $conexao->beginTransaction();
                $stmt2 = $conexao->prepare("INSERT INTO tag(tag_descricao) VALUES(?)");
                $stmt2->bindValue(1, trim($tg->tag), PDO::PARAM_STR);
                $stmt2->execute();
                $tgs[] = $conexao->lastInsertId('tag_tag_id_seq');
                $conexao->commit();
            } catch (PDOException $ex) {
                $conexao->rollBack();
                $ex->getMessage();
            }
        } else {
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $tgs[] = $row[0];
        }
    }
    return $tgs;
}