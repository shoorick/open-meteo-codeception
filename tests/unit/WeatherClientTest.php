<?php

declare(strict_types=1);

namespace Tests\unit;

use App\Weather\WeatherClient;
use Codeception\Test\Unit;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

final class WeatherClientTest extends Unit
{
    public function testValidateInputReturnsFalseForEmptyStrings(): void
    {
        $client = new WeatherClient(new Client());

        $this->assertFalse($client->validateInput('', '20'));
        $this->assertFalse($client->validateInput('44', ''));
    }

    public function testValidateInputReturnsFalseForNonNumeric(): void
    {
        $client = new WeatherClient(new Client());

        $this->assertFalse($client->validateInput('abc', '20'));
        $this->assertFalse($client->validateInput('44', 'xyz'));
    }

    public function testValidateInputReturnsFalseForOutOfRange(): void
    {
        $client = new WeatherClient(new Client());

        $this->assertFalse($client->validateInput('181', '0'));
        $this->assertFalse($client->validateInput('-181', '0'));
        $this->assertFalse($client->validateInput('0', '181'));
        $this->assertFalse($client->validateInput('0', '-181'));
    }

    public function testValidateInputReturnsTrueForValidRange(): void
    {
        $client = new WeatherClient(new Client());

        $this->assertTrue($client->validateInput('44', '20'));
        $this->assertTrue($client->validateInput('-180', '180'));
        $this->assertTrue($client->validateInput('180', '-180'));
    }

    public function testSendRequestReturnsDecodedJson(): void
    {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(['ok' => true, 'value' => 123])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handlerStack]);

        $client = new WeatherClient($guzzle);

        $data = $client->sendRequest(44.0, 20.0);

        $this->assertIsArray($data);
        $this->assertSame(true, $data['ok']);
        $this->assertSame(123, $data['value']);
    }
}
