<?php

namespace Grizzlyware\Ranger\Examples\Client;

class License extends \Grizzlyware\Ranger\Client\License
{
	protected $licenseKey;

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
}



