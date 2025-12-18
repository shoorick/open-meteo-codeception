<?php

declare(strict_types=1);

class PageCest
{
    public function formHasElements(AcceptanceTester $I)
    {
        $I->amOnPage('/');

        $I->see('Latitude');
        $I->see('Longitude');
        $I->see('Get weather');

        $I->seeElement('form');
        $I->seeElement('form input[name="latitude"]');
        $I->seeElement('form input[name="longitude"]');
        $I->seeElement('form button[type="submit"]');
    }
}
