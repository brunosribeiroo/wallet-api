<?php

use Brunosribeiro\WalletApi\Helpers\ParamsRandom;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
$environment = require './environment.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
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
        $this->expectExceptionMessage('Erro ao adicionar usuário no DB SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry');
        $userRepo->addUser($user);
    }

    function testEditUserByIdComUmParametro()
    {
        $data = [
            'deleted' => 1
        ];
        $id = 1;
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->editUserById($id, $data);
        $this->assertEquals(true, $result);
    }

    function testEditUserByIdComMaisDeUmParametro()
    {
        $data = [
            'name' => 'Patrick Jane',
            'deleted' => 1
        ];
        $id = 2;
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->editUserById($id, $data);
        $this->assertEquals(true, $result);
    }

    function testEditUserByIdPassandoNickNameExistente()
    {
        $data = [
            'nickname' => 'brunoribeiro'
        ];
        $id = 2;
        $userRepo = new UserRepository($this->connection());
        $this->expectExceptionMessage('Erro ao editar usuário no DB SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry');
        $userRepo->editUserById($id, $data);
    }
}