<?php

use Brunosribeiro\WalletApi\Controllers\BalanceController;
use Brunosribeiro\WalletApi\Controllers\TransactionController;
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

$router->get('/usuarios', function () {
    $userController = new UserController();
    $result = $userController->getAllUsers();
    return $result;
});

$router->get('/usuario/{id}', function ($params) {
    $id = $params[1];
    $userController = new UserController();
    $result = $userController->getUserById($id);
    return $result;
});

$router->get('/usuario/nickname/{nickname}', function ($params) {
    $nickname = $params[1];
    $userController = new UserController();
    $result = $userController->getUserByNickname($nickname);
    return $result;
});

$router->get('/usuario/nome/{name}', function ($params) {
    $name = $params[1];
    $userController = new UserController();
    $result = $userController->getUserByName($name);
    return $result;
});

$router->post('/usuario', function () {
    $params = $_POST;
    $userController = new UserController();
    $result = $userController->addUser($params);
    return $result;
});

$router->post('/usuario/{id}', function ($params) {
    $id = $params[1];
    $data = $_POST;
    $userController = new UserController();
    $result = $userController->editUser($id, $data);
    return $result;
});

$router->delete('/usuario/del/{id}', function ($params) {
    $id = $params[1];
    $userController = new UserController();
    $result = $userController->deleteUser($id);
    return $result;
});

$router->post('/addcredit', function () {
    $data = $_POST;
    $transactionController = new TransactionController();
    $result = $transactionController->addTransactionCredit($data);
    return $result;
});

$router->post('/adddebit', function () {
    $data = $_POST;
    $transactionController = new TransactionController();
    $result = $transactionController->addTransactionDebit($data);
    return $result;
});

$router->get('/balance/{id}', function ($params) {
    $id = $params[1];
    $balanceController = new BalanceController();
    $result = $balanceController->getBalanceById($id);
    return $result;
});


$result = $router->handler();

if (!$result) {
    http_response_code(404);
    echo 'Rota não encontrada!';
    die();
}

echo $result($router->getParams());
// echo $result();