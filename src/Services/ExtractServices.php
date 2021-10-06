<?php

namespace Brunosribeiro\WalletApi\Services;

use Brunosribeiro\WalletApi\Repository\ExtractRepository;
use Error;
use Exception;

class ExtractServices
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function lastThirtyDays($id)
    {
        try{
            $extractRepo = new ExtractRepository($this->db);
            $initialDate = date('Y-m-d');
            $finalDate = date('Y-m-d', strtotime("-30 days",strtotime($initialDate))); 
            $result = $extractRepo->perPeriod($id, $initialDate, $finalDate);
            if($result == null) throw new Exception('Sem transações registradas no período');
            return json_encode($result);
        } catch (Error $error) {
            throw new Error($error);
        }
    }
}