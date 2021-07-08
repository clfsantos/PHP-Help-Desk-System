<?php

/**
 * Description of Manutencao
 *
 * @author cesantos
 */
class Manutencao {

    private $idManutencao;
    private $codigoEquipamento;
    private $idProblema;
    private $problemaInicial;
    private $dataEntrada;
    private $dataSaida;
    private $laudoTecnico;
    private $manutencaoAtiva;
    private $notaFiscal;

    public function __construct() {
        $this->idManutencao = null;
        $this->codigoEquipamento = null;
        $this->idProblema = null;
        $this->problemaInicial = null;
        $this->dataEntrada = null;
        $this->dataSaida = null;
        $this->laudoTecnico = null;
        $this->manutencaoAtiva = null;
        $this->notaFiscal = null;
    }

    public function getIdManutencao() {
        return $this->idManutencao;
    }

    public function getCodigoEquipamento() {
        return $this->codigoEquipamento;
    }

    public function getIdProblema() {
        return $this->idProblema;
    }

    public function getProblemaInicial() {
        return $this->problemaInicial;
    }

    public function getDataEntrada() {
        return $this->dataEntrada;
    }

    public function getDataSaida() {
        return $this->dataSaida;
    }

    public function getLaudoTecnico() {
        return $this->laudoTecnico;
    }

    public function getManutencaoAtiva() {
        return $this->manutencaoAtiva;
    }

    public function getNotaFiscal() {
        return $this->notaFiscal;
    }

    public function setIdManutencao($idManutencao) {
        $this->idManutencao = $idManutencao;
    }

    public function setCodigoEquipamento($codigoEquipamento) {
        if (!preg_match("/^\d+$/", $codigoEquipamento)) {
            throw new Exception('ID do equipamento inválido!', 101);
        }
        $this->codigoEquipamento = $codigoEquipamento;
    }

    public function setIdProblema($idProblema) {
        if (!preg_match("/^\d+$/", $idProblema)) {
            throw new Exception('ID do problema inválido!', 102);
        }
        $this->idProblema = $idProblema;
    }

    public function setProblemaInicial($problemaInicial) {
        $problemaInicial = trim($problemaInicial);
        if (strlen($problemaInicial) < 2) {
            throw new Exception('A descrição do modelo deve haver ao menos 2 caracteres!', 103);
        } elseif (strlen($problemaInicial) > 255) {
            throw new Exception('A descrição do modelo deve haver menos de 255 caracteres!', 104);
        }
        $this->problemaInicial = $problemaInicial;
    }

    public function setDataEntrada($dataEntrada) {
        if (!$this->validarData($dataEntrada)) {
            throw new Exception('A data informada é inválida!', 105);
        } else {
            $this->dataEntrada = $this->formataData($dataEntrada);
        }
    }

    public function setDataSaida($dataSaida) {
        $dataSaida = trim($dataSaida);
        $dataSaida = str_replace("_", "", $dataSaida);
        $dataSaida = str_replace("/", "", $dataSaida);
        if (!empty($dataSaida)) {
            $dia = substr($dataSaida, 0, 2);
            $mes = substr($dataSaida, 2, 2);
            $ano = substr($dataSaida, 4, 4);
            $dataSaida = $dia . "/" . $mes . "/" . $ano;
            if (!$this->validarData($dataSaida)) {
                throw new Exception('A data informada é inválida!', 106);
            }
            if (strtotime($this->formataData($dataSaida)) < strtotime($this->dataEntrada)) {
                throw new Exception('A data de saída não pode ser menor que a data de entrada!', 106);
            }
            $this->dataSaida = $this->formataData($dataSaida);
        } else {
            $this->dataSaida = null;
        }
    }

    public function setLaudoTecnico($laudoTecnico) {
        $laudoTecnico = trim($laudoTecnico);
        if ($laudoTecnico !== "") {
            $this->laudoTecnico = $laudoTecnico;
        } else {
            $this->laudoTecnico = null;
        }
    }

    public function setManutencaoAtiva($manutencaoAtiva) {
        if ($manutencaoAtiva === 0 && $this->dataSaida === null) {
            throw new Exception('Quando a manutenção for finalizada a data de devolução precisa ser preenchida!', 107);
        }
        $this->manutencaoAtiva = $manutencaoAtiva;
    }

    public function setNotaFiscal($notaFiscal) {
        if ($notaFiscal !== "") {
            if (!preg_match("/^\d+$/", $notaFiscal)) {
                throw new Exception('Nota fiscal inválida!', 108);
            }
            $this->notaFiscal = $notaFiscal;
        } else {
            $this->notaFiscal = null;
        }
    }

    private function formataData($data) {
        $data = trim($data);
        $data = str_replace("/", "-", $data);
        date_default_timezone_set('America/Sao_Paulo');
        $newDate = date("Y-m-d", strtotime($data));
        return $newDate;
    }

    function validarData($data, $format = 'd/m/Y') {
        $dateTime = new DateTime();
        $d = $dateTime->createFromFormat($format, $data);
        if ($d && $d->format($format) == $data) {
            return true;
        } else {
            return false;
        }
    }

}
