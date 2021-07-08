<?php

class EstatisticasDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function listar($busca, $offset, $rows, $sort, $order, $envio_id, $hora) {
        if (!empty($hora)) {
            $hr = "AND extract(hour from dt_leitura) = " . $hora;
        } else {
            $hr = '';
        }
        try {
            $query = "SELECT count(contato_id) as qtdade, contato_id, nome, email, baixa "
                    . "FROM envio_leitura "
                    . "INNER JOIN contato ON (contato.id = envio_leitura.contato_id) "
                    . "WHERE LOWER(email) LIKE LOWER(:busca) AND envio_id = :envio_id " . $hr
                    . "GROUP BY contato_id, nome, email, baixa "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindValue(':envio_id', $envio_id, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBusca($busca, $envio_id, $hora) {
        if (!empty($hora)) {
            $hr = "AND extract(hour from dt_leitura) = " . $hora;
        } else {
            $hr = '';
        }
        $query = "SELECT count(contato_id) as qtdade, contato_id, nome, email, baixa "
                . "FROM envio_leitura "
                . "INNER JOIN contato ON (contato.id = envio_leitura.contato_id) "
                . "WHERE LOWER(email) LIKE LOWER(:busca) AND envio_id = :envio_id " . $hr
                . "GROUP BY contato_id, nome, email, baixa";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->bindValue(':envio_id', $envio_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarStatus($busca, $offset, $rows, $sort, $order, $envio_id) {
        try {
            $query = "SELECT * FROM envio_baixa "
                    . "INNER JOIN contato ON (contato.id = envio_baixa.contato_id) "
                    . "WHERE LOWER(email) LIKE LOWER(:busca) AND envio_id = :envio_id "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindValue(':envio_id', $envio_id, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contarBuscaStatus($busca, $envio_id) {
        $query = "SELECT * FROM envio_baixa "
                . "INNER JOIN contato ON (contato.id = envio_baixa.contato_id) "
                . "WHERE LOWER(email) LIKE LOWER(:busca) AND envio_id = :envio_id";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->bindValue(':envio_id', $envio_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

}
