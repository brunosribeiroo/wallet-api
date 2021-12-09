<?php

class TransactionsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function testAddTransactionCredit(ApiTester $I)
    {
        $transaction = [
            'id_user' => 3,
            'value' => '100.00'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/addcredit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => 'Transação registrada com sucesso!']);
    }

    public function testAddTransactionCreditComIdExcluido(ApiTester $I)
    {
        $transaction = [
            'id_user' => 2,
            'value' => '100.00'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/addcredit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testAddTransactionCreditComIdInexistente(ApiTester $I)
    {
        $transaction = [
            'id_user' => 6544664,
            'value' => '100.00'
        ];
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/addcredit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testAddTransactionDebit(ApiTester $I)
    {
        $transaction = [
            'id_user' => 3,
            'value' => '100.00'
        ];
        $I->sendPost('/adddebit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['success' => 'Transação registrada com sucesso!']);
    }

    public function testAddTransactionDebitComIdExcluido(ApiTester $I)
    {
        $transaction = [
            'id_user' => 2,
            'value' => '50.00'
        ];
        $I->sendPost('/adddebit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testAddTransactionDebitComIdInexistente(ApiTester $I)
    {
        $transaction = [
            'id_user' => 644979,
            'value' => '50.00'
        ];
        $I->sendPost('/adddebit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['warning' => 'Usuário não encontrado']);
    }

    public function testAddTransactionDebitComSaldoInsuficiente(ApiTester $I)
    {
        $transaction = [
            'id_user' => 3,
            'value' => '10000000.00'
        ];
        $I->sendPost('/adddebit', $transaction);
        $I->seeResponseCodeIs(200);
        $I->seeResponseMatchesJsonType(['warning' => 'string']);
    }
}
