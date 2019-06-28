<?php

namespace Grizzlyware\Ranger\Client;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Grizzlyware\Ranger\Client\Exceptions\FingerprintExpiredException;
use Grizzlyware\Ranger\Client\Exceptions\FingerprintInvalidException;
use Grizzlyware\Ranger\Exception;
use Grizzlyware\Ranger\Server\License\ValidationResult;
use Grizzlyware\Ranger\Shared\CanBePackaged;

abstract class License implements LicenseInterface, CanBePackaged
{
	protected function getFingerprintSecret()
	{
		throw new Exception("The getFingerprintSecret method has not been implemented on the License model");
	}

	protected function getSoftFingerprintTtl()
	{
		throw new Exception("The getSoftFingerprintTtl method has not been implemented on the License model");
	}

	protected function getHardFingerprintTtl()
	{
		throw new Exception("The getHardFingerprintTtl method has not been implemented on the License model");
	}

	protected function generateFingerprint(ValidationResult $validationResult)
	{
		$fingerprint = [];
		$fingerprint[$validationResult::getPackKey()] = $validationResult->pack();
		$fingerprint['generated_at'] = time();
		return JWT::encode($fingerprint, $this->getFingerprintSecret());
	}

	public static function getPackKey()
	{
		return "client_license";
	}

	public function pack()
	{
		return (object)get_object_vars($this);
	}

	public static function unpack($payload)
	{
		return $payload;
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

		// Check the servers response
		$validationResult = $client->getServerConnection()->validateLicense($this, $client->getContext());

		// If it's a valid license check, store it
		if($validationResult->isValid())
		{
			$this->storeFingerprint($this->generateFingerprint($validationResult));
		}

		return $validationResult;
	}

	public function validateFingerprint($fingerprintString)
	{
		try
		{
			$fingerprint = JWT::decode($fingerprintString, $this->getFingerprintSecret(), ['HS256']);

			// TODO Check it's not expired
			//$fingerprint->generated_at

			// Unpack the validation result..
			return ValidationResult::unpack($fingerprint->{ValidationResult::getPackKey()});

			// Has it expired?
			throw new FingerprintExpiredException();
		}
		catch(SignatureInvalidException $e)
		{
			throw new FingerprintInvalidException();
		}
	}
}






