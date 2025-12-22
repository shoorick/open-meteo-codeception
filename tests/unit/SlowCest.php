<?php

declare(strict_types=1);

namespace Unit;

use \UnitTester;

final class SlowCest
{
    public function waitTenSeconds(UnitTester $I): void
    {
        $I->expect('to wait for 10 seconds');
        $start = microtime(true);
        sleep(10);
        $elapsed = microtime(true) - $start;
        $I->assertGreaterThanOrEqual(10, $elapsed);
        $I->assertLessThanOrEqual(15, $elapsed);
    }
}
