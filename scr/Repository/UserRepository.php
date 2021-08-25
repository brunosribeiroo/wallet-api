<?php

namespace Brunosribeiro\WalletApi\Repository;

class UserRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createTable()
    {
        // $data = $this->db->query(
        //     'CREATE TABLE users (
        //     id INT AUTO_INCREMENT,
        //     name varchar(240) NOT NULL,
        //     nickname varchar(240) NOT NULL,
        //     PRIMARY KEY (id)
        //     )'
        // );

        $data = $this->db->exec('CREATE TABLE users (
            id INT AUTO_INCREMENT,
            name varchar(240) NOT NULL,
            nickname varchar(240) NOT NULL,
            PRIMARY KEY (id)
            )');

        echo $data;
        return true;
    }
}