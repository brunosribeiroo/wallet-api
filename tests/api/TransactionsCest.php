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
        $I->seeResponseContainsJson(['exception' => 'Usuário não encontrado.']);
    }
}
