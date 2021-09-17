<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;
use Exception;

class Transaction
{

    public function __construct()
    {
        $this->id_user = null;
        $this->type = null;
        $this->value = null;
    }

    private function getTypes()
    {
        $types = ['entrada', 'saida'];
        return $types;
    }

    public function setIdUser($id)
    {
        if(!is_numeric($id)) throw new Exception('ID do usuário inválido');
        $this->id_user = $id;
        return true;
    }

    public function setType($type)
    {
        $types = $this->getTypes();
        if(!in_array($type, $types)) throw new Exception('Tipo de transação inválida');
        $this->type = $type;
        return true;
    }

    public function setValue($value)
    {
        $regex = '/[a-zA-Z-+]+|,/';
        if(preg_match_all($regex, $value) == 1) throw new Exception('Valor inválido, insira no formato 100.00');
        if($value <= 0) throw new Exception('Valor inválido, insira um valor maior que 0');
        $formattedValue = number_format($value, '2', '.', '');
        $this->value = $formattedValue;
        return true;
    }
}