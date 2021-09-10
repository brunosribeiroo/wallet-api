<?php

namespace Brunosribeiro\WalletApi\Services;
use Brunosribeiro\WalletApi\Repository\TransactionRepository;
use Error;
use Exception;

class TransactionServices
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addTransactionCredit($transaction)
    {
        try{
            if($transaction['type'] != 'entrada') throw new Exception('Tipo de transação incorreta');
            $transactionRepo = new TransactionRepository($this->db);
            $result = $transactionRepo->addTransactionCredit($transaction);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }

    public function addTransactionDebit($transaction)
    {
        try{
            if($transaction['type'] != 'saida') throw new Exception('Tipo de transação incorreta');
            $transactionRepo = new TransactionRepository($this->db);
            $balance = $transactionRepo->getBalanceById($transaction['id_user']);
            if($balance['total'] < $transaction['value']) throw new Exception('Transação negada! Seu saldo é insuficiente para essa transação. Saldo atual: R$' . $balance['total']);
            $result = $transactionRepo->addTransactionDebit($transaction);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }
}