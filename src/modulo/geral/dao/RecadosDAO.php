<?php

/**
 * Description of RecadosDAO
 *
 * @author Cesar
 */
class RecadosDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($recado) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO recado (recado_desc,recado_empresa,recado_contato,recado_destino,recado_usuario_cadastro) VALUES (?,?,?,?,?)");
            $stmt->bindValue(1, $recado->getRecadoOBS());
            $stmt->bindValue(2, $recado->getEmpresa());
            $stmt->bindValue(3, $recado->getContato());
            $stmt->bindValue(4, $recado->getDepartamento());
            $stmt->bindValue(5, $recado->getUsuarioID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível cadastrar! Erro: ' . $e->getMessage());
        }
    }

    public function editar($recado) {
        try {
            $stmt = $this->conexao->prepare("UPDATE recado SET recado_desc=?,recado_empresa=?,recado_contato=?,recado_destino=? WHERE recado_id=?");
            $stmt->bindValue(1, $recado->getRecadoOBS());
            $stmt->bindValue(2, $recado->getEmpresa());
            $stmt->bindValue(3, $recado->getContato());
            $stmt->bindValue(4, $recado->getDepartamento());
            $stmt->bindValue(5, $recado->getID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível editar! Erro: ' . $e->getMessage());
        }
    }

    public function atender($recado) {
        try {
            $stmt = $this->conexao->prepare("SELECT recado_atendido FROM recado WHERE recado_id=?");
            $stmt->bindValue(1, $recado->getID());
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);
            if(!empty($row[0])) {
                throw new PDOException('Este recado já foi marcado como atendido, se preferir, marque como não atendido.');
            }
            $stmt = $this->conexao->prepare("UPDATE recado SET recado_atendido=true,recado_usuario=? WHERE recado_id=?");
            $stmt->bindValue(1, $recado->getUsuarioID());
            $stmt->bindValue(2, $recado->getID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível marcar como atendido! Erro: ' . $e->getMessage());
        }
    }
    
    public function marcarNaoAtendido($recado) {
        try {
            $stmt = $this->conexao->prepare("UPDATE recado SET recado_atendido=false,recado_usuario=null WHERE recado_id=?");
            $stmt->bindValue(1, $recado->getID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível marcar como atendido! Erro: ' . $e->getMessage());
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * "
                    . "FROM vw_recado "
                    . "WHERE LOWER(recado_empresa) LIKE LOWER(:busca) "
                    . "OR LOWER(recado_contato) LIKE LOWER(:busca) "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($busca) {
        $query = "SELECT count(*) "
                . "FROM vw_recado "
                . "WHERE LOWER(recado_empresa) LIKE LOWER(:busca) "
                . "OR LOWER(recado_contato) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

}
