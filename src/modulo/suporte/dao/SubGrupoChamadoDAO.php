<?php

/**
 * Description of SubGrupoChamadoDAO
 *
 * @author cesantos
 */
class SubGrupoChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($subGrupo, $grupos) {
        try {
            if (empty($grupos)) {
                throw new Exception("Selecione ao menos 1 grupo para o sub-grupo!", 105);
            }
            $this->conexao->beginTransaction();
            $query = "INSERT INTO spchamado_subgrupo (spchamado_subgrupo_desc) VALUES (?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $subGrupo->getSpchamado_subgrupo_desc(), PDO::PARAM_STR);
            $stmt->execute();
            $sub_grupo_id = $this->conexao->lastInsertId('spchamado_subgrupo_spchamado_subgrupo_id_seq');
            foreach ($grupos as $grupo) {
                $stmt = $this->conexao->prepare("INSERT INTO spchamado_grupo_subgrupo (spchamado_grupo_id, spchamado_subgrupo_id) VALUES (?,?)");
                $stmt->bindValue(1, $grupo, PDO::PARAM_INT);
                $stmt->bindValue(2, $sub_grupo_id, PDO::PARAM_INT);
                $stmt->execute();
            }
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O Sub-Grupo (' . $subGrupo->getSpchamado_subgrupo_desc() . ') já está cadastrado e não pode ser duplicado. Neste caso faça uma edição do sub-grupo já existente e vincule ele a outro grupo.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function editar($subGrupo, $grupos) {
        try {
            if (empty($grupos)) {
                throw new Exception("Selecione ao menos 1 grupo para o sub-grupo!", 105);
            }
            $this->conexao->beginTransaction();
            $query = "UPDATE spchamado_subgrupo SET spchamado_subgrupo_desc=? "
                    . "WHERE spchamado_subgrupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $subGrupo->getSpchamado_subgrupo_desc(), PDO::PARAM_STR);
            $stmt->bindValue(2, $subGrupo->getSpchamado_subgrupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_grupo_subgrupo WHERE spchamado_subgrupo_id = ?");
            $stmt->bindValue(1, $subGrupo->getSpchamado_subgrupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            foreach ($grupos as $grupo) {
                $stmt = $this->conexao->prepare("INSERT INTO spchamado_grupo_subgrupo (spchamado_grupo_id, spchamado_subgrupo_id) VALUES (?,?)");
                $stmt->bindValue(1, $grupo, PDO::PARAM_INT);
                $stmt->bindValue(2, $subGrupo->getSpchamado_subgrupo_id(), PDO::PARAM_INT);
                $stmt->execute();
            }
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O Sub-Grupo (' . $subGrupo->getSpchamado_subgrupo_desc() . ') já está cadastrado e não pode ser duplicado. Neste caso faça uma edição do sub-grupo já existente e vincule ele a outro grupo.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function excluir($subGrupo) {
        try {
            $this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_grupo_subgrupo WHERE spchamado_subgrupo_id = ?");
            $stmt->bindValue(1, $subGrupo->getSpchamado_subgrupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM spchamado_subgrupo WHERE spchamado_subgrupo_id = ?");
            $stmt->bindValue(1, $subGrupo->getSpchamado_subgrupo_id(), PDO::PARAM_INT);
            $stmt->execute();
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM spchamado_subgrupo "
                    . "WHERE LOWER(spchamado_subgrupo_desc) LIKE LOWER(:busca) "
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
        $query = "SELECT count(spchamado_subgrupo_id) FROM spchamado_subgrupo "
                . "WHERE LOWER(spchamado_subgrupo_desc) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarSubGrupo($id) {
        try {
            $query = "SELECT * "
                    . "FROM spchamado_subgrupo "
                    . "WHERE spchamado_subgrupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function subGrupoLista($id) {
        try {
            $query = "SELECT spchamado_grupo_id "
                    . "FROM spchamado_grupo_subgrupo "
                    . "WHERE spchamado_subgrupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function subgrupoChamadoCombo($grupoID) {
        try {
            $query = "SELECT spchamado_subgrupo_id, spchamado_subgrupo_desc "
                    . "FROM vw_spchamado_subgrupo "
                    . "WHERE spchamado_grupo_id = ? "
                    . "ORDER BY spchamado_subgrupo_desc ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $grupoID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
