<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\BalanceRepository;
use PHPUnit\Framework\TestCase;
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();

class BalanceRepositoryTest extends TestCase
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

    function testGetBalanceById()
    {  
        $balanceRepo = new BalanceRepository($this->connection());
        $id = 1;
        $result = $balanceRepo->getBalanceById($id);
        $this->assertNotEmpty($result['name']);
    }

    function testGetBalanceByIdComIdInexistente()
    {
        $balanceRepo = new BalanceRepository($this->connection());
        $id = 646489;
        $result = $balanceRepo->getBalanceById($id);
        $this->assertEmpty($result);
    }

    function testGetBalanceByIdComIdExcluido()
    {
        $balanceRepo = new BalanceRepository($this->connection());
        $id = 2;
        $result = $balanceRepo->getBalanceById($id);
        $this->assertEmpty($result);
    }
}