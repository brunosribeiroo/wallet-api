<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Services\UserServices;
use PHPUnit\Framework\TestCase;

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

    function testGetUserByIdPàssandoIDInexistente()
    {
        $userServices = new UserServices($this->connection());
        $result = $userServices->getUserById(74749);
        $this->assertNull($result);
    }
}