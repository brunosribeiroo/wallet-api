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
        'CREATE TABLE IF NOT EXISTS transactions_credit (
            id INT AUTO_INCREMENT,
            id_user INT NOT NULL,
            type varchar(240) NOT NULL,
            value decimal(65,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY(id_user) REFERENCES users (id)
        );',    

        'CREATE TABLE IF NOT EXISTS transactions_debit  (
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
            (2, "Bruce", "batman", 1),
            (3, "Walter White", "Heisenberg", 0),
            (4, "User test API", "usertesteapi", 0),
            (5, "Teste sem saldo", "testesemsaldo", 0),
            (6, "Teste saldo negativo", "saldonegativo", 0);
        ',
        'INSERT INTO transactions_credit(id_user, type, value) VALUES
            (1, "entrada", 500.00),
            (1, "entrada", 380.00),
            (1, "entrada", 220.50),
            (2, "entrada", 180.75),
            (2, "entrada", 197.55),
            (2, "entrada", 1052.80),
            (3, "entrada", 875.75),
            (3, "entrada", 982.90);
        ',
        'INSERT INTO transactions_debit (id_user, type, value) VALUES
            (1, "saida", 375.45),
            (1, "saida", 15.98),
            (2, "saida", 285.95),
            (2, "saida", 52.87),
            (6, "saida", 100.89),
            (3, "saida", 10.99),
            (3, "saida", 87.45);
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



