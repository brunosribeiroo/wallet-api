<?php

namespace Brunosribeiro\WalletApi\Infra;

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
        if($this->connection == null)
        {
            $conn = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            $this->connection = $conn;
            return $this->connection;
        } else {
            return $this->connection;
        }
    }
}