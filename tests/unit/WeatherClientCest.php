<?php

declare(strict_types=1);

use App\Weather\WeatherClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

final class WeatherClientCest
{
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
