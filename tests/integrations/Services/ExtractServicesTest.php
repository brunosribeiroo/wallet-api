<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Services\ExtractServices;
use PHPUnit\Framework\TestCase;
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();

class ExtractServicesTest extends TestCase
{
    private function connection()
    {
        $conn = new DBConnection(
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
        return $conn;
    }

    function testeLastDaysById()
    {
        $id = 3;
        $days = 30;
        $extractServices = new ExtractServices($this->connection());
        $result = $extractServices->lastDaysById($id, $days);
        $result = json_decode($result, true);
        $this->assertEquals('Walter White', $result['transacoes'][0]['name']);
    }

    function testeLastDaysByIdComIDExcluido()
    {
        $id = 2;
        $days = 30;
        $extractServices = new ExtractServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $extractServices->lastDaysById($id, $days);
    }

    function testeLastDaysByIdComIDInexistente()
    {
        $id = 56444464;
        $days = 30;
        $extractServices = new ExtractServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $extractServices->lastDaysById($id, $days);
    }

    function testePerPeriodById()
    {
        $id = 3;
        $finalDate = date('d/m/Y');
        $initialDate = date('d/m/Y', strtotime("-30 days"));
        $extractServices = new ExtractServices($this->connection());
        $result = $extractServices->perPeriodById($id, $initialDate, $finalDate);
        $result = json_decode($result, true);
        $this->assertEquals('Walter White', $result['transacoes'][0]['name']); 
    }

    function testePerPeriodByIdComIdExcluido()
    {
        $id = 2;
        $finalDate = date('d/m/Y');
        $initialDate = date('d/m/Y', strtotime("-30 days"));
        $extractServices = new ExtractServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $extractServices->perPeriodById($id, $initialDate, $finalDate);
    }

    function testePerPeriodByIdComIdInexistente()
    {
        $id = 655644654;
        $finalDate = date('d/m/Y');
        $initialDate = date('d/m/Y', strtotime("-30 days"));
        $extractServices = new ExtractServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $extractServices->perPeriodById($id, $initialDate, $finalDate);
    }
}