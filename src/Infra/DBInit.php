<?php

namespace Brunosribeiro\WalletApi\Infra;

class iniciaDB
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    private $querys = [
        'CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT,
            name varchar(240) NOT NULL,
            nickname varchar(240) NOT NULL UNIQUE,
            deleted boolean,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        );',
        'CREATE TABLE IF NOT EXISTS transactions (
            id INT AUTO_INCREMENT,
            id_user INT NOT NULL,
            type varchar(240) NOT NULL,
            value decimal(65,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY(id_user) REFERENCES users (id)
        );',    
    
        'INSERT INTO users (id, name, nickname, deleted) VALUES
            (1, "Bruno", "brunoribeiro", 0),
            (2, "Bruce", "batman", 0),
            (3, "Walter White", "Heisenberg", 0)
        ',
        'INSERT INTO transactions (id_user, type, value) VALUES
            (1, "entrada", 500.00),
            (1, "entrada", 380.00),
            (1, "entrada", 220.50),
            (1, "saida", -375.45),
            (2, "entrada", 180.75),
            (2, "entrada", 197.55),
            (2, "entrada", 1052.80),
            (2, "saida", -285.95);
        '
    ];

    private function cadastraDB()
    {
        foreach($this->querys as $query){
            $this->db->get()->exec($query);
        }
    }

    public function iniciaDB()
    {
        $tableExists = $this->db->get()->query("SHOW TABLES LIKE 'users'")->rowCount() > 0;
        if(!$tableExists) $this->cadastraDB();
    }
}



