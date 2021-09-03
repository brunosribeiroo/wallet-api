<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use PDO;
use PDOException;

class UserRepository
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addUser($user)
    {
        try{
            $query = 'INSERT INTO users (name, nickname, deleted) VALUES (?,?,?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$user['name'], $user['nickname'], $user['deleted']]);
            return true;
        } catch(PDOException $e){
            throw new Error('Erro ao adicionar usuário no DB ' . $e->getMessage());
        }
    }

    public function editUserById($id, $data)
    {
        try{
            $columns = [];
            if (count($data) < 2 ) {
                $columns = implode(',', array_keys($data)) . " = ?";
                $values = array_values($data);
            } else {
                $columns = implode(' = ? , ', array_keys($data));
                $columns = $columns . " = ?";
                $values = array_values($data);
            }
            array_push($values, $id);
            $query = "UPDATE users SET " . $columns . " WHERE id = ?";
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute($values);
            return true;
        } catch(PDOException $e){
                throw new Error('Erro ao editar usuário no DB ' . $e->getMessage());
        }
    }

    public function getAllUsers()
    {
        try{
            $query = 'SELECT id, name, nickname FROM users WHERE deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar todos os usuários no DB ' . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        try{
            $query = 'SELECT id, name, nickname FROM users WHERE id = ? AND deleted = 0';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result == null) return null;
            return $result;
        } catch(PDOException $e){
            throw new Error('Erro ao buscar o usuário por ID no DB ' . $e->getMessage());
        }
    }
}