<?php

class Conn
{
    private $server = "localhost";
    private $user = "root";
    private $pass = "";
    private $connect;

    public function __construct()
    {
        try {
            $this->connect = new PDO("mysql:host=$this->server;dbname=album", $this->user, $this->pass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return "falla de conexión " . $e;
        }
    }

    public function execute($sql)
    {
        $this->connect->exec($sql);
        return $this->connect->lastInsertId();
    }

    public function listar($sql)
    {
        $sentencia = $this->connect->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }
}
