<?php

namespace Grizzlyware\Ranger\Client;

interface LicenseInterface
{
	// This should accept a string and return a license object
	public static function formWithString($licenseKey);
	public function validateForContext(Context $context);

	public function validateForClient(Client $client);

	public function fetchFingerprint();
	public function storeFingerprint($fingerprintString);
	public function validateFingerprint($fingerprintString); // Return a ValidationResult
}


