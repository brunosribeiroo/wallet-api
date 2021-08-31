<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;

class Transaction
{

    public function __construct()
    {
        $this->user = null;
        $this->type = null;
        $this->value = null;
    }

    private function getTypes()
    {
        $types = ['entrada', 'saida'];
        return $types;
    }

    public function setUser($user)
    {
        if(strlen($user) < 3) throw new Error('Usuário inválido');
        $this->user = $user;
        return true;
    }

    public function setType($type)
    {
        $types = $this->getTypes();
        if(!in_array($type, $types)) throw new Error('Tipo de transação inválida');
        $this->type = $type;
        return true;
    }

    public function setValue($value)
    {
        $regex = '/[a-zA-Z]+|,/';
        if(preg_match_all($regex, $value) == 1) throw new Error('Valor inválido, envie no formato 100.00');
        $formattedValue = number_format($value, '2', ',', '');
        $this->value = $formattedValue;
        return true;
    }
}