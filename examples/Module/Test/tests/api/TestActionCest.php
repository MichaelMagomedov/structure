<?php


class TestActionCest
{
    public function tryToTest(ApiTester $I)
    {
        $I->sendGET('/');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }
}
