<?php

use Brunosribeiro\WalletApi\Helpers\ParamsRandom;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Services\UserServices;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'\..\..\..\\', '.env.test');
$dotenv->load();


class UserServicesTest extends TestCase
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

    function testGetAllUsers()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getAllUsers();
        $result = json_decode($result, true);
        $this->assertArrayHasKey('name', $result[0]);
    }

    function testGetUserById()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserById(1);
        $this->assertJsonStringEqualsJsonString('{"id":"1","name":"Bruno","nickname":"brunoribeiro"}', $result);
    }

    function testGetUserByIdPassandoIDInexistente()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserById(74749);
        $result = json_decode($result, true);
        $this->assertEquals('Usuário não encontrado!', $result['warning']);
    }

    function testAddUser()
    {
        $paramsRandom = new ParamsRandom();
        $nickname = $paramsRandom->stringRandom();
        $user = (object) [
            'name' => 'testando',
            'nickname' => $nickname,
            'deleted' => 0
        ];
        $userServices = new UserServices($this->connection());
        $result = $userServices->addUser($user);
        $result = json_decode($result, true);
        $this->assertEquals('Usuário adicionado com sucesso!', $result['success']);
    }

    function testAddUserPassandoNicknameExistente()
    {
        $user = (object) [
            'name' => 'testando',
            'nickname' => 'batman',
            'deleted' => 0
        ];
        $userServices = new UserServices($this->connection());
        $this->expectErrorMessage('Erro ao adicionar usuário no DB');
        $userServices->addUser($user);
    }

    function testGetUserByNickname()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserByNickname('heisenberg');
        $result = json_decode($result, true);
        $this->assertEquals('Heisenberg', $result['nickname']);
    }

    function testGetUserByNicknameComNicknameInexistente()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserByNickname('esse nao tem');
        $result = json_decode($result, true);
        $this->assertEquals('Usuário não encontrado!', $result['warning']);
    }

    function testGetUserByName()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserByName('walter white');
        $result = json_decode($result, true);
        $this->assertEquals('Walter White', $result[0]['name']);
    }

    function testGetUserByNameComNomeInexistente()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserByName('esse nao tem');
        $result = json_decode($result, true);
        $this->assertEquals('Usuário não encontrado!', $result['warning']);
    }

    function testEditUserByIdComUmParametro()
    {
        $data = (object) [
            'deleted' => 1
        ];
        $id = 2;
        $userServices = new UserServices($this->connection());
        $result = $userServices->editUserById($id, $data);
        $this->assertEquals(true, $result);
    }

    function testEditUserByIdComMaisDeUmParametro()
    {
        $data = (object) [
            'name' => 'Patrick Jane',
            'deleted' => 1
        ];
        $id = 2;
        $userServices = new UserServices($this->connection());
        $result = $userServices->editUserById($id, $data);
        $this->assertEquals(true, $result);
    }

    function testEditUserByIdPassandoNickNameExistente()
    {
        $data = (object) [
            'nickname' => 'brunoribeiro'
        ];
        $id = 2;
        $userServices = new UserServices($this->connection());
        $this->expectExceptionMessage('Erro ao editar usuário no DB SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry');
        $userServices->editUserById($id, $data);
    }

    function testeDeleteUserById()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->deleteUserById(2);
        $this->assertEquals(true, $result);
    }
}