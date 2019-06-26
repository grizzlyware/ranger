<?php

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{
	public function testRangerClientInstanceIsReturned()
	{
		// Create the mock instances
		$license = $this->getMockBuilder(\Grizzlyware\Ranger\Client\License::class)->getMock();
		$context = $this->getMockBuilder(\Grizzlyware\Ranger\Client\Context::class)->getMock();

		// Create the client
		$client = \Grizzlyware\Ranger\Ranger::client($license, $context);

		// Test
		$this->assertTrue($client instanceof \Grizzlyware\Ranger\Client\Client);
	}
}

