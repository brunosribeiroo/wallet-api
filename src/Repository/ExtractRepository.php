<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDOException;
use PDO;

class ExtractRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function perPeriod($id, $initialDate, $finalDate)
    {
        try{
            $query = 'SELECT users.name, users.nickname, transactions_credit.type, transactions_credit.value, 
            transactions_credit.created_at FROM users
            INNER JOIN transactions_credit
            ON users.id = transactions_credit.id_user 
            WHERE users.id = ? AND users.deleted = 0 AND transactions_credit.created_at >= ? AND transactions_credit.created_at <= ?
            UNION ALL
            SELECT users.name, users.nickname, transactions_debit.type, transactions_debit.value * -1, 
            transactions_debit.created_at FROM users
            INNER JOIN transactions_debit
            ON users.id = transactions_debit.id_user
            WHERE users.id = ? AND users.deleted = 0 AND transactions_debit.created_at >= ? AND transactions_debit.created_at <= ?
            ORDER BY created_at';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$id, $initialDate, $finalDate, $id, $initialDate, $finalDate]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Error('Erro ao buscar extrato dos últimos 30 dias no DB ' . $e->getMessage());
        }
    }
}