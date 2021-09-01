<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\TransactionRepository;
use PHPUnit\Framework\TestCase;

$environment = require './environment.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();

class TransactionRepositoryTest extends TestCase
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

    function testAddTrasaction()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 100.00
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $result = $transactionRepo->addTransaction($transaction);
        $this->assertEquals(true, $result);
    }

    function testeAddTransactionPassandoValorIncorreto()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 'teste'
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $this->expectExceptionMessage('SQLSTATE[HY000]: General error: 1366 Incorrect decimal value');
        $result = $transactionRepo->addTransaction($transaction);
    }
}