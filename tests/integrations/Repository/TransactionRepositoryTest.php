<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\TransactionRepository;
use PHPUnit\Framework\TestCase;
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

    function testAddTrasactionCredit()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 100.00
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $result = $transactionRepo->addTransactionCredit($transaction);
        $this->assertEquals(true, $result);
    }

    function testAddTransactionCreditPassandoValorIncorreto()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 'teste'
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $this->expectExceptionMessage('SQLSTATE[HY000]: General error: 1366 Incorrect decimal value');
        $transactionRepo->addTransactionCredit($transaction);
    }

    function testAddTransactionCreditPassandoKeyIncorreta()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'teste' => 100.00
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $this->expectError();
        $transactionRepo->addTransactionCredit($transaction);
    }

    function testAddTrasactionDebit()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'saida',
            'value' => 100.00
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $result = $transactionRepo->addTransactionDebit($transaction);
        $this->assertEquals(true, $result);
    }

    function testAddTransactionDebitPassandoValorIncorreto()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'saida',
            'value' => 'teste'
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $this->expectExceptionMessage('SQLSTATE[HY000]: General error: 1366 Incorrect decimal value');
        $transactionRepo->addTransactionDebit($transaction);
    }

    function testAddTransactionDebitPassandoKeyIncorreta()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'saida',
            'teste' => 100.00
        ];
        $transactionRepo = new TransactionRepository($this->connection());
        $this->expectError();
        $transactionRepo->addTransactionDebit($transaction);
    }

    function testGetBalanceById()
    {
        $transactionRepo = new TransactionRepository($this->connection());
        $id = 1;
        $result = $transactionRepo->getBalanceById($id);
        $this->assertNotEmpty($result['name']);
    }

    function testGetBalanceByIdComIdInexistente()
    {
        $transactionRepo = new TransactionRepository($this->connection());
        $id = 646489;
        $result = $transactionRepo->getBalanceById($id);
        $this->assertEmpty($result['name']);
    }
}