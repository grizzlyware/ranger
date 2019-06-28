<?php

use PHPUnit\Framework\TestCase;

final class LicenseValidationTest extends TestCase
{
	protected $validLicense;
	protected $invalidLicense;
	protected $nonExistentLicense;

	protected $context;
	protected $client;
	protected $serverConnection;

	protected function setUp()
	{
		$this->context = \Grizzlyware\Ranger\Client\Context::create();
		$this->serverConnection = new \Grizzlyware\Ranger\Examples\Client\ServerConnection();
		$this->client = \Grizzlyware\Ranger\Ranger::client($this->context, $this->serverConnection);

		$this->validLicense = \Grizzlyware\Ranger\Examples\Client\License::formWithString("License-One111One111One");
		$this->invalidLicense = \Grizzlyware\Ranger\Examples\Client\License::formWithString("License-Two222Two222Two");
		$this->nonExistentLicense = \Grizzlyware\Ranger\Examples\Client\License::formWithString("MyInvalidApp-1dSsEwAHEtmmA8b0");
	}

	public function testValidLicensePassesValidation()
	{
		$this->assertTrue($this->client->validateLicense($this->validLicense)->valid);
	}

	public function testInvalidLicenseFailsValidation()
	{
		$this->assertFalse($this->client->validateLicense($this->invalidLicense)->valid);
	}

	public function testNonExistentLicenseFailsValidation()
	{
		$this->assertFalse($this->client->validateLicense($this->nonExistentLicense)->valid);
	}
}

