<?php

use Brunosribeiro\WalletApi\Infra\DBConnection;
$db = require './scr/Infra/DBInit.php';

$conn = new DBConnection(
    'db',
    'wallet',
    'admin',
    'admin'
);

foreach($db as $query){
    $conn->get()->exec($query);
}

?>
<h1>WalletApi</h1>