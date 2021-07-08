<?php

/**
 * Description of TarefaChamado
 *
 * @author cesantos
 */
class TarefaChamado {

    private $chamadoID;
    private $tarefaID;
    private $dtTarefa;
    private $duracao;
    private $usuarioAtribuicao;
    private $usuarioID;
    private $titulo;
    private $descricao;
    private $dtVencimento;
    private $status;
    private $cancelada;

    function __construct() {
        $this->chamadoID = null;
        $this->tarefaID = null;
        $this->dtTarefa = null;
        $this->duracao = null;
        $this->usuarioAtribuicao = null;
        $this->usuarioID = null;
        $this->titulo = null;
        $this->descricao = null;
        $this->dtVencimento = null;
        $this->status = null;
        $this->cancelada = false;
    }

    function getChamadoID() {
        return $this->chamadoID;
    }

    function getTarefaID() {
        return $this->tarefaID;
    }

    function getDtTarefa() {
        return $this->dtTarefa;
    }

    function getDuracao() {
        return $this->duracao;
    }

    function getUsuarioAtribuicao() {
        return $this->usuarioAtribuicao;
    }

    function getUsuarioID() {
        return $this->usuarioID;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDtVencimento() {
        return $this->dtVencimento;
    }

    function getStatus() {
        return $this->status;
    }
    
    function getCancelada() {
        return $this->cancelada;
    }

    function setChamadoID($chamadoID) {
        $this->chamadoID = $chamadoID;
    }

    function setTarefaID($tarefaID) {
        $this->tarefaID = $tarefaID;
    }

    function setDtTarefa($dtTarefa) {
        if (!$this->validarData($dtTarefa)) {
            throw new Exception('A data informada é inválida!', 103);
        } else {
            $this->dtTarefa = $this->formataData($dtTarefa);
        }
    }

    function setDuracao($duracao) {
        $this->duracao = $duracao;
    }

    function setUsuarioAtribuicao($usuarioAtribuicao) {
        $this->usuarioAtribuicao = $usuarioAtribuicao;
    }

    function setUsuarioID($usuarioID) {
        $this->usuarioID = $usuarioID;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDtVencimento($dtVencimento) {
        $this->dtVencimento = $dtVencimento;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    
    function setCancelada($cancelada) {
        $this->cancelada = $cancelada;
    }

    function calculaVencimento($dt, $duracao) {
        $hr = substr($duracao, 0, 2);
        $mim = substr($duracao, 3, 2);
        $interval = 'PT' . $hr . 'H' . $mim . 'M';
        $date = new DateTime($dt);
        $date->add(new DateInterval($interval));
        $this->dtVencimento = $date->format('Y-m-d H:i:s');
    }

    private function formataData($data) {
        $data = trim($data);
        $data = str_replace("/", "-", $data);
        date_default_timezone_set('America/Sao_Paulo');
        $newDate = date("Y-m-d H:i", strtotime($data));
        return $newDate;
    }

    private function validarData($data, $format = 'd/m/Y H:i') {
        $dateTime = new DateTime();
        $d = $dateTime->createFromFormat($format, $data);
        if ($d && $d->format($format) == $data) {
            return true;
        } else {
            return false;
        }
    }

}
