<?php

namespace Brunosribeiro\WalletApi\Test\Services\Models;

use Brunosribeiro\WalletApi\Models\Transaction;
use PHPUnit\Framework\TestCase;


class TransactionTest extends TestCase
{
    function testTransaction()
    {
        $transaction = new Transaction();
        $transaction->setUser('Teste');
        $transaction->setType('entrada');
        $transaction->setValue('120.58');
        $this->assertEquals('Teste', $transaction->user);
    }

    function testSetUser()
    {
        $transaction = new Transaction();
        $setUser = $transaction->setUser('Teste');
        $this->assertEquals(true, $setUser);
    }

    function testSetUserComParametroInvalido()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('Usuário inválido');
        $transaction->setUser('te');
    }

    function testSetType()
    {
        $transaction = new Transaction();
        $setType = $transaction->setType('saida');
        $this->assertEquals(true, $setType);
    }

    function testSetTypeComParametroInvalido()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('Tipo de transação inválida');
        $transaction->setType('testando');
    }

    function testSetValue()
    {
        $transaction = new Transaction();
        $setValue = $transaction->setValue('1582.20');
        $this->assertEquals(true, $setValue);
    }

    function testSetValueComParametroInvalido()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('Valor inválido, envie no formato 100.00');
        $transaction->setValue('125.b0');
    }
}