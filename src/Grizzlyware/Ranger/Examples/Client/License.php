<?php

namespace Grizzlyware\Ranger\Examples\Client;

use Grizzlyware\Ranger\Client\Context;
use Grizzlyware\Ranger\Server\License\ValidationResult;

final class License extends \Grizzlyware\Ranger\Client\License
{
	protected $licenseKey;
	static $fingerprintPath = __DIR__ . "/fingerprint";

	private function getFingerprintPath()
	{
		return self::$fingerprintPath . '-' . md5($this->licenseKey);
	}

	protected function getFingerprintSecret()
	{
		return "MyFingerPrintSecret";
	}

	protected function getSoftFingerprintTtl()
	{
		return 30;
	}

	protected function getHardFingerprintTtl()
	{
		return 60;
	}

	public function fetchFingerprint()
	{
		if(!file_exists($this->getFingerprintPath())) return null;
		return file_get_contents($this->getFingerprintPath());
	}

	public function storeFingerprint($fingerprintString)
	{
		file_put_contents($this->getFingerprintPath(), $fingerprintString);
	}

	public function validateForContext(Context $context)
	{
		$result = new ValidationResult();
		$result->valid = strpos($this->licenseKey, "Two222Two222Two") === false; // Two license is found but invalid
		return $result;
	}

	public function setKey($licenseKey)
	{
		$this->licenseKey = $licenseKey;
	}

	public static function formWithString($licenseKey)
	{
		$license = new self();
		$license->setKey($licenseKey);
		return $license;
	}

	public function pack()
	{
		return (object)['licenseKey' => $this->licenseKey];
	}

	public static function unpack($body)
	{
		// Reconstruct it
		$license = new self();

		// Set the props
		$license->setKey($body->licenseKey);

		return $license;
	}
}



