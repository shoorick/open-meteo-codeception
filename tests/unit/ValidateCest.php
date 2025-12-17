<?php

declare(strict_types=1);

use \Codeception\Example;
use App\Weather\WeatherClient;
use \GuzzleHttp\Client;

class ValidateCest
{
    private $object;

    public function _before(UnitTester $I): void
    {
        $this->object = new WeatherClient(new Client());
    }

    protected function dataValid(): array
    {
        return [
            ['zero string', '0', '0'],
            ['zero int', 0, 0],
            ['zero float', 0.0, 0.0],
            # Poles
            ['North pole', 90, 0],
            ['South pole', -90, 0],
            # Cities
            ['Belgrade', '44.8', '20.5'], // string
            ['Miass', 55, 60], // int
            ['Moscow', 55.7, 37.6], // float
            ['London', 51.5, -0.1],
            ['Cuenca', -2.9, -79],
            ['Cape Town', -33.9, 18.5],
        ];
    }

    /**
     * @dataProvider dataValid
     */
    public function validRange(UnitTester $I, Example $example): void
    {
        [$name, $latitude, $longitude] = $example;
        $I->assertTrue($this->object->validateInput($latitude, $longitude));
    }

    protected function dataInvalid(): array
    {
        return [
            # Empty
            ['empty', '', ''],
            ['empty latitude', '', '0'],
            ['empty longitude', '0', ''],
            # Non-numeric
            ['non-numeric', 'abc', 'def'],
            ['non-numeric latitude', 'abc', 0],
            ['non-numeric longitude', 0, 'def'],
            # Latitude too big
            ['hundred++', '100', '100'],
            ['hundred-+', '-100', '100'],
            ['hundred+-', '100', '-100'],
            ['hundred--', '-100', '-100'],
            ['hundred int', 100, 100],
            ['hundred float', 100.0, 100.0],
            ['too North', 100, 0],
            ['too South', -100, 0],
            # Longitude too big
            ['too East', 0, 181],
            ['too West', 0, -181],
        ];
    }

    /**
     * @dataProvider dataInvalid
     */
    public function invalidRange(UnitTester $I, Example $example): void
    {
        [$name, $latitude, $longitude] = $example;
        $I->assertFalse($this->object->validateInput($latitude, $longitude));
    }
}
