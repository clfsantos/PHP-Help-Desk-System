<?php

//include '../AutoLoader.php';
//
//class AssistenciaAbertaTabela {
//
//    public function main() {
//
//        $paginaAtual = filter_input(INPUT_POST, "page") ? filter_input(INPUT_POST, "page") : 1;
//        $rows = filter_input(INPUT_POST, "rows") ? filter_input(INPUT_POST, "rows") : 10;
//        $busca = filter_input(INPUT_POST, "q") ? filter_input(INPUT_POST, "q") : '';
//        $sort = filter_input(INPUT_POST, "sort") ? filter_input(INPUT_POST, "sort") : 'dias_manutencao';
//        $order = filter_input(INPUT_POST, "order") ? filter_input(INPUT_POST, "order") : 'desc';
//
//        $offset = ($paginaAtual - 1) * $rows;
//
//        $assistenciaAbertaDAO = new AssistenciaAbertaDAO();
//        $stmt = $assistenciaAbertaDAO->listar($busca, $offset, $rows, $sort, $order);
//        
//        $result = array();
//        $result["total"] = $assistenciaAbertaDAO->contarBusca($busca);
//
//        $items = array();
//        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
//            array_push($items, $row);
//        }
//        $result["rows"] = $items;
//
//        return json_encode($result);
//        
//    }
//
//}
//
//$assistenciaAbertaTabela = new AssistenciaAbertaTabela();
//echo $assistenciaAbertaTabela->main();