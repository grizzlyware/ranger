<?php

use PHPUnit\Framework\TestCase;

final class LicenseValidationTest extends TestCase
{
	protected $validLicense;
	protected $invalidLicense;

	protected $context;
	protected $client;
	protected $serverConnection;

	protected function setUp()
	{
		$this->context = \Grizzlyware\Ranger\Examples\Client\Context::create();
		$this->serverConnection = new \Grizzlyware\Ranger\Examples\Client\ServerConnection();
		$this->client = \Grizzlyware\Ranger\Ranger::client($this->context, $this->serverConnection);

		$this->validLicense = \Grizzlyware\Ranger\Examples\Client\License::formWithString("MyValidApp-1dSsEwAHEtmmA8b0");
		$this->invalidLicense = \Grizzlyware\Ranger\Examples\Client\License::formWithString("MyInvalidApp-1dSsEwAHEtmmA8b0");
	}

	public function testLicensePassesValidation()
	{
		$this->assertTrue($this->client->validateLicense($this->validLicense)->valid);
	}

	public function testLicenseFailsValidation()
	{
		$this->assertFalse($this->client->validateLicense($this->invalidLicense)->valid);
	}
}

