<?php

namespace Brunosribeiro\WalletApi\Models;

use Error;

class User {

    public function __construct()
    {
        $this->name = '';
        $this->nickName = '';
    }

    public function setName($name)
    {
        if(strlen($name) < 3) throw new Error('Nome inválido');
        $this->name = $name;
        return true;
    }

    public function setNickName($nick)
    {
        if(strlen($nick) < 3) throw new Error('Nickname inválido');
        $this->nickname = $nick;
        return true;
    }

}