<?php

class Conexao extends PDO {

    private $dsn = 'pgsql:host=localhost;dbname=sgsti;port=5432';
    private $usuario = 'postgres';
    private $senha = 'root';
    private $handle = null;

    function __construct() {
        try {
            if ($this->handle == null) {
                $dbh = parent::__construct($this->dsn, $this->usuario, $this->senha);
                $this->handle = $dbh;
                return $this->handle;
            }
        } catch (PDOException $e) {
            echo 'Conexão Falhou: ' . $e->getMessage();
            return false;
        }
    }

    function __destruct() {
        $this->handle = NULL;
    }

}
