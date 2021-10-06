<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use PHPUnit\Framework\TestCase;
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();
use Brunosribeiro\WalletApi\Services\TransactionServices;

class TransactionServicesTest extends TestCase
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

    function testAddTransactionCredit()
    {
        $transaction = (object) [
            'id_user' => 3,
            'type' => 'entrada',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $result = $transactionServices->addTransactionCredit($transaction);
        $this->assertEquals(true, $result);
    }

    function testeAddTransactionCreditComUsuarioDeletado()
    {
        $transaction = (object) [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $transactionServices->addTransactionCredit($transaction);
    }

    function testeAddTransactionCreditPassandoValorIncorreto()
    {
        $transaction = (object) [
            'id_user' => 3,
            'type' => 'entrada',
            'value' => 'teste'
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectErrorMessage('SQLSTATE[HY000]: General error: 1366 Incorrect decimal value');
        $transactionServices->addTransactionCredit($transaction);
    }

    function testeAddTransactionCreditPassandoKeyIncorreta()
    {
        $transaction = (object) [
            'id_user' => 3,
            'type' => 'entrada',
            'teste' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectError();
        $transactionServices->addTransactionCredit($transaction);
    }

    function testAddTransactionDebit()
    {
        $transaction = (object) [
            'id_user' => 3,
            'type' => 'saida',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $result = $transactionServices->addTransactionDebit($transaction);
        echo $result;
        $this->assertEquals(true, $result);
    }

    
    function testeAddTransactionDebitComUsuarioDeletado()
    {
        $transaction = (object) [
            'id_user' => 2,
            'type' => 'saida',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('Usuário não encontrado');
        $transactionServices->addTransactionDebit($transaction);
    }

    function testeAddTransactionDebitPassandoKeyIncorreta()
    {
        $transaction = (object) [
            'id_user' => 3,
            'type' => 'saida',
            'teste' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectError();
        $transactionServices->addTransactionDebit($transaction);
    }

    function testAddTransactionDebitComSaldoInsuficiente()
    {
        $transaction = (object) [
            'id_user' => 1,
            'type' => 'saida',
            'value' => 900.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('Transação negada! Seu saldo é insuficiente para essa transação. Saldo atual:');
        $transactionServices->addTransactionDebit($transaction);
    }
}