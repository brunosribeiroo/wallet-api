<?php

use Brunosribeiro\WalletApi\Helpers\ParamsRandom;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
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
            'name' => 'testando',
            'nickname' => $nickname,
            'deleted' => 0
        ];
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->addUser($user);
        $this->assertEquals(true, $result);
    }

    function testAddUserComNickNameExistente()
    {
        $user = [
            'name' => 'walter',
            'nickname' => 'heisenberg',
            'deleted' => 0
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
        $id = 2;
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

    function testGetAllUsers()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getAllUsers();
        $result = array_key_exists('name', $result[0]);
        $this->assertEquals(true, $result);
    }

    function testGetUserById()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getUserById(1);
        $this->assertArrayHasKey('name', $result);
    }

    function testGetUserByIdComIdInválido()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getUserById(1321651);
        $this->assertNull($result);
    }

    function testGetUserByNickname()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getUserByNickname('heisenberg');
        $this->assertEquals('Heisenberg', $result['nickname']);
    }

    function testGetUserByNicknameComNicknameInexistente()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getUserByNickname('esse nao existe');
        $this->assertNull($result);
    }

    function testGetUserByName()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getUserByName('walter white');
        $this->assertEquals('Walter White', $result[0]['name']);
    }

    function testGetUserByNameComNomeInexistente()
    {
        $userRepo = new UserRepository($this->connection());
        $result = $userRepo->getUserByName('esse nome nao tem');
        $this->assertNull($result);
    }
}