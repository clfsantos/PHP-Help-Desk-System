<?php

include '../../../seguranca.php';

$conexao = new PDO("firebird:dbname=10.0.0.254:D:\JunsoftERP\Database\DB.FDB;charset=utf8", "SYSDBA", "masterkey");
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conexao2 = new Conexao();
$conexao2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $usuario = $_SESSION['usuarioID'];
    $stmt = $conexao2->prepare("INSERT INTO historicointegracao(usuario_id) VALUES(?)");
    $stmt->bindValue(1, $usuario, PDO::PARAM_INT);
    $stmt->execute();
} catch (Exception $ex) {
    $errosi .= "Não foi possível gravar histórico " . $ex->getMessage() . "<br />";
}

$stmt = $conexao->prepare("select PESSOA.NR_CNPJCPF, PESSOA.CD_PESSOA, PESSOA.NM_PESSOA, PESSOA.NM_FANTASIA, PESSOA.DS_EMAIL, MUNICIPIO.DS_MUNICIPIO, MUNICIPIO.SG_ESTADO, MUNICIPIO.CD_IBGE, enderecopessoa.DS_ENDERECO, enderecopessoa.NR_ENDERECO, enderecopessoa.DS_BAIRRO, enderecopessoa.DS_COMPLEMENTO, enderecopessoa.NR_CEP, enderecopessoa.NR_FONE, enderecopessoa.DS_CONTATO from pessoa inner join enderecopessoa on (enderecopessoa.cd_pessoa=pessoa.cd_pessoa) inner join MUNICIPIO on (MUNICIPIO.CD_MUNICIPIO=enderecopessoa.CD_MUNICIPIO)");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errose = '';
$errosi = '';
$cadastrados = '';
$atualizados = 1;

try {
    $stmt = $conexao->query("SELECT PERFIL.CD_PERFIL, DS_PERFIL FROM PERFIL");
    $perfis = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    $errosi .= $ex->getMessage() . "<br />";
}

foreach ($perfis as $perfil) {
    try {
        $stmt2 = $conexao2->query("SELECT perfil_id FROM perfil WHERE perfil_id = " . $perfil['CD_PERFIL']);
    } catch (PDOException $ex) {
        $errosi .= $ex->getMessage() . "<br />";
    }

    if ($stmt2->rowCount() < 1) {
        try {
            $stmt2 = $conexao2->prepare("INSERT INTO perfil(perfil_id, perfil_descricao) VALUES(?,?)");
            $stmt2->bindValue(1, $perfil['CD_PERFIL'], PDO::PARAM_STR);
            $stmt2->bindValue(2, $perfil['DS_PERFIL'], PDO::PARAM_STR);
            $stmt2->execute();
        } catch (PDOException $ex) {
            $errosi .= $ex->getMessage() . "<br />";
        }
    }
}

foreach ($rows as $row) {

    if (empty($row['NM_FANTASIA'])) {
        $fantasia = $row['NM_PESSOA'];
    } else {
        $fantasia = $row['NM_FANTASIA'];
    }

    $cnpj = trim($row['NR_CNPJCPF']);
    $cnpj = str_replace(".", "", $cnpj);
    $cnpj = str_replace("-", "", $cnpj);
    $cnpj = str_replace("/", "", $cnpj);

    $cep = trim($row['NR_CEP']);
    $cep = str_replace("-", "", $cep);

    $telefone = trim($row['NR_FONE']);
    $telefone = str_replace("(", "", $telefone);
    $telefone = str_replace(")", "", $telefone);
    $telefone = str_replace("-", "", $telefone);
    $telefone = str_replace(".", "", $telefone);
    $telefone = str_replace(" ", "", $telefone);
    if (strlen($telefone) === 8 || strlen($telefone) === 9) {
        $telefone = '45' . $telefone;
    }

    $ibge = substr(trim($row['CD_IBGE']), 0, -1);

    if (!filter_var($row['DS_EMAIL'], FILTER_VALIDATE_EMAIL)) {
        $email = null;
    } else {
        $email = trim($row['DS_EMAIL']);
    }

    try {
        $stmt2 = $conexao2->query("SELECT crcliente_cd_junsoft FROM crcliente WHERE crcliente_cd_junsoft = " . $row['CD_PESSOA']);
    } catch (PDOException $ex) {
        $errosi .= $ex->getMessage() . "<br />";
    }

    if ($stmt2->rowCount() < 1) {
        try {
            $stmt2 = $conexao2->prepare("INSERT INTO crcliente(crcliente_cnpj,crcliente_cd_junsoft,crcliente_razao,crcliente_fantasia,crcliente_email,crcliente_cidade_id,crcliente_end_rua,crcliente_end_num,crcliente_end_bairo,crcliente_end_complemento,crcliente_end_cep,crcliente_telefone,crcliente_contato) VALUES(?,?,?,?,?,get_cidade_id_ibge(?),?,?,?,?,?,?,?)");
            $stmt2->bindValue(1, $cnpj, PDO::PARAM_STR);
            $stmt2->bindValue(2, $row['CD_PESSOA'], PDO::PARAM_INT);
            $stmt2->bindValue(3, $row['NM_PESSOA'], PDO::PARAM_STR);
            $stmt2->bindValue(4, $fantasia, PDO::PARAM_STR);
            $stmt2->bindValue(5, $email, PDO::PARAM_STR);
            $stmt2->bindValue(6, $ibge, PDO::PARAM_INT);
            $stmt2->bindValue(7, $row['DS_ENDERECO'], PDO::PARAM_STR);
            $stmt2->bindValue(8, $row['NR_ENDERECO'], PDO::PARAM_INT);
            $stmt2->bindValue(9, $row['DS_BAIRRO'], PDO::PARAM_STR);
            $stmt2->bindValue(10, $row['DS_COMPLEMENTO'], PDO::PARAM_STR);
            $stmt2->bindValue(11, $cep, PDO::PARAM_STR);
            $stmt2->bindValue(12, $telefone, PDO::PARAM_STR);
            $stmt2->bindValue(13, $row['DS_CONTATO'], PDO::PARAM_STR);
            $stmt2->execute();
            $cadastrados .= '<tr>';
            $cadastrados .= '<td>' . $row['CD_PESSOA'] . "</td>";
            $cadastrados .= '<td>' . $fantasia . "</td>";
            $cadastrados .= '</tr>';
        } catch (PDOException $ex) {
            $errose .= $fantasia . " - " . $ex->getMessage() . "<br />";
        }
    } else {
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

    try {
        $stmt = $conexao->query("SELECT PESSOAPERFIL.CD_PERFIL FROM PESSOAPERFIL WHERE PESSOAPERFIL.CD_PESSOA = " . $row['CD_PESSOA']);
        $cdperfis = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        $errosi .= $fantasia . " - " . $ex->getMessage() . "<br />";
    }

    if ($stmt->rowCount() > 0) {
        try {
            $stmt2 = $conexao2->prepare("DELETE FROM crcliente_perfil WHERE crcliente_id = get_crcliente_id_junsoft(?)");
            $stmt2->bindValue(1, $row['CD_PESSOA'], PDO::PARAM_INT);
            $stmt2->execute();
        } catch (PDOException $ex) {
            $errosi .= $fantasia . " - " . $ex->getMessage() . "<br />";
        }

        foreach ($cdperfis as $cdperfil) {
            try {
                $stmt2 = $conexao2->prepare("INSERT INTO crcliente_perfil(perfil_id, crcliente_id) VALUES(?,get_crcliente_id_junsoft(?))");
                $stmt2->bindValue(1, $cdperfil['CD_PERFIL'], PDO::PARAM_STR);
                $stmt2->bindValue(2, $row['CD_PESSOA'], PDO::PARAM_STR);
                $stmt2->execute();
            } catch (PDOException $ex) {
                $errosi .= $fantasia . " - " . $ex->getMessage() . "<br />";
            }
        }
    }
}

echo '<br /><b>Log</b><br /><br />';
if (!empty($cadastrados)) {
    echo 'Clientes Cadastrados:';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo'<tr>';
    echo '<th>Código Junsoft</th>';
    echo '<th>Empresa</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo $cadastrados;
    echo '</tbody>';
    echo '</table>';
}

echo '<br /><b>Erros Esperados: (Pode ser a causa do CNPJ ou CPF duplicado, o sistema não aceita duplicação de CNPJ ou CPF)</b><br /><br />';
echo $errose;
echo '<br /><b>Erros Inesperados: (Alguns erros inesperados podem ser causados por causa dos erros esperados)</b><br /><br />';
echo $errosi;
echo '<br /><b>Os demais ' . $atualizados . ' clientes foram atualizados.</b><br /><br />';
