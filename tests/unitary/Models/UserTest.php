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
        $this->expectExceptionMessage('Nome inválido');
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
        $this->expectExceptionMessage('Nickname inválido');
        $user->setNickName('te');
    }

}