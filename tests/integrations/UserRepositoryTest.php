<?php

use Brunosribeiro\WalletApi\Helpers\ParamsRandom;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
$environment = require './environment.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\\', '.env.test');
$dotenv->load();


class UserRepositoryTest extends TestCase
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
    
    function testAddUser()
    {
        $paramsRandom = new ParamsRandom();
        $nickname = $paramsRandom->stringRandom();
        $user = [
            'name' => 'walter',
            'nickname' => $nickname
        ];
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->addUser($user);
        $this->assertEquals(true, $result);
    }

    function testAddUserComNickNameExistente()
    {
        $user = [
            'name' => 'walter',
            'nickname' => 'white'
        ];
        $userRepo = new UserRepository($this->connection());
        $this->expectExceptionCode(23000);
        $result = $userRepo->addUser($user);
    }
}