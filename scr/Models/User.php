<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;

class User {

    public function __construct()
    {
        $this->name = '';
        $this->nickName = '';
        $this->deleted = false;
    }

    public function setName($name)
    {
        if(strlen($name) < 3) throw new Error('Nome inválido, tente com mais caractéres');
        $this->name = $name;
        return true;
    }

    public function setNickName($nick)
    {
        if(strlen($nick) < 3) throw new Error('Nickname inválido, tente com mais caractéres');
        $this->nickname = $nick;
        return true;
    }

    public function setDeleted($deleted)
    {
        if($deleted == false || $deleted == 'false' ||$deleted == true || $deleted == 'true'){
            if($deleted == 'false') $deleted = false;
            if($deleted == 'true') $deleted == true;
            $this->deleted = $deleted;
            return true;
        } 
        throw new Error('Parâmetro inválido ao deletar, informe TRUE ou FALSE');
    }

}