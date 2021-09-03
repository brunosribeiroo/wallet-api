<?php

use Brunosribeiro\WalletApi\Controllers\UserController;
use Brunosribeiro\WalletApi\Router;
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Infra\iniciaDB;

require __DIR__ . '/vendor/autoload.php';

$environment = require '../environment.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__, $environment);
$dotenv->load();

$iniciaDB = require '../src/Infra/DBInit.php';

$conn = new DBConnection(
    $_ENV['DB_HOST'],
    $_ENV['DB_DATABASE'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

$iniciaDB = new iniciaDB($conn);
$iniciaDB->iniciaDB();

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

$router = new Router($method, $path);

$router->get('/', function () {
    return '<h1>Bem vindo à Wallet-API</h1>';
});

$router->get('/todos-usuarios', function () {
    $conn = new DBConnection(
        $_ENV['DB_HOST'],
        $_ENV['DB_DATABASE'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );
    $userController = new UserController($conn);
    $result = $userController->getAllUsers();
    return $result;
});

$result = $router->handler();

if (!$result) {
    http_response_code(404);
    echo 'Rota não encontrada!';
    die();
}

echo $result();