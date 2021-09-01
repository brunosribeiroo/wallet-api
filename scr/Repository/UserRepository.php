<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
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
            $query = 'INSERT INTO users (name, nickname) VALUES (?,?)';
            $stmt = $this->db->get()->prepare($query);
            $stmt->execute([$user['name'], $user['nickname']]);
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
}