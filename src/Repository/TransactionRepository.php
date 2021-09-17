<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDOException;
use PDO;

class TransactionRepository{

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

    public function getBalanceById($id)
    {
        try{
            $query =  'SELECT users.id, 
                       users.name, 
                       users.nickname, 
                       COALESCE( SUM(wallet.transactions_credit.value), 0.0) - (SELECT COALESCE(SUM(value), 0.0) FROM transactions_debit WHERE id_user = ?) AS saldo
                       FROM users 
                       LEFT JOIN transactions_credit 
                       ON users.id = transactions_credit.id_user 
                       WHERE users.id = ? AND users.deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$id, $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['id'] == null) return null;
            return $result;
        } catch (PDOException $e){
            throw new Error('Erro ao consultar saldo no DB ' . $e->getMessage());
        }
    }
}