<?php

/**
 * Description of Followup
 *
 * @author cesantos
 */
include '../plugin/PHPMailer/PHPMailerAutoload.php';

class Followup extends PHPMailer {

    private $idFollowp;
    private $idManutencao;
    private $idEvento;
    private $descricaoEvento;
    private $idUsuario;
    private $conteudo;

    function __construct() {
        parent::__construct();
        $this->idFollowp = null;
        $this->idManutencao = null;
        $this->idEvento = null;
        $this->descricaoEvento = null;
        $this->idUsuario = null;
        $this->conteudo = null;
    }

    public function getIdFollowp() {
        return $this->idFollowp;
    }

    public function getIdManutencao() {
        return $this->idManutencao;
    }

    public function getIdEvento() {
        return $this->idEvento;
    }

    public function getDescricaoEvento() {
        return $this->descricaoEvento;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function setIdFollowp($idFollowp) {
        $this->idFollowp = $idFollowp;
    }

    public function setIdManutencao($idManutencao) {
        if (!preg_match("/^\d+$/", $idManutencao)) {
            throw new Exception('ID da manutenção inválido!', 101);
        }
        $this->idManutencao = $idManutencao;
    }

    public function setIdEvento($idEvento) {
        if (!preg_match("/^\d+$/", $idEvento)) {
            throw new Exception('ID do evento inválido!', 102);
        }
        $this->idEvento = $idEvento;
    }

    public function setDescricaoEvento($descricaoEvento) {
        $this->descricaoEvento = $descricaoEvento;
    }

    public function setIdUsuario($idUsuario) {
        if (!preg_match("/^\d+$/", $idUsuario)) {
            throw new Exception('ID do usuário inválido!', 103);
        }
        $this->idUsuario = $idUsuario;
    }

    public function setConteudo($conteudo) {
        $conteudo = trim($conteudo);
        if (strlen($conteudo) < 5) {
            throw new Exception('O conteúdo do followup deve ter ao menos 5 caracteres!', 104);
        }
        $this->conteudo = $conteudo;
    }

    public function enviarEmail($email) {
        try {
            $To = $email;
            $Subject = 'Andamento de seu equipamento em manutenção';
            $Message = "<p><strong>Olá!</strong></p>"
                    . "<p>Essa é uma informação de seu equipamento que está em assistência conosco:</p>"
                    . "<p><br>Equipamento encontra-se em: <strong>" . $this->descricaoEvento . "</strong></p>"
                    . "<p>Detalhes: <strong>" . $this->conteudo . "</strong></p>";

            $Host = 'smtp.tecsmart.com.br';
            $Username = 'mkt@tecsmart.com.br';
            $Password = 'TeC141607';
            $Port = "587";
            $body = $Message;

            $this->IsSMTP(); // telling the class to use SMTP
            $this->Host = $Host; // SMTP server
            $this->SMTPAuth = true; // enable SMTP authentication
            $this->Port = $Port; // set the SMTP port for the service server
            $this->Username = $Username; // account username
            $this->Password = $Password; // account password

            $this->CharSet = 'UTF-8';
            $this->addReplyTo('mkt@tecsmart.com.br', '');
            $this->SetFrom($Username, 'Tecsmart Sistemas');
            $this->Subject = $Subject;
            $this->MsgHTML($body);
            $this->AddAddress($To, "");
            $this->Send();
        } catch (Exception $ex) {
            throw new Exception('Não foi possível enviar o e-mail! - ' . $ex->getMessage());
        }
    }

}
