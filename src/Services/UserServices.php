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
            if($result == null) return json_encode(['warning' => 'Usuário não encontrado!']);
            return json_encode($result);
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function addUser($user)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $userRepo->addUser($user);
            return json_encode(['success' => 'Usuário adicionado com sucesso!']);
        } catch (Error $error) {
            throw new Error($error);
        }
    }

    public function getUserByNickname($nick)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->getUserByNickname($nick);
            if($result == null) return json_encode(['warning' => 'Usuário não encontrado!']);
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
            if($result == null) return json_encode(['warning' => 'Usuário não encontrado!']);
            return json_encode($result);
        } catch (Error $error){
            throw new Error($error);
        }
    }

    public function editUserById($id, $user)
    {
        try{
            $user = (array) $user;
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->editUserById($id, $user);
            return $result;
        } catch (Error $error){
            throw new Error($error);
        }
    }

    public function deleteUserById($id)
    {
        try{
            $userRepo = new UserRepository($this->db);
            $result = $userRepo->deleteUserById($id);
            return $result;
        } catch (Error $error) {
            throw new Error($error);
        }
    }
}