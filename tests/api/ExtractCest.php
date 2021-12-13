<?php

class ExtractCest{

    public function _before(ApiTester $I)
    {
    }

    public function testeGetLastDaysById(ApiTester $I)
    {
        //url = /extractlastdays/?id&days
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/extractlastdays/?id=3&days=30');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testeGetLastDaysByIdComIDExcluido(ApiTester $I)
    {
        //url = /extractlastdays/?id&days
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/extractlastdays/?id=2&days=30');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testeGetLastDaysByIdComIDInexistente(ApiTester $I)
    {
        //url = /extractlastdays/?id&days
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/extractlastdays/?id=6465464654&days=30');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testeGetPerPeriodById(ApiTester $I)
    {
        //url = /extractperperiod/?id&initalDate&finalDate
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/extractperperiod/?id=3&initialDate=01/10/2021&finalDate=30/01/2022');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function testeGetPerPeriodByIdComIDExcluido(ApiTester $I)
    {
        //url = /extractlastdays/?id&days
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/extractperperiod/?id=2&initialDate=01/10/2021&finalDate=30/01/2022');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testeGetPerPeriodByIdComIDInexistente(ApiTester $I)
    {
        //url = /extractlastdays/?id&days
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGet('/extractperperiod/?id=65456464&initialDate=01/10/2021&finalDate=30/01/2022');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }
}