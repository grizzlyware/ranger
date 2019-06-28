<?php

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{
	public function testRangerClientInstanceIsReturned()
	{
		// Create the mock instances
		$context = \Grizzlyware\Ranger\Examples\Client\Context::create();

		// Create the client
		$client = \Grizzlyware\Ranger\Ranger::client($context);

		// Test
		$this->assertInstanceOf(\Grizzlyware\Ranger\Client\Client::class, $client);
	}

	public function testRangerServerInstanceIsReturned()
	{
		// Create the client
		$server = \Grizzlyware\Ranger\Ranger::server();

		// Test
		$this->assertTrue($server instanceof \Grizzlyware\Ranger\Server\Server);
	}
}

