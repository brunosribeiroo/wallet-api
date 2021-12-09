<?php

namespace Brunosribeiro\WalletApi\Services;

use Brunosribeiro\WalletApi\Repository\ExtractRepository;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use DateTime;
use Error;
use Exception;

class ExtractServices
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function lastThirtyDaysById($id)
    {
        try{
            $extractRepo = new ExtractRepository($this->db);
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->getUserById($id);
            if($user == null) throw new Exception('Usuário não encontrado');
            $finalDate = date('Y-m-d');
            $initialDate = date('Y-m-d', strtotime("-30 days")); 
            $result = $extractRepo->perPeriod($id, $initialDate, $finalDate);
            if($result == null) throw new Exception('Sem transações registradas no período');
            return json_encode($result[0]);
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function perPeriodById($id, $initialDate, $finalDate)
    {
        try{
            $extractRepo = new ExtractRepository($this->db);
            $userRepo = new UserRepository($this->db);
            $user = $userRepo->getUserById($id);
            if($user ==  null) throw new Exception('Usuário não encontrado');
            $initialDate = DateTime::createFromFormat('d/m/Y', $initialDate)->format('Y-m-d 00:00:00');
            $finalDate = DateTime::createFromFormat('d/m/Y', $finalDate)->format('Y-m-d 23:59:59');
            $result = $extractRepo->perPeriod($id, $initialDate, $finalDate);
            if($result == null) throw new Exception('Sem transações registradas no período');
            $sum = $this->sumExtract($result);
            echo $sum;
            return json_encode([ 'transacoes' => $result, 'total' => $sum]);
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    private function sumExtract($transactions)
    {
        $sum = 0;
        foreach ($transactions as $transaction){
            $sum = $sum + $transaction['value'];
        }
        return $sum;
    }
}