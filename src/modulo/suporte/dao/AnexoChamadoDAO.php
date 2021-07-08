<?php

/**
 * Description of AnexoChamadoDAO
 *
 * @author cesantos
 */
class AnexoChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($upload) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO spanexo (spchamado_id, spanexo_nome, spanexo_caminho, spanexo_usuario) VALUES (?,?,?,?)");
            $stmt->bindValue(1, $upload->getChamadoID());
            $stmt->bindValue(2, $upload->getAnexoNome());
            $stmt->bindValue(3, $upload->getArquivo());
            $stmt->bindValue(4, $upload->getUsuarioID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível inserir! - ' . $e->getMessage());
        }
    }

    public function atualizar($upload) {
        try {
            $stmt = $this->conexao->prepare("UPDATE arquivomanutencao SET nome_arquivo=? WHERE id_arquivo=?");
            $stmt->bindValue(1, $upload->getNomeArquivo());
            $stmt->bindValue(2, $upload->getIdArquivo());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function excluir($upload) {
        try {
            if (file_exists("../arquivos/" . $upload->getAnexoCaminho())) {
                unlink("../arquivos/" . $upload->getAnexoCaminho());
            }
            $stmt = $this->conexao->prepare("DELETE FROM spanexo WHERE spanexo_id=?");
            $stmt->bindValue(1, $upload->getAnexoID());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT spanexo_id, "
                    . "to_char(spanexo_dt_up, 'dd/mm/YYYY HH24:MI:ss'::text) AS spanexo_dt_up, "
                    . "spanexo_nome, "
                    . "get_usuario_nome(spanexo_usuario) as spanexo_u_nome, "
                    . "spanexo_caminho, "
					. "spanexo_caminho AS caminho2 "
                    . "FROM spanexo "
                    . "WHERE spchamado_id = :id "
                    . "ORDER BY $sort $order "
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
        $query = "SELECT count(spanexo_id) "
                . "FROM spanexo "
                . "WHERE spchamado_id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarAnexoChamado($id) {
        try {
            $query = "SELECT * "
                    . "FROM spanexo "
                    . "WHERE spanexo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function verificaUsuarioAnexo($usuarioID, $anexoID) {
        try {
            $query = "SELECT (spanexo_usuario = ?) AS bool FROM spanexo WHERE spanexo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
            $stmt->bindValue(2, $anexoID, PDO::PARAM_INT);
            $stmt->execute();
            $bool = $stmt->fetch(PDO::FETCH_ASSOC);
            return $bool['bool'];
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível verificar o usuário! - ' . $e->getMessage());
        }
    }

}
