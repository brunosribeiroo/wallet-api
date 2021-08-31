<?php

namespace Brunosribeiro\WalletApi\Repository;

use Error;
use Exception;

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
            throw new Error('Errro ao adicionar usuário no DB ' . $e->getMessage());
        }
    }
}