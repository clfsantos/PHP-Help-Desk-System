<?php

/**
 * Description of DadosDAO
 *
 * @author cesantos
 */
class DadosDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function salvar($dados) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("SELECT id_manutencao FROM dado_equipamento_manutencao WHERE id_manutencao = ?");
            $stmt->bindValue(1, $dados->getIdManutencao());
            $stmt->execute();
            $achou = $stmt->rowCount();
            if ($achou > 0) {
                $caiu = 'update';
                $query = "UPDATE dado_equipamento_manutencao "
                        . "SET nr_ip=:nr_ip, mascara=:mascara, gateway=:gateway, bateria=:bateria, chave=:chave, bobina=:bobina, outros=:outros, lacre_antigo=:lacre_antigo, lacre_novo=:lacre_novo, novo_nsr=:novo_nsr "
                        . "WHERE id_manutencao=:id_manutencao";
            } else {
                $caiu = 'insert';
                $query = "INSERT INTO dado_equipamento_manutencao "
                        . "(id_manutencao,nr_ip,mascara,gateway,bateria,chave,bobina,outros,lacre_antigo,lacre_novo,novo_nsr) "
                        . "VALUES (:id_manutencao,:nr_ip,:mascara,:gateway,:bateria,:chave,:bobina,:outros,:lacre_antigo,:lacre_novo,:novo_nsr)";
            }
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id_manutencao', $dados->getIdManutencao());
            $stmt->bindValue(':nr_ip', $dados->getNrIP());
            $stmt->bindValue(':mascara', $dados->getMascara());
            $stmt->bindValue(':gateway', $dados->getGateway());
            $stmt->bindValue(':bateria', $dados->getBateria());
            $stmt->bindValue(':chave', $dados->getChave());
            $stmt->bindValue(':bobina', $dados->getBobina());
            $stmt->bindValue(':outros', $dados->getOutros(), PDO::PARAM_STR);
            $stmt->bindValue(':lacre_antigo', $dados->getLacreAntigo(), PDO::PARAM_STR);
            $stmt->bindValue(':lacre_novo', $dados->getLacreNovo(), PDO::PARAM_STR);
            $stmt->bindValue(':novo_nsr', $dados->getNovoNSR(), PDO::PARAM_STR);
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível salvar! - ' . $e->getMessage() . ' - ' . $caiu);
        }
    }
    
    public function desvincular($id) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM dado_equipamento_manutencao WHERE id_manutencao=?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows) {
        try {
            $query = "SELECT * FROM dado_equipamento_manutencao "
                    . "WHERE id_manutencao = :id "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($id) {
        $query = "SELECT * FROM dado_equipamento_manutencao "
                . "WHERE id_manutencao = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

}
