# Wallet-api [EM DESENVOLVIMENTO]
API de carteira online em PHP, que registra usuários, transações, e faz consulta de saldo e extrato por período.

## Tecnologias/Ferramentas
- PHP 7.4
- MySQL
- Docker
- PHPUnit - Testes Unitários/Integração
- Codeception - Testes de Rotas

-------------------------------------------------------------------------------------------------------

## Rotas
### USER
- Buscar todos os usuários: GET [/usuarios](http://localhost:9000/usuarios)
- Buscar usuário por ID: GET [/usuario/ID](http://localhost:9000/usuario/1)
- Buscar usuário por Nickname: GET [/usuario/nickname/NICKNAME](http://localhost:9000/usuario/nickname/brunoribeiro)
- Buscar usuário por Nome: GET [/usuario/nome/NOME](http://localhost:9000/usuario/name/bruno)
- Adicionar usuário: POST [/usuario](http://localhost:9000/usuario) - body: {name: 'name', nickname: 'nickname'}
- Editar usuário: POST [/usuario/ID](http://localhost:9000/usuario/1) - body: {name: 'name', nickname: 'nickname'}
- Editar usuário: GET [/usuario/del/ID](http://localhost:9000/usuario/del/2)
- Excluir usuário: DELETE [/usuario/del/ID](http://localhost:9000/usuario/del/2)

### TRANSACTIONS
- Adicionar transação de crédito: POST [/addcredit](http://localhost:9000/addcredit) - body: {id_user: 'id', value: '100.00'}
- Adicionar transação de débito: POST [/adddebit](http://localhost:9000/adddebit) - body: {id_user: 'id', value: '100.00'}

### SALDO
- Consultar saldo: GET [/balance/ID](http://localhost:9000/balance/1)
 -------------------------------------------------------------------------------------------------------

## Configurando Ambiente 
Requisitos
1. <code><img height="20" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/php/php.png"></code> [PHP 7.4](https://www.php.net/downloads.php)
2. <code><img height="20" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/composer/composer.png"></code> [Composer](https://getcomposer.org/download/)
3. <code><img height="20" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/docker/docker.png"></code> [Docker](https://www.docker.com/products/docker-desktop)

-------------------------------------------------------------------------------------------------------

### Execute no terminal 
1.  ```git clone https://github.com/brunosribeiroo/wallet-api.git```
2.  ```cd wallet-api```
3.  ```composer install```
4.  ```docker-compose up --build```

-------------------------------------------------------------------------------------------------------
## Acesso a aplicação
[Wallet-API](http://localhost:9000/)

-------------------------------------------------------------------------------------------------------

## Testes
### Unitários/Integração
Execute no terminal <br />
```./vendor/bin/phpunit --colors ./tests```

### Rotas
Execute no terminal <br />
``` php vendor/bin/codecept run tests/api/```

-------------------------------------------------------------------------------------------------------
### Observação
Acesse a [página inicial](http://localhost:9000/) para carregar o banco de dados.

