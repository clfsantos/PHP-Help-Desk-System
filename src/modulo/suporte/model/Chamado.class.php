<?php

//include '../../assistencia/plugin/PHPMailer/PHPMailerAutoload.php';

class Chamado {

    private $chamadoID;
    private $situacao;
    private $dtAbertura;
    private $dtFechamento;
    private $dtUltimaPesquisa;
    private $criador;
    private $responsavelAtual;
    private $financeiro;
    private $osRel;
    private $clienteID;
    private $clienteMail;
    private $prioridadeSLAID;
    private $dtVencimentoSLA;
    private $origemID;
    private $classID;
    private $produtoID;
    private $grupoID;
    private $subGrupoID;
    private $titulo;
    private $contato;
    private $ocorrencia;
    private $parecerFinal;
    private $releaseID;
    private $finalizar;
    private $finalizadoPor;
	private $status;

    function __construct() {
        $this->chamadoID = null;
        $this->situacao = null;
        $this->dtAbertura = null;
        $this->dtFechamento = null;
        $this->dtUltimaPesquisa = null;
        $this->criador = null;
        $this->responsavelAtual = null;
        $this->financeiro = null;
        $this->osRel = null;
        $this->clienteID = null;
        $this->clienteMail = null;
        $this->prioridadeSLAID = null;
        $this->dtVencimentoSLA = null;
        $this->origemID = null;
        $this->classID = null;
        $this->produtoID = null;
        $this->grupoID = null;
        $this->subGrupoID = null;
        $this->titulo = null;
        $this->contato = null;
        $this->ocorrencia = null;
        $this->parecerFinal = null;
        $this->releaseID = null;
        $this->finalizar = null;
        $this->finalizadoPor = null;
		$this->status = null;
    }

    function getChamadoID() {
        return $this->chamadoID;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getDtAbertura() {
        return $this->dtAbertura;
    }

    function getDtFechamento() {
        return $this->dtFechamento;
    }

    function getDtUltimaPesquisa() {
        return $this->dtUltimaPesquisa;
    }

    function getCriador() {
        return $this->criador;
    }

    function getResponsavelAtual() {
        return $this->responsavelAtual;
    }

    function getFinanceiro() {
        return $this->financeiro;
    }

    function getOsRel() {
        return $this->osRel;
    }

    function getClienteID() {
        return $this->clienteID;
    }

    function getClienteMail() {
        return $this->clienteMail;
    }

    function getPrioridadeSLAID() {
        return $this->prioridadeSLAID;
    }

    function getDtVencimentoSLA() {
        return $this->dtVencimentoSLA;
    }

    function getOrigemID() {
        return $this->origemID;
    }

    function getClassID() {
        return $this->classID;
    }

    function getProdutoID() {
        return $this->produtoID;
    }

    function getGrupoID() {
        return $this->grupoID;
    }

    function getSubGrupoID() {
        return $this->subGrupoID;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getContato() {
        return $this->contato;
    }

    function getOcorrencia() {
        return $this->ocorrencia;
    }

    function getParecerFinal() {
        return $this->parecerFinal;
    }

    function getReleaseID() {
        return $this->releaseID;
    }

    function getFinalizar() {
        return $this->finalizar;
    }

    function getFinalizadoPor() {
        return $this->finalizadoPor;
    }
	
	function getStatus() {
        return $this->status;
    }

    function setChamadoID($chamadoID) {
        $this->chamadoID = $chamadoID;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setDtAbertura($dtAbertura) {
        $this->dtAbertura = $dtAbertura;
    }

    function setDtFechamento($dtFechamento) {
        $this->dtFechamento = $dtFechamento;
    }

    function setDtUltimaPesquisa($dtUltimaPesquisa) {
        if (!empty($dtUltimaPesquisa)) {
            $this->dtUltimaPesquisa = $this->formataData($dtUltimaPesquisa);
        } else {
            $this->dtUltimaPesquisa = null;
        }
    }

    function setCriador($criador) {
        $this->criador = $criador;
    }

    function setResponsavelAtual($responsavelAtual) {
        $this->responsavelAtual = $responsavelAtual;
    }

    function setFinanceiro($financeiro) {
        $this->financeiro = $financeiro;
    }

    function setOsRel($osRel) {
        if (empty($osRel)) {
            $this->osRel = null;
        } else {
            $this->osRel = $osRel;
        }
    }

    function setClienteID($clienteID) {
        if (!preg_match("/^\d+$/", $clienteID)) {
            throw new Exception('ID do cliente inválido!', 101);
        }
        $this->clienteID = $clienteID;
    }

    function setClienteMail($clienteMail) {
        if (empty($clienteMail)) {
            $this->clienteMail = null;
        } else {
            if (!preg_match("/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/", $clienteMail)) {
                throw new Exception("O email é inválido! Deixe em branco para não enviar a pesquisa", 102);
            }
            $this->clienteMail = $clienteMail;
        }
    }

    function setPrioridadeSLAID($prioridadeSLAID) {
        $this->prioridadeSLAID = $prioridadeSLAID;
    }

    function setDtVencimentoSLA($dtVencimentoSLA) {
        if ($this->prioridadeSLAID === '1') {
            $date = new DateTime();
            $date->add(new DateInterval('P1D'));
            $this->dtVencimentoSLA = $date->format('Y-m-d H:i:s');
        } elseif ($this->prioridadeSLAID === '2') {
            $date = new DateTime();
            $date->add(new DateInterval('PT4H'));
            $this->dtVencimentoSLA = $date->format('Y-m-d H:i:s');
        } elseif ($this->prioridadeSLAID === '3') {
            $date = new DateTime();
            $date->add(new DateInterval('PT1H'));
            $this->dtVencimentoSLA = $date->format('Y-m-d H:i:s');
        } else if (!$this->validarData($dtVencimentoSLA)) {
            throw new Exception('A data informada é inválida!', 105);
        } else {
            $this->dtVencimentoSLA = $this->formataData($dtVencimentoSLA);
        }
    }

    function setOrigemID($origemID) {
        if (!preg_match("/^\d+$/", $origemID)) {
            throw new Exception('ID da origem inválida!', 106);
        }
        $this->origemID = $origemID;
    }

    function setClassID($classID) {
        if (!preg_match("/^\d+$/", $classID)) {
            throw new Exception('ID da classe inválida!', 107);
        }
        $this->classID = $classID;
    }

    function setProdutoID($produtoID) {
        if (!preg_match("/^\d+$/", $produtoID)) {
            throw new Exception('ID do produto inválido!', 108);
        }
        $this->produtoID = $produtoID;
    }

    function setGrupoID($grupoID) {
        if (empty($grupoID)) {
            $this->grupoID = null;
        } else {
            if (!preg_match("/^\d+$/", $grupoID)) {
                throw new Exception('ID do produto inválido!', 109);
            }
            $this->grupoID = $grupoID;
        }
    }

    function setSubGrupoID($subGrupoID) {
        if (empty($subGrupoID)) {
            $this->subGrupoID = null;
        } else {
            if (!preg_match("/^\d+$/", $subGrupoID)) {
                throw new Exception('ID do produto inválido!', 110);
            }
            $this->subGrupoID = $subGrupoID;
        }
    }

    function setTitulo($titulo) {
        if (empty($titulo)) {
            $this->titulo = null;
        } else {
            $this->titulo = $titulo;
        }
    }

    function setContato($contato) {
        if (empty($contato)) {
            throw new Exception('O contato deve ser preenchido!', 112);
        }
        $this->contato = $contato;
    }

    function setOcorrencia($ocorrencia) {
        if (empty($ocorrencia)) {
            throw new Exception('A ocorrencia original deve ser preenchida', 113);
        }
        $this->ocorrencia = $ocorrencia;
    }

    function setParecerFinal($parecerFinal) {
        $this->parecerFinal = $parecerFinal;
    }

    function setReleaseID($releaseID) {
        if (empty($releaseID)) {
            $this->releaseID = null;
        } else {
            $this->releaseID = $releaseID;
        }
    }

    function setFinalizar($finalizar) {
        $this->finalizar = $finalizar;
    }

    function setFinalizadoPor($finalizadoPor) {
        if (empty($this->situacao)) {
            $this->finalizadoPor = $finalizadoPor;
        } else {
            $this->finalizadoPor = null;
        }
    }
	
	function setStatus($status) {
        $this->status = $status;
    }

    function verificaFechamento() {
        if (empty($this->situacao)) {
            if (empty($this->parecerFinal)) {
                throw new Exception('No fechamento o parecer final deve ser preenchido', 201);
            }
            if (empty($this->grupoID)) {
                throw new Exception('No fechamento o grupo do produto deve ser preenchido', 202);
            }
            if (empty($this->subGrupoID)) {
                throw new Exception('No fechamento o subgrupo do produto deve ser preenchido', 203);
            }
            $this->setDtFechamento(date("Y-m-d H:i:s"));
            return true;
        } else {
            return;
        }
    }

    private function formataData($data) {
        $data = trim($data);
        $data = str_replace("/", "-", $data);
        date_default_timezone_set('America/Sao_Paulo');
        $newDate = date("Y-m-d H:i:s", strtotime($data));
        return $newDate;
    }

    function validarData($data, $format = 'd/m/Y H:i:s') {
        $dateTime = new DateTime();
        $d = $dateTime->createFromFormat($format, $data);
        if ($d && $d->format($format) == $data) {
            return true;
        } else {
            return false;
        }
    }

    public function enviarEmail($email) {
        try {
            $To = $email;
            $Subject = 'Pesquisa de Satisfação - Tecsmart Sistemas';
            $Host = 'smtp_aqui';
            $Username = 'user_aqui';
            $Password = 'senha_aqui';
            $Port = "587";

            $this->IsSMTP();
            $this->Host = $Host;
            $this->SMTPAuth = true;
            $this->Port = $Port;
            $this->Username = $Username;
            $this->Password = $Password;

            $this->CharSet = 'UTF-8';
            $this->addReplyTo('mkt@tecsmart.com.br', 'Tecsmart Sistemas');
            $this->SetFrom($Username, 'Tecsmart Sistemas');
            $this->Subject = $Subject;
            $this->Body = file_get_contents("http://10.0.0.251:1234/sgsti/modulo/suporte/model/EmailPesquisaTemplate.php");
            $this->AltBody = 'Este e-mail contém html. Se não estiver conseguindo visualizar este e-mail baixe a mensagem em anexo.';
            $this->AddAddress($To, "");
            $this->Send();
        } catch (Exception $ex) {
            throw new Exception('Não foi possível enviar o e-mail! - ' . $ex->getMessage());
        }
    }

}
