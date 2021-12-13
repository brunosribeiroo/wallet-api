<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Services\BalanceServices;
use Codeception\PHPUnit\TestCase;
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();

class BalanceServicesTest extends TestCase
{
    public function connection()
    {
        $conn = new DBConnection(
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
        return $conn;
    }

    function testeGetBalanceByid()
    {
        $id = 1;
        $balanceServices = new BalanceServices($this->connection());
        $result = $balanceServices->getBalanceById($id);
        $this->assertEquals('Bruno', $result['name']);
    }

    function testeGetBalanceByidComUsuarioExcluido()
    {
        $id = 2;
        $balanceServices = new BalanceServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $balanceServices->getBalanceById($id);
    }

    function testeGetBalanceByidComIdInexistente()
    {
        $id = 9494948987;
        $balanceServices = new BalanceServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $balanceServices->getBalanceById($id);
    }

    
    function testeGetBalanceByidComSaldoZerado()
    {
        $id = 5;
        $balanceServices = new BalanceServices($this->connection());
        $result = $balanceServices->getBalanceById($id);
        $this->assertEquals('0.00', $result['saldo']);
    }

    function testeGetBalanceByidComSaldoNegativo()
    {
        $id = 6;
        $balanceServices = new BalanceServices($this->connection());
        $result = $balanceServices->getBalanceById($id);
        $this->assertEquals('saldonegativo', $result['nickname']);
    }
}