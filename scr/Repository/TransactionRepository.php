<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDOException;

class TransactionRepository{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addTransaction($transaction)
    {
        try{
            $query = 'INSERT INTO transactions (id_user, type, value) VALUES (?, ?, ?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$transaction['id_user'], $transaction['type'], $transaction['value']]);
            return true;
        } catch (PDOException $e){
            throw new Error('Erro ao adicionar transação no DB ' . $e->getMessage());
        }
    }
}