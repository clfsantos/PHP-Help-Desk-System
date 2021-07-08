<?php

include '../../../seguranca.php';

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$erros = '';

function retornaClientes($pagina)
{
    $json = '{"call":"ListarClientes","app_key":"38333295000","app_secret":"4cea520a0e2a2ecdc267b75d3424a0ed","param":[{"pagina":' . $pagina . ',"registros_por_pagina":50,"apenas_importado_api":"N"}]}';
    $ch = curl_init('https://app.omie.com.br/api/v1/geral/clientes/');

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(

            'Content-Type: application/json',

            'Content-Length: ' . strlen($json)
        )

    );

    $jsonRet = json_decode(curl_exec($ch));

    return $jsonRet;
}

$retorno = retornaClientes(0);
$pg = 1;
while ($pg <= $retorno->total_de_paginas) {
    $retorno = retornaClientes($pg);
    foreach ($retorno->clientes_cadastro as $cliente) {
        try {
            $stmt = $conexao->query("UPDATE crcliente SET crcliente_nerp = ".$cliente->codigo_cliente_omie." WHERE crcliente_cnpj = '".formataCNPJ($cliente->cnpj_cpf)."'");
        } catch (PDOException $ex) {
            $erros .= $ex->getMessage() . '<br />';
        }
    }
    $pg++;
}

function formataCNPJ($cnpj) {
    $cnpj = trim($cnpj);
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);
    return $cnpj;
}

echo 'Erros: <br />' . $erros;