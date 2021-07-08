<?php

class ChamadoDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function inserir($chamado) {
        try {
            $this->conexao->beginTransaction();
            $query = "INSERT INTO spchamado "
                    . "(spchamado_cliente_id,spchamado_contato,spchamado_financeiro,spchamado_osrel,spchamado_origem_id,spchamado_class_id,spchamado_produto_id,spchamado_titulo,spchamado_ocorrencia,spchamado_resolver,spchamado_aberto,spchamado_responsavel_id,spchamado_resp_atual_id,spchamado_resp_fechamento_id,spchamado_sla_prioridade_id,spchamado_sla_data_vto,spchamado_dt_encerramento,spchamado_grupo_id,spchamado_subgrupo_id,spchamado_release_id,spchamado_status) "
                    . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $chamado->getClienteID());
            $stmt->bindValue(2, $chamado->getContato());
            $stmt->bindValue(3, $chamado->getFinanceiro());
            $stmt->bindValue(4, $chamado->getOsRel());
            $stmt->bindValue(5, $chamado->getOrigemID());
            $stmt->bindValue(6, $chamado->getClassID());
            $stmt->bindValue(7, $chamado->getProdutoID());
            $stmt->bindValue(8, $chamado->getTitulo());
            $stmt->bindValue(9, $chamado->getOcorrencia());
            $stmt->bindValue(10, $chamado->getParecerFinal());
            $stmt->bindValue(11, $chamado->getSituacao());
            $stmt->bindValue(12, $chamado->getCriador());
            $stmt->bindValue(13, $chamado->getResponsavelAtual());
            $stmt->bindValue(14, $chamado->getFinalizadoPor());
            $stmt->bindValue(15, $chamado->getPrioridadeSLAID());
            $stmt->bindValue(16, $chamado->getDtVencimentoSLA());
            $stmt->bindValue(17, $chamado->getDtFechamento());
            $stmt->bindValue(18, $chamado->getGrupoID());
            $stmt->bindValue(19, $chamado->getSubGrupoID());
            $stmt->bindValue(20, $chamado->getReleaseID());
			$stmt->bindValue(21, $chamado->getStatus());
            $stmt->execute();
            $id = $this->conexao->lastInsertId('spchamado_spchamado_id_seq');
            $this->conexao->commit();
            return $id;
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O chamado (' . $chamado->getTitulo() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível incluir! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function atualizar($chamado) {
        try {
            $query = "UPDATE spchamado "
                    . "SET spchamado_cliente_id=?,spchamado_contato=?,spchamado_financeiro=?,spchamado_osrel=?,spchamado_origem_id=?,spchamado_class_id=?,spchamado_produto_id=?,spchamado_titulo=?,spchamado_ocorrencia=?,spchamado_resolver=?,spchamado_aberto=?,spchamado_resp_atual_id=?,spchamado_resp_fechamento_id=?,spchamado_dt_encerramento=?,spchamado_grupo_id=?,spchamado_subgrupo_id=?,spchamado_release_id=?,spchamado_status=? "
                    . "WHERE spchamado_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $chamado->getClienteID());
            $stmt->bindValue(2, $chamado->getContato());
            $stmt->bindValue(3, $chamado->getFinanceiro());
            $stmt->bindValue(4, $chamado->getOsRel());
            $stmt->bindValue(5, $chamado->getOrigemID());
            $stmt->bindValue(6, $chamado->getClassID());
            $stmt->bindValue(7, $chamado->getProdutoID());
            $stmt->bindValue(8, $chamado->getTitulo());
            $stmt->bindValue(9, $chamado->getOcorrencia());
            $stmt->bindValue(10, $chamado->getParecerFinal());
            $stmt->bindValue(11, $chamado->getSituacao());
            $stmt->bindValue(12, $chamado->getResponsavelAtual());
            $stmt->bindValue(13, $chamado->getFinalizadoPor());
            $stmt->bindValue(14, $chamado->getDtFechamento());
            $stmt->bindValue(15, $chamado->getGrupoID());
            $stmt->bindValue(16, $chamado->getSubGrupoID());
            $stmt->bindValue(17, $chamado->getReleaseID());
			$stmt->bindValue(18, $chamado->getStatus());
            $stmt->bindValue(19, $chamado->getChamadoID());
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '23505') {
                $motivo = 'O chamado (' . $chamado->getTitulo() . ') já está cadastrado e não pode ser duplicado. Tente fazer uma busca.';
            } else {
                $motivo = "Não foi possível editar! Erro: " . $e->getMessage();
            }
            $mensagem = $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function cancelar($chamado) {
        try {
			$this->conexao->beginTransaction();
            $stmt = $this->conexao->prepare("DELETE FROM spimplantacao_etapa_chamado WHERE spchamado_id = ? AND etapa_status_id <> 1");
            $stmt->bindValue(1, $chamado->getChamadoID());
            $stmt->execute();
			$stmt = $this->conexao->prepare("UPDATE spchamado SET spchamado_cancelado = true, spchamado_aberto = false, spchamado_status = 3 WHERE spchamado_id = ?");
            $stmt->bindValue(1, $chamado->getChamadoID());
            $stmt->execute();
			$this->conexao->commit();
        } catch (PDOException $e) {
			$this->conexao->rollBack();
            if ($e->errorInfo[0] === '23503') {
                $motivo = 'Este chamado está vinculado a outro processo!';
            } else {
                $motivo = $e->getMessage();
            }
            $mensagem = 'Não foi possível excluir - ' . $motivo;
            throw new PDOException($mensagem);
        }
    }

    public function listar($busca, $offset, $rows, $sort, $order, $user, $status) {
        if (!empty($user)) {
            $addq = 'AND spchamado_resp_atual_id = ' . $user . ' ';
        } else {
            $addq = '';
        }
        if ($status === "fechado") {
            $buscastatus = 'AND spchamado_aberto = false ';
        } elseif ($status === "aberto") {
            $buscastatus = 'AND spchamado_aberto = true ';
        } elseif ($status === "cancelado") {
            $buscastatus = 'AND spchamado_cancelado = true ';
        } elseif ($status === "tudo") {
            $buscastatus = '';
        } else {
            $buscastatus = 'AND spchamado_aberto = true ';
        }
        try {
            $query = "SELECT * FROM vw_spchamado "
                    . "WHERE (LOWER(crcliente_razao) LIKE LOWER(:busca) "
                    . "OR LOWER(crcliente_fantasia) LIKE LOWER(:busca) "
                    . "OR LOWER(spchamado_contato) LIKE LOWER(:busca) "
                    . "OR LOWER(spchamado_ocorrencia) LIKE LOWER(:busca) "
                    . "OR LOWER(spchamado_dt_abertura_nft) LIKE LOWER(:busca) "
                    . "OR LOWER(spchamado_resp_atual_nome) LIKE LOWER(:busca)) " . $addq . $buscastatus
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

    public function contarBusca($busca, $user, $status) {
        if (!empty($user)) {
            $addq = 'AND spchamado_resp_atual_id = ' . $user . ' ';
        } else {
            $addq = '';
        }
        if ($status === "fechado") {
            $buscastatus = 'AND spchamado_aberto = false ';
        } elseif ($status === "aberto") {
            $buscastatus = 'AND spchamado_aberto = true ';
        } elseif ($status === "cancelado") {
            $buscastatus = 'AND spchamado_cancelado = true ';
        } elseif ($status === "tudo") {
            $buscastatus = '';
        } else {
            $buscastatus = 'AND spchamado_aberto = true ';
        }
        $query = "SELECT count(spchamado_id) FROM vw_spchamado "
                . "WHERE (LOWER(crcliente_razao) LIKE LOWER(:busca) "
                . "OR LOWER(crcliente_fantasia) LIKE LOWER(:busca) "
                . "OR LOWER(spchamado_contato) LIKE LOWER(:busca) "
                . "OR LOWER(spchamado_ocorrencia) LIKE LOWER(:busca) "
                . "OR LOWER(spchamado_dt_abertura_nft) LIKE LOWER(:busca) "
                . "OR LOWER(spchamado_resp_atual_nome) LIKE LOWER(:busca))" . $addq . $buscastatus;
        $stmt = $this->conexao->prepare($query);
        $busca = "%" . $busca . "%";
        $stmt->bindValue(':busca', $busca, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function listarChamado($id) {
        try {
            $query = "SELECT * "
                    . "FROM vw_spchamado "
                    . "WHERE spchamado_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function perfilJunsoftCombo($id) {
        try {
            $query = "SELECT perfil.perfil_id, perfil.perfil_descricao "
                    . "FROM crcliente_perfil "
                    . "INNER JOIN perfil ON (perfil.perfil_id=crcliente_perfil.perfil_id) "
                    . "INNER JOIN crcliente ON (crcliente.crcliente_id=crcliente_perfil.crcliente_id) "
                    . "WHERE crcliente.crcliente_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function clienteContratos($id) {
        try {
            $query = "SELECT contrato_desc, contrato_qtd "
                . "FROM contrato "
                . "INNER JOIN crcliente ON (crcliente.crcliente_nerp=contrato.contrato_cod_cliente) "
                . "WHERE crcliente_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function equipamentoClienteCombo($id) {
        try {
            $query = "SELECT codigo_equipamento, desc_nsr, inativo "
                    . "FROM vw_equipamento "
                    . "WHERE crcliente_id = ? "
                    . "ORDER BY inativo asc ";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function slaChamadoCombo() {
        try {
            $query = "SELECT spchamado_sla_id, spchamado_sla_desc, spchamado_sla_time "
                    . "FROM spchamado_sla";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function checaChamadoSituacao($chamadoID) {
        try {
            $query = "SELECT spchamado_aberto AS bool FROM spchamado WHERE spchamado_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $chamadoID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $bool = $row['bool'];
            return $bool;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível checar a situação! - ' . $e->getMessage());
        }
    }

    public function checaProdutoGrupo($produtoID, $grupoID) {
        if (empty($grupoID)) {
            return true;
        }
        try {
            $query = "SELECT * FROM spchamado_produto_grupo WHERE spchamado_produto_id = ? AND spchamado_grupo_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $produtoID, PDO::PARAM_INT);
            $stmt->bindValue(2, $grupoID, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível checar o grupo! - ' . $e->getMessage());
        }
    }

    public function trocaUsuarioAtual($usuarioID, $chamadoID) {
        try {
            $query = "UPDATE spchamado SET spchamado_resp_atual_id=? WHERE spchamado_id=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
            $stmt->bindValue(2, $chamadoID, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível trocar o usuário atual! - ' . $e->getMessage());
        }
    }

    public function checaUsuarioAtual($usuarioID, $chamadoID) {
        try {
            $query = "SELECT (spchamado_resp_atual_id = ?) AS bool FROM spchamado WHERE spchamado_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
            $stmt->bindValue(2, $chamadoID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $bool = $row['bool'];
            return $bool;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível checar o usuário atual! - ' . $e->getMessage());
        }
    }

    public function checaUsuarioFollowup($usuarioID, $followupID) {
        try {
            $query = "SELECT ((spchamado_resp_atual_id = spfollowup_usuario_id) AND spfollowup_usuario_id = ?) AS bool FROM vw_spchamado_followup WHERE spfollowup_id = ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $usuarioID, PDO::PARAM_INT);
            $stmt->bindValue(2, $followupID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $bool = $row['bool'];
            return $bool;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível checar o usuário atual no followup! - ' . $e->getMessage());
        }
    }

    public function checaTarefas($chamadoID) {
        try {
            $query = "SELECT count(spchamado_id) AS qtd FROM sptarefa WHERE spchamado_id = ? AND sptarefa_status = false";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $chamadoID, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $qtd = $row['qtd'];
            if ($qtd > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível checar o usuário atual! - ' . $e->getMessage());
        }
    }

    public function logChamado($id) {
        try {
            $query = "SELECT spchamado_chamado_id,spchamado_log_dt,spchamado_log_desc,spchamado_log_usuario, get_usuario_nome(spchamado_log_usuario) as spchamado_log_usuario_nome "
                    . "FROM spchamado_log "
                    . "WHERE spchamado_chamado_id = ? "
                    . "ORDER BY spchamado_log_id ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $logs;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function anoChamadoCombo() {
        try {
            $query = "SELECT extract(year FROM spchamado_dt_abertura) AS spchamado_dt_ano FROM spchamado GROUP BY spchamado_dt_ano ORDER BY spchamado_dt_ano ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível listar! - ' . $e->getMessage());
        }
    }

    public function enviarPesquisa($chamado, $lastID, $fechado) {
        if (empty($chamado->getClienteMail())) {
            return;
        }
        try {
            $query = "SELECT get_crcliente_ultima_pesquisa(?) AS dt_ultima_pesquisa";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $chamado->getClienteID(), PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $dtUltimaPesquisa = $row['dt_ultima_pesquisa'];
            $chamado->setDtUltimaPesquisa($dtUltimaPesquisa);
            if ($fechado) {
                $dt_atual = new DateTime();
                if (empty($chamado->getDtUltimaPesquisa())) {
                    $dt_ultima = new DateTime('2017-01-01');
                } else {
                    $dt_ultima = new DateTime($chamado->getDtUltimaPesquisa());
                }
                $int = $dt_ultima->diff($dt_atual);
                $dias = (int) $int->format('%R%a');
                if ($dias > 30) {
                    $query = "INSERT INTO spchamado_pesquisa (spchamado_id, crcliente_id, email_enviado) VALUES(?,?,?)";
                    $stmt = $this->conexao->prepare($query);
                    $stmt->bindValue(1, $lastID, PDO::PARAM_INT);
                    $stmt->bindValue(2, $chamado->getClienteID(), PDO::PARAM_INT);
                    $stmt->bindValue(3, $chamado->getClienteMail(), PDO::PARAM_STR);
                    $stmt->execute();
                    return $chamado->enviarEmail($chamado->getClienteMail());
                } else {
                    return 'Não envia, última enviada há: ' . $dias;
                }
            } else {
                return 'Não está fechado, não envia';
            }
        } catch (PDOException $e) {
            throw new PDOException('Não foi possível enviar a pesquisa! - ' . $e->getMessage());
        }
    }

}
