<?php

class Conexao extends PDO {

    private $dsn = 'mysql:host=mysql.tecsmart.com.br;dbname=tecsmart04';
    private $usuario = 'tecsmart04';
    private $senha = 'Tec141607';
    private $handle = null;

    function __construct() {
        try {
            if ($this->handle == null) {
                $dbh = parent::__construct($this->dsn, $this->usuario, $this->senha, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
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
