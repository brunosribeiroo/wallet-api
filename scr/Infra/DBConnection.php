<?php

namespace Brunosribeiro\WalletApi\Infra;

use Error;
use PDO;

class DBConnection
{
    public function __construct($host, $database, $user, $pass)
    {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->pass = $pass;
        $this->connection = null;
    }

    public function get()
    {
        try{
            if($this->connection == null)
            {
                $driver = 'mysql:host='.$this->host.';dbname='.$this->database;
                $conn = new PDO($driver, $this->user, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
                $this->connection = $conn;
                return $this->connection;
            } else {
                return $this->connection;
            }
        } catch(PDOException $e){
            throw new Error('Erro ao se conectar ao DB ' . $e->getMessage(), 1);
        }
    }
}