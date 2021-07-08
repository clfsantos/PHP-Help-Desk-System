<?php

/**
 * Description of CRClienteDAO
 *
 * @author cesantos
 */
class CRClienteDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function editar($cliente) {
        try {
            $query = "UPDATE crcliente SET crcliente_bloqueado=?, crcliente_obs=?, rcliente_celular=?, crcliente_email_rh=?, contabilidade_id=?, crcliente_up_mail_or_cel=now() "
                    . "WHERE crcliente_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $cliente->getCrclienteBloqueado());
            $stmt->bindValue(2, $cliente->getCrclienteOBS());
			$stmt->bindValue(3, $cliente->getCrClienteCelular());
			$stmt->bindValue(4, $cliente->getCrClienteEmailRH());
            $stmt->bindValue(5, $cliente->getContabilidadeId());
			$stmt->bindValue(6, $cliente->getCrclienteId());
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível atualizar! - ' . $e->getMessage());
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order) {
        try {
            $query = "SELECT * FROM vw_crcliente "
                    . "WHERE LOWER(crcliente_cnpj) LIKE LOWER(:busca) OR "
                    . "lower(translate(crcliente_razao,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) LIKE lower(translate(:busca,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) OR "
                    . "lower(translate(crcliente_fantasia,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) LIKE lower(translate(:busca,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) "
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
        $query = "SELECT count(crcliente_id) FROM vw_crcliente "
                . "WHERE LOWER(crcliente_cnpj) LIKE LOWER(:busca) OR "
                . "lower(translate(crcliente_razao,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) LIKE lower(translate(:busca,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) OR "
                . "lower(translate(crcliente_fantasia,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc')) LIKE lower(translate(:busca,'âãáàäéèêëíìîïóòôõöúùûüçÂÃÁÀÄÉÈÊËÍÍÌÎÏÓÒÔÕÖÚÙÛÜÇ', 'aaaaaeeeeiiiiooooouuuucaaaaaeeeeiiiiooooouuuuc'))";
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarCliente($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_crcliente "
                    . "WHERE crcliente_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

}