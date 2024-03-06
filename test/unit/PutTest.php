<?php

declare(strict_types=1);

namespace Nap\Tests\Sanitize;

use PHPUnit\Framework\TestCase;
use HttpClient\Put;

class PutTest extends TestCase {

    public function testMethod(): void
    {
        $client = new Put('localhost:18080');

        $response = $client->sendJson(null, null);

        $this->assertTrue($response['success']);

        $response = $response['result'];

        $this->assertSame($response['method'], 'PUT');
    }

    public function testParams(): void
    {
        $client = new Put('localhost:18080?param1=hello');

        $response = $client->sendJson(null, null);

        $response = $response['result'];

        $this->assertIsArray($response['get_params']);

        $this->assertArrayHasKey('param1', $response['get_params']);

        $this->assertSame($response['get_params']['param1'], 'hello');
    }

    public function testForm(): void
    {
        $client = new Put('localhost:18080');

        $response = $client->sendForm(null, ['param1' => 'hello']);

        $response = json_decode($response['result'], true);

        $dummy = explode('=', $response['body']);

        $this->assertIsArray($dummy);

        $this->assertSame($dummy[0], 'param1');

        $this->assertSame($dummy[1], 'hello');
    }

    public function testJson(): void
    {
        $client = new Put('localhost:18080');

        $response = $client->sendJson(null, ['param1' => 'hello']);

        $response = $response['result'];

        $response = json_decode($response['body'], true);

        $this->assertIsArray($response);

        $this->assertArrayHasKey('param1', $response);

        $this->assertSame($response['param1'], 'hello');
    }
}
