<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Services\UserServices;

class UserController
{

    public function __construct($db)
    {   
        $this->db = $db;
    }

    public function getAllUsers()
    {
        $userServices = new UserServices($this->db);
        $getUsers = $userServices->getAllUsers();
        return $getUsers;
    }
}