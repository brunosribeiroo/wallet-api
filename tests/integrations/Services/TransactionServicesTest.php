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
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $result = $transactionServices->addTransactionCredit($transaction);
        $this->assertEquals(true, $result);
    }

    function testeAddTransactionCreditPassandoValorIncorreto()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 'teste'
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('SQLSTATE[HY000]: General error: 1366 Incorrect decimal value');
        $transactionServices->addTransactionCredit($transaction);
    }

    function testeAddTransactionCreditPassandoKeyIncorreta()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'teste' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectError();
        $transactionServices->addTransactionCredit($transaction);
    }

    function testeAddTransactionCreditPassandoTipoIncorreto()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'saida',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('Tipo de transação incorreta');
        $transactionServices->addTransactionCredit($transaction);
    }

    function testAddTransactionDebit()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'saida',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $result = $transactionServices->addTransactionDebit($transaction);
        $this->assertEquals(true, $result);
    }

    function testeAddTransactionDebitPassandoKeyIncorreta()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'saida',
            'teste' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectError();
        $transactionServices->addTransactionDebit($transaction);
    }

    function testeAddTransactionDebitPassandoTipoIncorreto()
    {
        $transaction = [
            'id_user' => 2,
            'type' => 'entrada',
            'value' => 100.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('Tipo de transação incorreta');
        $transactionServices->addTransactionDebit($transaction);
    }

    function testAddTransactionDebitComSaldoInsuficiente()
    {
        $transaction = [
            'id_user' => 1,
            'type' => 'saida',
            'value' => 900.00
        ];
        $transactionServices = new TransactionServices($this->connection());
        $this->expectExceptionMessage('Transação negada! Seu saldo é insuficiente para essa transação. Saldo atual:');
        $transactionServices->addTransactionDebit($transaction);
    }
}