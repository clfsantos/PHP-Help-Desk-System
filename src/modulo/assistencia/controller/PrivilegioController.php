<?php 

//include '../seguranca.php';
//include '../AutoLoader.php';
//
//class PrivilegioController {
//
//    public function main() {
//
//        $usuario = $_SESSION['usuarioID'];
//        $tela = filter_input(INPUT_GET, "tela");
//        $operacao = filter_input(INPUT_GET, "op");
//        
//        $privilegioDAO = new PrivilegioDAO();
//        $permissao = $privilegioDAO->VerificaPrivilegio($operacao, $tela, $usuario);
//        
//        $resultado = false;
//        if ($permissao === true) {
//            $resultado = true;
//        } else {
//           $resultado = false; 
//        }
//        
//        return json_encode(array('permissao' => $resultado));
//    }
//
//}
//
//$privilegioController = new PrivilegioController();
//echo $privilegioController->main();
