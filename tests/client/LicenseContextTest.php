<?php

use PHPUnit\Framework\TestCase;

final class LicenseContextTest extends TestCase
{
	public function testClientWithContext()
	{
		// Create a context
		$context = \Grizzlyware\Ranger\Client\Context::create();
		$serverConnection = new \Grizzlyware\Ranger\Examples\Client\ServerConnection();

		// Create a license
		$client = \Grizzlyware\Ranger\Ranger::client($context, $serverConnection);

		// Validate the license
		$this->assertInstanceOf(\Grizzlyware\Ranger\Client\Client::class, $client);
	}
}

