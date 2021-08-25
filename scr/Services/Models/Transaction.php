<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;

class Transaction
{

    public function __construct()
    {
        $this->user = '';
        $this->type = '';
        $this->value = '';
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
        /* Adicionar a condição de entrada ou retirada, e caso retirada, converter o valor para negativo
        *
        **/
        $formattedValue = number_format($value, '2', ',', '');
        $this->value = $formattedValue;
        return true;
    }
}