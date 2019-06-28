<?php

namespace Grizzlyware\Ranger\Server;

use Grizzlyware\Ranger\Server\Exceptions\LicenseNotFoundException;
use Grizzlyware\Ranger\Server\License\ValidationResult;
use Grizzlyware\Ranger\Shared\CanHandlePackagedPayloads;

abstract class ClientConnection implements ClientConnectionInterface
{
	use CanHandlePackagedPayloads;

	protected $store;

	public function __construct()
	{
		$this->initialiseDataStore();
	}

	public function findLicense($licensePayload)
	{
		return $this->store->findLicenseByPayload($licensePayload);
	}

	public function handleRequest($payload)
	{
		// Unpack the payload
		$unpackedPayload = $this->unpackPayload($payload);

		try
		{
			// Find the license
			$foundLicense = $this->findLicense($unpackedPayload->client_license);
		}
		catch(LicenseNotFoundException $e)
		{
			// License not found..
			return ValidationResult::notFound();
		}

		// Validate the license
		$licenseValidationResult = $foundLicense->validateForContext($unpackedPayload->client_context);

		// Return the result
		return $licenseValidationResult;
	}
}


