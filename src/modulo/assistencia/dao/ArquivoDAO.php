<?php

/**
 * Description of ArquivoDAO
 *
 * @author cesantos
 */
class ArquivoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($upload) {
        try {
            $stmt = $this->conexao->prepare("INSERT INTO arquivomanutencao (id_manutencao, nome_arquivo, caminho_arquivo) VALUES (?,?,?)");
            $stmt->bindValue(1, $upload->getIdManutencao());
            $stmt->bindValue(2, $upload->getNomeArquivo());
            $stmt->bindValue(3, $upload->getArquivo());
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
            if (file_exists("../arquivos/" . $upload->getCaminhoFinal())) {
                unlink("../arquivos/" . $upload->getCaminhoFinal());
            }
            $stmt = $this->conexao->prepare("DELETE FROM arquivomanutencao WHERE id_arquivo=?");
            $stmt->bindValue(1, $upload->getIdArquivo());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($id, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT id_arquivo, "
                    . "to_char(data_upload, 'dd/mm/YYYY HH24:MI:ss'::text) AS data_upload, "
                    . "nome_arquivo, "
                    . "caminho_arquivo "
                    . "FROM arquivomanutencao "
                    . "WHERE id_manutencao = :id "
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
        $query = "SELECT id_arquivo, "
                . "to_char(data_upload, 'dd/mm/YYYY HH24:MI:ss'::text) AS data_upload, "
                . "nome_arquivo, "
                . "caminho_arquivo "
                . "FROM arquivomanutencao "
                . "WHERE id_manutencao = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarArquivo($id) {
        try {
            $query = "SELECT * "
                    . "FROM arquivomanutencao "
                    . "WHERE id_arquivo = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
