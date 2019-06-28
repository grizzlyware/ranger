<?php

use PHPUnit\Framework\TestCase;

final class LicenseFormationTest extends TestCase
{
	public function testLicenseCanBeFormedFromString()
	{
		$testLicenseKey = "MyApp-1dSsEwAHEtmmA8b0-Suffix";
		$license = \Grizzlyware\Ranger\Examples\Client\License::formWithString($testLicenseKey);

		$this->assertInstanceOf(\Grizzlyware\Ranger\Client\License::class, $license);
	}
}

