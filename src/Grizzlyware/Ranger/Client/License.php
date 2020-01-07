<?php

namespace Grizzlyware\Ranger\Client;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Grizzlyware\Ranger\Client\Exceptions\FingerprintHardTtlExpiredException;
use Grizzlyware\Ranger\Client\Exceptions\FingerprintInvalidException;
use Grizzlyware\Ranger\Client\Exceptions\FingerprintSoftTtlExpiredException;
use Grizzlyware\Ranger\Client\Exceptions\RemoteServerFailureException;
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
		$fingerprint['hash'] = $this->generateHash();
		return JWT::encode($fingerprint, $this->getFingerprintSecret());
	}

	protected function generateHash()
	{
		return \md5(\serialize($this->pack()));
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
		$fingerprintString = $this->fetchFingerprint();
		$substituteResponseForFailedRemoteCheck = null;

		// Check the fingerprint!
		if($fingerprintString)
		{
			try
			{
				// Attempt to validate the fingerprint
				$fingerprint = $this->validateFingerprint($fingerprintString);
				
				// Has it reached a hard TTL?
				if($fingerprint->age > $this->getHardFingerprintTtl()) throw new FingerprintHardTtlExpiredException();
				if($fingerprint->age > $this->getSoftFingerprintTtl()) throw new FingerprintHardTtlExpiredException();

				// All good - return the finger prints validation result
				return $fingerprint->result;
			}
			catch(FingerprintHardTtlExpiredException $e)
			{
				// Do nothing - let it continue to a remote check
			}
			catch(FingerprintSoftTtlExpiredException $e)
			{
				// Do nothing - let it continue to a remote check, but let it be known that it's okay if we don't get a response back...
				$substituteResponseForFailedRemoteCheck = $fingerprint->result;
			}
			catch(FingerprintInvalidException $e)
			{
				// Do nothing - let it continue to a remote check
			}
		}

		// Check the servers response
		try
		{
			$validationResult = $client->getServerConnection()->validateLicense($this, $client->getContext());
		}
		catch(RemoteServerFailureException $e)
		{
			// If we have a substitute response, send it home..
			if($substituteResponseForFailedRemoteCheck) return $substituteResponseForFailedRemoteCheck;
			return ValidationResult::serverError($this);
		}

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

			// Work out the fingerprints age
			$fingerprintAge = time() - $fingerprint->generated_at;

			// Validate the hash matches
			if(!isset($fingerprint->hash)) throw new FingerprintInvalidException('Fingerprint does not have a hash stored');
			if($fingerprint->hash !== $this->generateHash()) throw new FingerprintInvalidException('Invalid license hash');

			// Send it home..
			return (object)['age' => $fingerprintAge, 'result' => ValidationResult::unpack($fingerprint->{ValidationResult::getPackKey()})];
		}
		catch(SignatureInvalidException $e)
		{
			throw new FingerprintInvalidException();
		}
	}
}






