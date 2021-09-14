<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;

class User {

    public function __construct()
    {
        $this->name = '';
        $this->nickName = '';
        $this->deleted = 0;
    }

    public function setName($name)
    {
        if(strlen($name) < 3) throw new Error('Nome inválido, tente com mais caracteres');
        $this->name = $name;
        return true;
    }

    public function setNickName($nick)
    {
        if(strlen($nick) < 3) throw new Error('Nickname inválido, tente com mais caracteres');
        $this->nickname = $nick;
        return true;
    }

    public function setDeleted($deleted)
    {
        if ($deleted == 0 || $deleted == 1) {
            $this->deleted = $deleted;
            return true;
        } else {
            throw new Error('Parâmetro inválido ao deletar, informe true ou false');
        }
    }

}