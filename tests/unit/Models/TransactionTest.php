<?php

namespace Brunosribeiro\WalletApi\Test\Services\Models;

use Brunosribeiro\WalletApi\Models\Transaction;
use PHPUnit\Framework\TestCase;


class TransactionTest extends TestCase
{
    function testTransaction()
    {
        $transaction = new Transaction();
        $transaction->setIdUser('1');
        $transaction->setType('entrada');
        $transaction->setValue('120.58');
        $this->assertEquals('1', $transaction->id_user);
    }

    function testSetUser()
    {
        $transaction = new Transaction();
        $setUser = $transaction->setIdUser('1');
        $this->assertEquals(true, $setUser);
    }

    function testSetUserComParametroInvalido()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('ID do usuário inválido');
        $transaction->setIdUser('te');
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
        $setValue = $transaction->setValue('100.00');
        $this->assertEquals(true, $setValue);
    }

    function testSetValueComParametroInvalido()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('Valor inválido, insira no formato 100.00');
        $transaction->setValue('125.b0');
    }

    function testSetValueComParametroNegativo()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('Valor inválido, insira no formato 100.00');
        $transaction->setValue('-125.00');
    }

    function testSetValueComParametroZerado()
    {
        $transaction = new Transaction();
        $this->expectExceptionMessage('Valor inválido, insira um valor maior que 0');
        $transaction->setValue('0');
    }
}