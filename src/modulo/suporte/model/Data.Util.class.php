<?php

class DataUtil {

    function __construct() {
 
    }

     public function dtFormatoBanco($dtEntrada) {
        if (!$this->validarData($dtEntrada)) {
            throw new Exception('A data informada é inválida!', 105);
        } else {
            $dtEntrada = $this->formataData($dtEntrada);
            return $dtEntrada;
        }
    }

    private function formataData($data) {
        $data = trim($data);
        $data = str_replace("/", "-", $data);
        date_default_timezone_set('America/Sao_Paulo');
        $newDate = date("Y-m-d", strtotime($data));
        return $newDate;
    }

    private function validarData($data, $format = 'd/m/Y') {
        $dateTime = new DateTime();
        $d = $dateTime->createFromFormat($format, $data);
        if ($d && $d->format($format) == $data) {
            return true;
        } else {
            return false;
        }
    }

}
