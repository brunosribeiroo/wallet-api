<?php

class BalanceCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testGetBalanceById(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/balance/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType(['success' => 'string']);
    }

    public function testGetBalanceByIdComIdInexistente(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/balance/646464654');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testGetBalanceByIdComIdExcluido(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/balance/2');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testGetBalanceByIdComSaldoNegativo(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/balance/6');
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType(['success' => 'string']);
    }

    public function testGetBalanceByIdComSaldoZerado(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/balance/5');
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType(['success' => 'string']);
    }
}