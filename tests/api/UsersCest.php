<?php

use Brunosribeiro\WalletApi\Helpers\ParamsRandom;

class UsersCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testGetAllUsers(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/users');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => ['id' => 1]]);
    }

    public function testGetUserById(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/user/1');
        $I->seeResponseCodeIs(200); 
        $I->seeResponseContainsJson(['success' => ['id' => '1']]);
    }

    public function testGetUserByIdComIdInexistente(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/user/64449464');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testGetUserByNickname(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/user/nickname/?nickname=brunoribeiro');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => ['id' => '1']]);
    }

    public function testGetUserByNicknameComNicknameInexistente(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/user/nickname/?nickname=testenickname');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testGetUserByName(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/user/name/?name=bruno');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => ['id' => '1']]);
    }

    public function testGetUserByNameComNomeInexistente(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/user/name/?name=testederotas');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testAddUser(ApiTester $I)
    {
        $paramsRandom = new ParamsRandom();
        $nickname = $paramsRandom->stringRandom();
        $user = [
            'name' => 'teste api', 
            'nickname' => $nickname
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => 'Usuário adicionado com sucesso']);
    }

    public function testAddUserNomeComPoucosCaracteres(ApiTester $I)
    {
        $paramsRandom = new ParamsRandom();
        $nickname = $paramsRandom->stringRandom();
        $user = [
            'name' => 'ab', 
            'nickname' => $nickname
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Nome inválido, é necessário no mínimo 3 caracteres']);
    }

    public function testAddUserComNicknameComPoucosCaracteres(ApiTester $I)
    {
        $paramsRandom = new ParamsRandom();
        $user = [
            'name' => 'teste api', 
            'nickname' => 'ab'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Nickname inválido, é necessário no mínimo 3 caracteres']);
    }

    public function testAddUserComNicknameCadastrado(ApiTester $I)
    {
        $user = [
            'name' => 'teste api', 
            'nickname' => 'brunoribeiro'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário já cadastrado, tente com outro nickname.']);
    }

    public function testEditUser(ApiTester $I)
    {
        $paramsRandom = new ParamsRandom();
        $nickname = $paramsRandom->stringRandom();
        $user = [
            'name' => 'teste api edit user', 
            'nickname' => $nickname
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user/4', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => 'Usuário editado com sucesso']);
    }

    public function testEditUserComNicknameExistente(ApiTester $I)
    {
        $user = [
            'name' => 'teste api edit user', 
            'nickname' => 'brunoribeiro'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user/4', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário já cadastrado, tente com outro nickname.']);
    }

    public function testEditUserComNomeComPoucosCaracteres(ApiTester $I)
    {
        $user = [
            'name' => 'ab', 
            'nickname' => 'teste'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user/4', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Nome inválido, é necessário no mínimo 3 caracteres']);
    }

    public function testEditUserComNicknameComPoucosCaracteres(ApiTester $I)
    {
        $user = [
            'name' => 'teste api edit user', 
            'nickname' => 'ab'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/user/4', $user);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Nickname inválido, é necessário no mínimo 3 caracteres']);
    }

    public function testDeleteUser(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendDelete('/user/del/2');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => 'Usuário excluído com sucesso.']);
    }
}
