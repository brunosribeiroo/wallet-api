# Wallet-api 
API de carteira online em PHP, que registra usuários, transações, e faz consulta de saldo, e extrato por período.

## Tecnologias/Ferramentas
- PHP 7.4
- MySQL
- Docker
- PHPUnit - Testes Unitários/Integração
- Codeception - Testes de Rotas

-------------------------------------------------------------------------------------------------------

## Rotas
### USER
- Buscar todos os usuários: GET [/users](http://localhost:9000/users)
- Buscar usuário por ID: GET [/user/ID](http://localhost:9000/user/1)
- Buscar usuário por Nickname: GET [/user/nickname/?nickname=](http://localhost:9000/user/nickname/?nickname=brunoribeiro)
- Buscar usuário por Nome: GET [/user/name/?name=](http://localhost:9000/user/name/?name=bruno)
- Adicionar usuário: POST [/user](http://localhost:9000/user) - body: {name: 'name', nickname: 'nickname'}
- Editar usuário: POST [/user/ID](http://localhost:9000/user/1) - body: {name: 'name', nickname: 'nickname'}
- Excluir usuário: DELETE [/user/del/ID](http://localhost:9000/user/del/2)

### TRANSACTIONS
- Adicionar transação de crédito: POST [/addcredit](http://localhost:9000/addcredit) - body: {id_user: 'id', value: '100.00'}
- Adicionar transação de débito: POST [/adddebit](http://localhost:9000/adddebit) - body: {id_user: 'id', value: '100.00'}

### SALDO
- Consultar saldo: GET [/balance/ID](http://localhost:9000/balance/1)

### EXTRATO
- Consultar extrato últimos dias: GET [/extractlastdays/?id=&days=](http://localhost:9000/extractlastdays/?id=3&days=30)
- Consultar extrato por período: GET [/extractperperiod/?id=&initialDate=&finalDate=](http://localhost:9000/extractperperiod/?id=3&initialDate=01/10/2021&finalDate=30/01/2022)
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
```php ./vendor/bin/phpunit --colors ./tests```

### Rotas
Execute no terminal <br />
``` php vendor/bin/codecept run tests/api/```

-------------------------------------------------------------------------------------------------------
### Observação
Acesse a [página inicial](http://localhost:9000/) para carregar o banco de dados.

