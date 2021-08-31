<?php

require './vendor/autoload.php';
use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Infra\iniciaDB;
$environment = require './environment.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__, $environment);
$dotenv->load();

$iniciaDB = require './scr/Infra/DBInit.php';

$conn = new DBConnection(
    $_ENV['DB_HOST'],
    $_ENV['DB_DATABASE'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

$iniciaDB = new iniciaDB($conn);
$iniciaDB->iniciaDB();

?>
<h1>WalletApi</h1>