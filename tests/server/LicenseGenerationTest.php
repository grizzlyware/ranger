<?php

use PHPUnit\Framework\TestCase;

final class LicenseGenerationTest extends TestCase
{
	public function testLicenseGenerator()
	{
		$licenseStore = new \Grizzlyware\Ranger\Examples\Server\Store();
		$generator = new \Grizzlyware\Ranger\Server\License\Generator($licenseStore);

		$generatedKey = $generator->getKey();

		$this->assertIsString($generatedKey);
		$this->assertNotNull($generatedKey);
	}

	public function testLicenseGeneratorKeyLengths()
	{
		$licenseStore = new \Grizzlyware\Ranger\Examples\Server\Store();

		for($testLength = 1; $testLength <= 60; $testLength+=10)
		{
			$generator = new \Grizzlyware\Ranger\Server\License\Generator($licenseStore,
				[
					"key" =>
						[
							"length" => $testLength
						]
				]);

			$generatedKey = $generator->getKey();

			$this->assertTrue(strlen($generatedKey) === $testLength);
		}
	}

	public function testLicenseGeneratorPrefixAndSuffix()
	{
		$licenseStore = new \Grizzlyware\Ranger\Examples\Server\Store();
		$generator = new \Grizzlyware\Ranger\Server\License\Generator($licenseStore,
		[
			"key" =>
				[
					"length" => 30,
					"prefix" => 'TESTPREFIX',
					"suffix" => 'TESTSUFFIX'
				]
		]);

		$generatedKey = $generator->getKey();

		$this->assertTrue(\Illuminate\Support\Str::startsWith($generatedKey, 'TESTPREFIX'));
		$this->assertTrue(\Illuminate\Support\Str::endsWith($generatedKey, 'TESTSUFFIX'));
	}

	public function testLicenseStoreGeneratesKey()
	{
		$licenseStore = new \Grizzlyware\Ranger\Examples\Server\Store();

		$generatedKey = $licenseStore->generator()->getKey();

		$this->assertTrue(strlen($generatedKey) > 0);
		$this->assertIsString($generatedKey);
		$this->assertNotNull($generatedKey);
	}
}

