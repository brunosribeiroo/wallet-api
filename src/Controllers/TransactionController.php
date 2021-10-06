<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Models\Transaction;
use Brunosribeiro\WalletApi\Services\TransactionServices;
use Error;
use Exception;

class TransactionController
{

    public function __construct()
    {   
        $this->db = new DBConnection(
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    public function addTransactionCredit($params)
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $transaction = new Transaction();
            $transaction->setType('entrada');
            $transaction->setIdUser($params['id_user']);
            $transaction->setValue($params['value']);
            $transactionServices->addTransactionCredit($transaction);
            return json_encode(['success' => 'Transação registrada com sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao adicionar transação de crédito.']);
        } catch (Exception $exception) {
            return json_encode(['exception' => $exception->getMessage()]);
        }
    }

    public function addTransactionDebit($params)
    {
        try{
            $transactionServices = new TransactionServices($this->db);
            $transaction = new Transaction();
            $transaction->setType('saida');
            $transaction->setIdUser($params['id_user']);
            $transaction->setValue($params['value']);
            $transactionServices->addTransactionDebit($transaction);
            return json_encode(['success' => 'Transação registrada com sucesso!']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao adicionar transação de débito.']);
        } catch (Exception $exception) {    
            return json_encode(['exception' => $exception->getMessage()]);
        }
    }
}