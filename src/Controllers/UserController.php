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
            return json_encode(['error' => 'Erro ao buscar todos os usuários.']);
        }
    }

    public function getUserById($id)
    {   
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserById($id);
            return $getUser;
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por ID.']);
        }
    }

    public function getUserByNickname($nickname)
    {
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserByNickname($nickname);
            return $getUser;
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por nickname.']);
        }
    }

    public function getUserByName($name)
    {
        try{
            $userServices = new UserServices($this->db);
            $getUser = $userServices->getUserByName($name);
            return $getUser;
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao buscar usuário por nome.']);
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
            if(strpos($error, 'tente com mais caracteres')) {
                return json_encode(['warning' => 'Nome ou Nickname muito curto, é necessário no mínimo 3 caracteres.']);
            }
            if(strpos($error, 'Duplicate entry')) {
                return json_encode(['warning' => 'Usuário já cadastrado, tente com outro nickname.']);
            } else {
                return json_encode(['error' => 'Erro ao cadastrar usuário']);
            }
        }
    }

    public function editUser($id, $data)
    {
        try{
            $userServices = new UserServices($this->db);
            $user = new User();
            $user->setName($data['name']);
            $user->setNickName($data['nickname']);
            $userServices->editUserById($id, $user);
            return json_encode(['success' => 'Usuário editado com sucesso']);
        } catch (Error $error) {
            if(strpos($error, 'Duplicate entry')) {
                return json_encode(['warning' => 'Usuário já cadastrado, tente com outro nickname.']);
            } else {
                return json_encode(['error' => 'Erro ao editar usuário']);
            }
        }
    }

    public function deleteUser($id)
    {
        try{
            $userServices = new UserServices($this->db);
            $userServices->deleteUserById($id);
            return json_encode(['success' => 'Usuário excluído com sucesso.']);
        } catch (Error $error) {
            return json_encode(['error' => 'Erro ao excluir usuário.']);
        }
    }
}