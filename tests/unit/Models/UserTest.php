<?php

namespace Brunosribeiro\WalletApi\Test\Services\Models;

require 'vendor/autoload.php';

use Brunosribeiro\WalletApi\Models\User;
use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{

    function testUser()
    {
        $user = new User();
        $user->setName('Teste');
        $user->setNickName('testando');
        $user->setDeleted(0);
        $this->assertEquals('Teste', $user->name);
    }

    function testSetName()
    {
        $user = new User();
        $setName = $user->setName('teste');
        $this->assertEquals(true, $setName);
    }

    function testSetNameComParametroInvalido()
    {
        $user = new User();
        $this->expectExceptionMessage('Nome inválido, é necessário no mínimo 3 caracteres');
        $user->setName('te');
    }

    function testSetNickName()
    {
        $user = new User();
        $setNickName = $user->setNickName('teste');
        $this->assertEquals(true, $setNickName);
    }

    function testSetNickNameComParametroInvalido()
    {
        $user = new User();
        $this->expectExceptionMessage('Nickname inválido, é necessário no mínimo 3 caracteres');
        $user->setNickName('te');
    }

    function testSetDeleted()
    {
        $user = new User();
        $setDel = $user->setDeleted(1);
        echo $user->deleted;
        $this->assertEquals(true, $setDel);
    }

    function testSetDeletedComParametroInvalido()
    {
        $user = new User();
        $this->expectExceptionMessage('Parâmetro inválido ao deletar, informe true ou false');
        $user->setDeleted('teste');
    }

}