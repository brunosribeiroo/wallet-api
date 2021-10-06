<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDOException;
use PDO;

class TransactionRepository
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addTransactionCredit($transaction)
    {
        try{
            $query = 'INSERT INTO transactions_credit (id_user, type, value) VALUES (?, ?, ?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$transaction->id_user, $transaction->type, $transaction->value]);
            return true;
        } catch (PDOException $e){
            throw new Error('Erro ao adicionar transação de crédito no DB ' . $e->getMessage());
        }
    }

    public function addTransactionDebit($transaction)
    {
        try{
            $query = 'INSERT INTO transactions_debit (id_user, type, value) VALUES (?, ?, ?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$transaction->id_user, $transaction->type, $transaction->value]);
            return true;
        } catch (PDOException $e){
            throw new Error('Erro ao adicionar transação de débito no DB ' . $e->getMessage());
        }
    }
}