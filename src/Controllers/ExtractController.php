<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Services\ExtractServices;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Error;
use Exception;

class ExtractController
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

    public function getLastDaysById($params)
    {
        try{
            $extractServices = new ExtractServices($this->db);
            $result = $extractServices->lastDaysById($params['id'], $params['days']);
            return json_encode(['success' => $result]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao consultar extrato.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }

    public function getPerPeriodById($params)
    {
        try{
            $extractServices = new ExtractServices($this->db);
            $result = $extractServices->perPeriodById($params['id'], $params['initialDate'], $params['finalDate']);
            return json_encode(['success' => $result]);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao consultar extrato.']);
        } catch (Exception $exception) {
            return json_encode(['warning' => $exception->getMessage()]);
        }
    }
}