<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    function testCreateTable()
    {
        $conn = new DBConnection(
            'localhost:3306',
            'wallet',
            'admin',
            'admin'
        );
        $userRepo = new UserRepository($conn->get());
        $create = $userRepo->createTable();
        $this->assertEquals(true, $create);
    }
}