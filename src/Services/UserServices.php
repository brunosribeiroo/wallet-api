<?php

namespace Brunosribeiro\WalletApi\Services;

use Brunosribeiro\WalletApi\Repository\UserRepository;
use Error;

class UserServices
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllUsers()
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->getAllUsers();
            return json_encode($result);
        } catch (Error $e) {
            throw new Error('Erro ao buscar todos usuários em Services ' . $e);
        }
    }

    public function getUserById($id)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->getUserById($id);
            if($result == null) return null;
            return json_encode($result);
        } catch (Error $e) {
            throw new Error('Erro ao buscar o usuário por ID em Services ' . $e);
        }
    }

    public function addUser($user)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->addUser($user);
            return $result;
        } catch (Error $e) {
            throw new Error('Erro ao adicionar usuário em Services ' . $e);
        }
    }
}