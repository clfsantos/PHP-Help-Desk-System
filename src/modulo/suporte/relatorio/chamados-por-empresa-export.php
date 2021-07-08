<?php

include '../../../seguranca.php';
include '../model/Data.Util.class.php';
require_once '../../../plugins/phpexcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

$conexao = new Conexao();
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dataUtil = new DataUtil();

$dtInicial = filter_input(INPUT_POST, "dtInicial");
$dtFinal = filter_input(INPUT_POST, "dtFinal");

if (!empty($dtInicial) && !empty($dtFinal)) {
    $dtI = $dataUtil->dtFormatoBanco($dtInicial);
    $dtF = date('Y-m-d', strtotime($dataUtil->dtFormatoBanco($dtFinal) . ' +1 day'));
} else {
    $dtI = date('Y-m-d');
    $dtF = date('Y-m-d', strtotime('+1 day'));
}

if (isset($_POST['spchamado_produto_id'])) {
    $produtos = implode(',', $_POST['spchamado_produto_id']);
} else {
    $produtos = '1,2';
}

if (isset($_POST['spchamado_class_id'])) {
    $class = implode(',', $_POST['spchamado_class_id']);
} else {
    $class = '1,2';
}

if (isset($_POST['spchamado_aberto'])) {
    $aberto = implode(',', $_POST['spchamado_aberto']);
} else {
    $aberto = 'true,false';
}

if(isset($_POST['crcliente_id'])) {
	if (!empty($_POST['crcliente_id'])) {
		$empresa = 'AND vw_spchamado.crcliente_id = ' . $_POST['crcliente_id'];
	} else {
		$empresa = '';
	}
} else {
    $empresa = '';
}

$where = "spchamado_produto_id IN ($produtos) AND spchamado_class_id IN ($class) AND spchamado_aberto IN ($aberto) $empresa and spchamado_dt_abertura between '$dtI' and '$dtF'";

$query = "select vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia, count(vw_spchamado.crcliente_id) as qtd from vw_spchamado where $where 
group by vw_spchamado.crcliente_id, crcliente_razao, crcliente_fantasia
order by qtd desc";
$stmt = $conexao->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$objPHPExcel->getProperties()->setCreator("Tecsmart Sistemas")
        ->setLastModifiedBy("Tecsmart Sistemas")
        ->setTitle("Relatório de Chamado por Empresas")
        ->setSubject("Relatório de Chamado por Empresas")
        ->setDescription("Relatório de Chamado por Empresas")
        ->setKeywords("tecsmart sistemas sgsti")
        ->setCategory("Relatórios");

$styleArray = array(
	'font' => array(
		'bold' => true,
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	),
	'borders' => array(
		'top' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
		'rotation' => 90,
		'startcolor' => array(
			'argb' => 'FFA0A0A0',
		),
		'endcolor' => array(
			'argb' => 'FFFFFFFF',
		),
	),
);

$row = 0;
foreach ($rows as $dataRow) {
    $row++;
    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':E' . $row);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'Empresa');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, 'Chamados');
    $row++;
    $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':E' . $row);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $dataRow['crcliente_razao'] . ' (' . $dataRow['crcliente_fantasia'] . ')');
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $dataRow['qtd']);
    $query = "select spchamado_id, spchamado_dt_abertura_nft, spchamado_ocorrencia, spchamado_resolver, spchamado_contato, spchamado_resp_atual_nome from vw_spchamado where $where AND vw_spchamado.crcliente_id = " . $dataRow['crcliente_id'];
    $stmt = $conexao->prepare($query);
    $stmt->execute();
    $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row++;
    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':F' . $row)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, 'ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, 'Data da Abertura');
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, 'Ocorrência');
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, 'Resolução');
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, 'Contato');
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $row, 'Responsável Atual');
    foreach ($chamados as $chamado) {
        $row++;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $chamado['spchamado_id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $chamado['spchamado_dt_abertura_nft']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $chamado['spchamado_ocorrencia']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $chamado['spchamado_resolver']);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $chamado['spchamado_contato']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $chamado['spchamado_resp_atual_nome']);
    }
}

$objPHPExcel->getActiveSheet()->setTitle('Simple');
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="chamados_por_empresa.xlsx"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
