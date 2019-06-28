<?php

use PHPUnit\Framework\TestCase;

final class LicenseContextTest extends TestCase
{
	public function testLicenseWithContext()
	{
		// Create the license
		$testLicenseKey = "MyApp-1dSsEwAHEtmmA8b0-Suffix";
		$license = \Grizzlyware\Ranger\Examples\Client\License::formWithString($testLicenseKey);

		// Create a context
		$context = \Grizzlyware\Ranger\Examples\Client\Context::create();

		// Create a license
		$client = \Grizzlyware\Ranger\Ranger::client($context);

		// Validate the license
		$this->assertTrue($client->validateLicense($license));
	}
}

