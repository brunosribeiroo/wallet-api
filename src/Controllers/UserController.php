<?php

namespace Brunosribeiro\WalletApi\Controllers;

use Brunosribeiro\WalletApi\Infra\DBConnection;
use Brunosribeiro\WalletApi\Models\User;
use Brunosribeiro\WalletApi\Services\UserServices;
use Error;

class UserController
{

    public function __construct()
    {   
        $this->db = new DBConnection(
            $_ENV['DB_HOST'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    public function getAllUsers()
    {
        try{
            $userServices = new UserServices($this->db);
            $getUsers = $userServices->getAllUsers();
            return $getUsers;
        } catch (Error $error) {
            return 'Erro ao buscar todos os usuários.';
        }
    }

    public function getUserById($id)
    {   
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserById($id);
            return $getUser;
        } catch (Error $error) {
            return 'Erro ao buscar usuário por ID.';
        }
    }

    public function getUserByNickname($nickname)
    {
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserByNickname($nickname);
            return $getUser;
        } catch (Error $error) {
            return 'Erro ao buscar usuário por nickname.';
        }
    }

    public function getUserByName($name)
    {
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserByName($name);
            return $getUser;
        } catch (Error $error) {
            return 'Erro ao buscar usuário por nome.';
        }
    }

    public function addUser($params)
    {
        try{
            $userServices = new UserServices($this->db);
            $user = new User();
            $user->setName($params['name']);
            $user->setNickName($params['nickname']);
            $addUser = $userServices->addUser($user);
            return $addUser;
        } catch (Error $error) {
            if(strpos($error, 'Duplicate entry')) {
                return 'Usuário já cadastrado, tente com outro nickname.';
            } else {
                return 'Erro ao cadastrar usuário';
            }
        }
    }

    public function editUser($id, $data)
    {
        try{
            $userServices = new UserServices($this->db);
            $userServices->editUserById($id, $data);
            return 'Usuário editado com sucesso';
        } catch (Error $error) {
            return 'Erro ao editar usuário.';
        }
    }
}