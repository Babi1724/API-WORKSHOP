<?php

class MysqlSingleton
{
    private static ?MysqlSingleton $instance = null;
    private $dsn = 'mysql:host=localhost;dbname=workshop_scheduling';
    private $usuario = "root";
    private $senha = "";
    private $options = null;
    private $conn = null;


    private function __construct()
    {
        if ($this->conn == null) {
            $this->conn = new PDO($this->dsn, $this->usuario, $this->senha, $this->options);
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new MysqlSingleton();
        }

        return self::$instance;
    }


    public function executar($query, $param = array())
    {


        if ($this->conn) {
            $sth = $this->conn->prepare($query);
            foreach ($param as $k => $v) {
                $sth->bindValue($k, $v);
            }

            $sth->execute($param);
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}