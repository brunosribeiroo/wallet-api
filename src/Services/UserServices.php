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
            throw new Error($e);
        }
    }

    public function getUserById($id)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->getUserById($id);
            if($result == null) return 'Usuário não encontrado';
            return json_encode($result);
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function addUser($user)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->addUser($user);
            return $result;
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function getUserByNickname($nick)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->getUserByNickname($nick);
            if($result == null) return 'Usuario nao encontrado';
            return json_encode($result);
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function getUserByName($name)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->getUserByName($name);
            if($result == null) return 'Usuario nao encontrado';
            return json_encode($result);
        } catch (Error $error){
            throw new Error($error);
        }
    }

    public function editUserById($id, $data)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->editUserById($id, $data);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }
}