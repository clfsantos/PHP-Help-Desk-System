<?php

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* grava histórico
try {
    $usuario = $_SESSION['usuarioID'];
    $stmt = $conexao->prepare("INSERT INTO historicointegracao(usuario_id) VALUES(?)");
    $stmt->bindValue(1, $usuario, PDO::PARAM_INT);
    $stmt->execute();
} catch (Exception $ex) {
    $errosi .= "Não foi possível gravar histórico " . $ex->getMessage() . "<br />";
} 
*/

$errose = '';
$errosi = '';
$cadastrados = '';
$atualizados = 1;

$retorno = retornaClientes(0);
$ultimaPg = $retorno->total_de_paginas;
$retorno = retornaClientes($ultimaPg);

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
        $telefone = trim($cliente->telefone1_numero);
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
    } catch (PDOException $ex) {
        $ex->getMessage();
    }

    if ($stmt->rowCount() < 1) {
        //echo $cod_cliente . ' - ' . $cnpj . ' - '. $fantasia . '<br>';
        try {
            $conexao->beginTransaction();
            $stmt = $conexao->prepare("INSERT INTO crcliente(crcliente_cnpj,crcliente_nerp,crcliente_razao,crcliente_fantasia,crcliente_email,crcliente_cidade_id,crcliente_end_rua,crcliente_end_num,crcliente_end_bairo,crcliente_end_complemento,crcliente_end_cep,crcliente_telefone,crcliente_contato) VALUES(?,?,?,?,?,get_cidade_id_ibge(?),?,?,?,?,?,?,?)");
            $stmt->bindValue(1, $cnpj, PDO::PARAM_STR);
            $stmt->bindValue(2, $cliente->codigo_cliente_omie, PDO::PARAM_INT);
            $stmt->bindValue(3, $cliente->razao_social, PDO::PARAM_STR);
            $stmt->bindValue(4, $fantasia, PDO::PARAM_STR);
            $stmt->bindValue(5, $email, PDO::PARAM_STR);
            $stmt->bindValue(6, $ibge, PDO::PARAM_INT);
            $stmt->bindValue(7, $cliente->endereco, PDO::PARAM_STR);
            $stmt->bindValue(8, $endereco_numero, PDO::PARAM_INT);
            $stmt->bindValue(9, $cliente->bairro, PDO::PARAM_STR);
            $stmt->bindValue(10, $cliente->complemento, PDO::PARAM_STR);
            $stmt->bindValue(11, $cep, PDO::PARAM_STR);
            $stmt->bindValue(12, $telefone, PDO::PARAM_STR);
            $stmt->bindValue(13, $contato, PDO::PARAM_STR);
            $stmt->execute();
            $novo_cliente_id = $conexao->lastInsertId('crcliente_crcliente_id_seq');
            $conexao->commit();
            $cadastrados .= '<tr>';
            $cadastrados .= '<td>' . $cliente->codigo_cliente_omie . "</td>";
            $cadastrados .= '<td>' . $fantasia . "</td>";
            $cadastrados .= '</tr>';
        } catch (PDOException $ex) {
            $conexao->rollBack();
            echo $ex->getMessage();
        }

        $tgs = cadastraTagsCliente($cliente->tags, $conexao);

        foreach ($tgs as $tg) {
            echo $tg;
            try {
                $stmt = $conexao->prepare("INSERT INTO crcliente_tag(tag_id, crcliente_id) VALUES(?,?)");
                $stmt->bindValue(1, $tg, PDO::PARAM_INT);
                $stmt->bindValue(2, $novo_cliente_id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $ex) {
                $ex->getMessage();
            }
        }
    }

}

echo '<br /><b>Log</b><br /><br />';
if (!empty($cadastrados)) {
    echo 'Clientes Cadastrados:';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Código</th>';
    echo '<th>Empresa</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo $cadastrados;
    echo '</tbody>';
    echo '</table>';
}






/*

foreach ($rows as $row) {

    

    

    

    

    

    

    

     else {
        try {
            $stmt2 = $conexao2->prepare("UPDATE crcliente SET crcliente_cnpj=?,crcliente_razao=?,crcliente_fantasia=?,crcliente_email=?,crcliente_cidade_id=get_cidade_id_ibge(?),crcliente_end_rua=?,crcliente_end_num=?,crcliente_end_bairo=?,crcliente_end_complemento=?,crcliente_end_cep=?,crcliente_telefone=?,crcliente_contato=? WHERE crcliente_cd_junsoft=?");
            $stmt2->bindValue(1, $cnpj, PDO::PARAM_STR);
            $stmt2->bindValue(2, $row['NM_PESSOA'], PDO::PARAM_STR);
            $stmt2->bindValue(3, $fantasia, PDO::PARAM_STR);
            $stmt2->bindValue(4, $email, PDO::PARAM_STR);
            $stmt2->bindValue(5, $ibge, PDO::PARAM_INT);
            $stmt2->bindValue(6, $row['DS_ENDERECO'], PDO::PARAM_STR);
            $stmt2->bindValue(7, $row['NR_ENDERECO'], PDO::PARAM_INT);
            $stmt2->bindValue(8, $row['DS_BAIRRO'], PDO::PARAM_STR);
            $stmt2->bindValue(9, $row['DS_COMPLEMENTO'], PDO::PARAM_STR);
            $stmt2->bindValue(10, $cep, PDO::PARAM_STR);
            $stmt2->bindValue(11, $telefone, PDO::PARAM_STR);
            $stmt2->bindValue(12, $row['DS_CONTATO'], PDO::PARAM_STR);
            $stmt2->bindValue(13, $row['CD_PESSOA'], PDO::PARAM_INT);
            $stmt2->execute();
            $atualizados++;
        } catch (PDOException $ex) {
            $errosi .= $fantasia . " - " . $ex->getMessage() . "<br />";
        }
    }

   
}



echo '<br /><b>Erros Esperados: (Pode ser a causa do CNPJ ou CPF duplicado, o sistema não aceita duplicação de CNPJ ou CPF)</b><br /><br />';
echo $errose;
echo '<br /><b>Erros Inesperados: (Alguns erros inesperados podem ser causados por causa dos erros esperados)</b><br /><br />';
echo $errosi;
echo '<br /><b>Os demais ' . $atualizados . ' clientes foram atualizados.</b><br /><br />';

*/

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