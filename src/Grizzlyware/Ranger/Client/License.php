<?php

namespace Grizzlyware\Ranger\Client;

use Grizzlyware\Ranger\Client\Exceptions\FingerprintExpiredException;
use Grizzlyware\Ranger\Client\Exceptions\FingerprintInvalidException;
use Grizzlyware\Ranger\Server\License\ValidationResult;
use Grizzlyware\Ranger\Shared\CanBePackaged;

abstract class License implements LicenseInterface, CanBePackaged
{
	public static function getPackKey()
	{
		return "client_license";
	}

	public function pack()
	{
		return json_encode(get_object_vars($this));
	}

	public static function unpack($payload)
	{
		return json_decode($payload);
	}

	public function validateForClient(Client $client)
	{
		// Do we have a fingerprint?
		$fingerprint = $this->fetchFingerprint();

		// Check the fingerprint!
		if($fingerprint)
		{
			try
			{
				return $this->validateFingerprint($fingerprint);
			}
			catch(FingerprintExpiredException $e)
			{
				// Do nothing - let it continue to a remote check
			}
			catch(FingerprintInvalidException $e)
			{
				// Do nothing - let it continue to a remote check
			}
		}
		
		return $client->getServerConnection()->validateLicense($this, $client->getContext());
	}

	public function validateFingerprint($fingerprint)
	{
		// TODO
		throw new FingerprintExpiredException();
		throw new FingerprintInvalidException();
		return ValidationResult::valid($this);
	}
}





