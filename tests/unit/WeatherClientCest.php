<?php

declare(strict_types=1);

use App\Weather\WeatherClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

final class WeatherClientCest
{
    public function validateInputReturnsFalseForEmptyStrings(UnitTester $I): void
    {
        $client = new WeatherClient(new Client());

        $I->assertFalse($client->validateInput('', '20'));
        $I->assertFalse($client->validateInput('44', ''));
    }

    public function validateInputReturnsFalseForNonNumeric(UnitTester $I): void
    {
        $client = new WeatherClient(new Client());

        $I->assertFalse($client->validateInput('abc', '20'));
        $I->assertFalse($client->validateInput('44', 'xyz'));
    }

    public function validateInputReturnsFalseForOutOfRange(UnitTester $I): void
    {
        $client = new WeatherClient(new Client());

        $I->assertFalse($client->validateInput('181', '0'));
        $I->assertFalse($client->validateInput('-181', '0'));
        $I->assertFalse($client->validateInput('0', '181'));
        $I->assertFalse($client->validateInput('0', '-181'));
    }

    public function validateInputReturnsTrueForValidRange(UnitTester $I): void
    {
        $client = new WeatherClient(new Client());

        $I->assertTrue($client->validateInput('44', '20'));
        $I->assertTrue($client->validateInput('-180', '180'));
        $I->assertTrue($client->validateInput('180', '-180'));
    }

    public function sendRequestReturnsDecodedJson(UnitTester $I): void
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['ok' => true, 'value' => 123])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handlerStack]);

        $client = new WeatherClient($guzzle);

        $data = $client->sendRequest(44.0, 20.0);

        $I->assertIsArray($data);
        $I->assertSame(true, $data['ok']);
        $I->assertSame(123, $data['value']);
    }
}
