<?php

namespace Brunosribeiro\WalletApi\Helpers;

use Error;

class ParamsRandom{

    public function stringRandom($lenght = 10)
    {
        if($lenght <= 0) throw new Error('Parâmetro inválido');
        $letters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lettersLength = strlen($letters);
        $randomString = '';
        for ($i = 0; $i < $lenght; $i++){
            $randomString .=    $letters[rand(0, $lettersLength - 1)];
        }
        return $randomString;
    }
}