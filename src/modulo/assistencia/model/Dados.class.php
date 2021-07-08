<?php
class Dados {
    
    private $idManutencao;
    private $nrIP;
    private $mascara;
    private $gateway;
    private $bateria;
    private $chave;
    private $bobina;
    private $outros;
    private $lacreAntigo;
    private $lacreNovo;
    private $novoNSR;
    
    public function __construct() {
        
    }
    
    public function getIdManutencao() {
        return $this->idManutencao;
    }
    
    public function getNrIP() {
        return $this->nrIP;
    }

    public function getMascara() {
        return $this->mascara;
    }

    public function getGateway() {
        return $this->gateway;
    }

    public function getBateria() {
        return $this->bateria;
    }

    public function getChave() {
        return $this->chave;
    }

    public function getBobina() {
        return $this->bobina;
    }

    public function getOutros() {
        return $this->outros;
    }
    
    function getLacreAntigo() {
        return $this->lacreAntigo;
    }

    function getLacreNovo() {
        return $this->lacreNovo;
    }

    function getNovoNSR() {
        return $this->novoNSR;
    }
    
    public function setIdManutencao($idManutencao) {
        $this->idManutencao = $idManutencao;
    }

    public function setNrIP($nrIP) {
        $this->nrIP = $this->formatarIP($nrIP);
    }

    public function setMascara($mascara) {
        $this->mascara = $this->formatarIP($mascara);
    }

    public function setGateway($gateway) {
        $this->gateway = $this->formatarIP($gateway);
    }

    public function setBateria($bateria) {
        $this->bateria = $bateria;
    }

    public function setChave($chave) {
        $this->chave = $chave;
    }

    public function setBobina($bobina) {
        $this->bobina = $bobina;
    }

    public function setOutros($outros) {
        $this->outros = $outros;
    }
    
    function setLacreAntigo($lacreAntigo) {
        $this->lacreAntigo = $lacreAntigo;
        return $this;
    }

    function setLacreNovo($lacreNovo) {
        $this->lacreNovo = $lacreNovo;
        return $this;
    }

    function setNovoNSR($novoNSR) {
        $this->novoNSR = $novoNSR;
        return $this;
    }
    
    private function formatarIP($ip) {
        $ip = trim($ip);
        $ip = str_replace(".", "", $ip);
        return $ip;
    }
    
}