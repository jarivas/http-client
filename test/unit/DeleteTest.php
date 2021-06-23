<?php

declare(strict_types=1);

namespace Nap\Tests\Sanitize;

use PHPUnit\Framework\TestCase;
use HttpClient\Delete;

class DeleteTest extends TestCase {

    public function testMethod(): void
    {
        $client = new Delete('localhost:8080');

        $response = $client->send(null, null, true);

        $this->assertTrue($response['success']);

        $response = $response['result'];

        $this->assertSame($response['method'], 'DELETE');
    }

    public function testParams(): void
    {
        $client = new Delete('localhost:8080?param1=hello');

        $response = $client->send(null, null, true);

        $this->assertTrue($response['success']);

        $response = $response['result'];

        $this->assertIsArray($response['get_params']);

        $this->assertArrayHasKey('param1', $response['get_params']);

        $this->assertSame($response['get_params']['param1'], 'hello');
    }
}
