<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Services\BalanceServices;
use Error;
use Exception;

class BalanceController
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

    public function getBalanceById($id)
    {
        try{
            $balanceServices = new BalanceServices($this->db);
            $result = $balanceServices->getBalanceById($id);
            return json_encode(['success' => $result]);
        } catch (Error $error){
            return json_encode(['error' => 'Erro ao consultar saldo.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }
}