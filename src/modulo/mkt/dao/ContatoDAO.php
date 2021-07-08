<?php

class ContatoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function cadastrar($contato, $listas, $updateLista) {
        try {
            if (empty($listas)) {
                throw new Exception("Selecione ao menos 1 lista para o contato!", 105);
            }
            $query = "INSERT INTO contato (nome,email,cidade_id) VALUES (?,lower(?),?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $contato->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(2, $contato->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(3, $contato->getCidadeID(), PDO::PARAM_INT);
            $stmt->execute();
            $contato_id = $this->conexao->lastInsertId('contato_id_seq');
            foreach ($listas as $lista) {
                $stmt = $this->conexao->prepare("INSERT INTO lista_contato (lista_id, contato_id) VALUES (?,?)");
                $stmt->bindValue(1, $lista, PDO::PARAM_INT);
                $stmt->bindValue(2, $contato_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                if ($updateLista === 's') {
                    try {
                        $this->conexao->beginTransaction();
                        $query = "SELECT get_contato_id(?);";
                        $stmt = $this->conexao->prepare($query);
                        $stmt->bindValue(1, $contato->getEmail(), PDO::PARAM_STR);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_NUM);
                        $query = "DELETE FROM lista_contato WHERE contato_id = ?;";
                        $stmt = $this->conexao->prepare($query);
                        $stmt->bindValue(1, $row[0], PDO::PARAM_INT);
                        $stmt->execute();
                        foreach ($listas as $lista) {
                            $stmt = $this->conexao->prepare("INSERT INTO lista_contato (lista_id, contato_id) VALUES (?,?)");
                            $stmt->bindValue(1, $lista, PDO::PARAM_INT);
                            $stmt->bindValue(2, $row[0], PDO::PARAM_INT);
                            $stmt->execute();
                        }
                        $this->conexao->commit();
                    } catch (PDOException $e) {
                        $this->conexao->rollBack();
                        throw new PDOException('Não foi possível atualizar contato! - ' . $e->getMessage());
                    }
                } elseif ($updateLista === 'sn') {
                    try {
                        $this->conexao->beginTransaction();
                        $query = "SELECT get_contato_id(?);";
                        $stmt = $this->conexao->prepare($query);
                        $stmt->bindValue(1, $contato->getEmail(), PDO::PARAM_STR);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_NUM);
                        foreach ($listas as $lista) {
                            $stmt = $this->conexao->prepare("INSERT INTO lista_contato (lista_id, contato_id) VALUES (?,?)");
                            $stmt->bindValue(1, $lista, PDO::PARAM_INT);
                            $stmt->bindValue(2, $row[0], PDO::PARAM_INT);
                            $stmt->execute();
                        }
                        $this->conexao->commit();
                    } catch (PDOException $e) {
                        $this->conexao->rollBack();
                        throw new PDOException('Não foi possível atualizar contato! - ' . $e->getMessage());
                    }
                }
                throw new PDOException("O e-mail: " . $contato->getEmail() . " já está cadastrado!");
            } else {
                throw new PDOException('Não foi possível cadastrar! - ' . $e->getMessage());
            }
        }
    }

    public function editar($contato, $listas) {
        try {
            if (empty($listas)) {
                throw new Exception("Selecione ao menos 1 lista para o contato!", 105);
            }
            $this->conexao->beginTransaction();
            $query = "UPDATE contato SET nome=?,email=lower(?),cidade_id=? "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $contato->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(2, $contato->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(3, $contato->getCidadeID(), PDO::PARAM_INT);
            $stmt->bindValue(4, $contato->getId(), PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $this->conexao->prepare("DELETE FROM lista_contato WHERE contato_id = ?");
            $stmt->bindValue(1, $contato->getId(), PDO::PARAM_INT);
            $stmt->execute();
            foreach ($listas as $lista) {
                $stmt = $this->conexao->prepare("INSERT INTO lista_contato (lista_id, contato_id) VALUES (?,?)");
                $stmt->bindValue(1, $lista, PDO::PARAM_INT);
                $stmt->bindValue(2, $contato->getId(), PDO::PARAM_INT);
                $stmt->execute();
            }
            $this->conexao->commit();
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            if ($e->errorInfo[0] === '23505') {
                throw new PDOException("O e-mail: " . $contato->getEmail() . " já está cadastrado para outro usuário!");
            } else {
                throw new PDOException('Não foi possível editar! - ' . $e->getMessage());
            }
        }
    }

    public function excluir($contato) {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM contato WHERE id = ?");
            $stmt->bindValue(1, $contato->getId(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível excluir! - ' . $e->getMessage());
        }
    }

    public function listar($busca, $buscaStatus, $offset, $rows, $sort, $order) {
        $addQuery = '';
        if (!empty($buscaStatus)) {
            if ($buscaStatus === 'baixa') {
                $addQuery = 'AND baixa=true';
            } elseif ($buscaStatus === 'ativo') {
                $addQuery = 'AND baixa=false';
            }
        }
        try {
            $query = "SELECT * "
                    . "FROM vw_contato "
                    . "WHERE LOWER(email) LIKE LOWER(:busca) $addQuery "
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

    public function contarBusca($busca, $buscaStatus) {
        $addQuery = '';
        if (!empty($buscaStatus)) {
            if ($buscaStatus === 'baixa') {
                $addQuery = 'AND baixa=true';
            } elseif ($buscaStatus === 'ativo') {
                $addQuery = 'AND baixa=false';
            }
        }
        $query = "SELECT * "
                . "FROM vw_contato "
                . "WHERE LOWER(email) LIKE LOWER(:busca) $addQuery";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listarContato($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_contato "
                    . "WHERE id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contatoLista($id) {
        try {
            $query = "SELECT lista_id "
                    . "FROM lista_contato "
                    . "WHERE contato_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contatosLista($busca, $offset, $rows, $sort, $order, $lista_id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_contato "
                    . "INNER JOIN lista_contato ON (lista_contato.contato_id=vw_contato.id) "
                    . "WHERE lista_id = :lista AND LOWER(email) LIKE LOWER(:busca) "
                    . "ORDER BY $sort $order "
                    . "LIMIT :rows OFFSET :offset";
            $stmt = $this->conexao->prepare($query);
            $busca = "%" . $busca . "%";
            $stmt->bindValue(':lista', $lista_id, PDO::PARAM_INT);
            $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':rows', $rows, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function contatosListaBusca($busca, $lista_id) {
        $query = "SELECT * "
                . "FROM vw_contato "
                . "INNER JOIN lista_contato ON (lista_contato.contato_id=vw_contato.id) "
                . "WHERE lista_id = :lista AND LOWER(email) LIKE LOWER(:busca)";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':lista', $lista_id, PDO::PARAM_INT);
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function historicoLeitura($id) {
        try {
            $query = "SELECT envio.id, count(*) as qtd, titulo, data_envio "
                    . "FROM envio_leitura "
                    . "INNER JOIN envio ON (envio.id = envio_leitura.envio_id) "
                    . "WHERE contato_id = ? "
                    . "GROUP BY envio.id "
                    . "ORDER BY envio.id ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}
