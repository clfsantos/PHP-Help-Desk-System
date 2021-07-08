<?php

class FluxoAtendimentoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function gravar($atendimento) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO spchamado_fluxo (usuario_id, crcliente_id) VALUES (?,?)");
            $stmt->bindValue(1, $atendimento->getUsuarioID());
            $stmt->bindValue(2, $atendimento->getClienteID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível gravar! - ' . $e->getMessage());
        }
    }
    
    public function gravarFila($atendimento) {
        if(empty($atendimento->getFilaID())) {
            $this->novoFila($atendimento);
        } else {
            $this->atualizarFila($atendimento);
        }
    }
    
    private function novoFila($atendimento) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO spchamado_fila (crcliente_id, spchamado_fila_obs) VALUES (?,?)");
            $stmt->bindValue(1, $atendimento->getClienteID());
            $stmt->bindValue(2, $atendimento->getObs());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível gravar! - ' . $e->getMessage());
        }
    }
    
    private function atualizarFila($atendimento) {
        try {
            $stmt = $this->conexao->prepare("UPDATE spchamado_fila SET crcliente_id = ?, spchamado_fila_obs = ? WHERE spchamado_fila_id = ?");
            $stmt->bindValue(1, $atendimento->getClienteID());
            $stmt->bindValue(2, $atendimento->getObs());
            $stmt->bindValue(3, $atendimento->getFilaID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }
    
    public function marcarAtendido($filaID) {
        try {
            $stmt = $this->conexao->prepare("UPDATE spchamado_fila SET spchamado_fila_atendido = true WHERE spchamado_fila_id = ?");
            $stmt->bindValue(1, $filaID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível gravar! - ' . $e->getMessage());
        }
    }
    
    public function addRetorno($filaID) {
        try {
            $stmt = $this->conexao->prepare("UPDATE spchamado_fila SET spchamado_fila_qtd = (spchamado_fila_qtd + 1) WHERE spchamado_fila_id = ?");
            $stmt->bindValue(1, $filaID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível incrementar quantidade! - ' . $e->getMessage());
        }
    }
    
    public function listarFluxo() {
        try {
            $query = "SELECT spchamado_fluxo_dt, "
                    . "to_char(spchamado_fluxo_dt, 'dd/mm/YYYY HH24:MI:ss'::text) AS spchamado_fluxo_dt_ft, "
                    . "crcliente_fantasia, "
                    . "nome "
                    . "FROM spchamado_fluxo "
                    . "INNER JOIN crcliente ON (crcliente.crcliente_id=spchamado_fluxo.crcliente_id) "
                    . "INNER JOIN usuario ON (usuario.id=spchamado_fluxo.usuario_id) "
                    . "WHERE date(spchamado_fluxo_dt) = date(now()) "
                    . "ORDER BY spchamado_fluxo_dt DESC";
            $stmt = $this->conexao->query($query);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }
    
    public function listarFila() {
        try {
            $query = "SELECT spchamado_fila_id, "
                    . "spchamado_fila_dt, "
                    . "to_char(spchamado_fila_dt, 'dd/mm/YYYY HH24:MI:ss'::text) AS spchamado_fila_dt_ft, "
                    . "crcliente.crcliente_id, "
                    . "crcliente_fantasia, "
                    . "spchamado_fila_qtd, "
                    . "spchamado_fila_obs "
                    . "FROM spchamado_fila "
                    . "INNER JOIN crcliente ON (crcliente.crcliente_id=spchamado_fila.crcliente_id) "
                    . "WHERE spchamado_fila_atendido = false "
                    . "ORDER BY spchamado_fila_dt ASC";
            $stmt = $this->conexao->query($query);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}