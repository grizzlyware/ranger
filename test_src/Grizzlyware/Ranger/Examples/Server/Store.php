<?php

namespace Grizzlyware\Ranger\Examples\Server;

use Grizzlyware\Ranger\Examples\Client\License;
use Grizzlyware\Ranger\Server\Exceptions\LicenseNotFoundException;

class Store extends \Grizzlyware\Ranger\Server\License\Store
{
	public function findLicenseByKey($licenseKey)
	{
		$licenses = self::getExampleLicenses();

		if(isset($licenses[$licenseKey])) return $licenses[$licenseKey];
		throw new LicenseNotFoundException();
	}

	public function findLicenseByPayload($payload)
	{
		return $this->findLicenseByKey($payload->licenseKey);
	}

	public function isLicenseKeyAvailable($licenseKey)
	{
		try
		{
			if($this->findLicenseByKey($licenseKey)) return false;
			return true;
		}
		catch(LicenseNotFoundException $e)
		{
			return true;
		}
	}

	protected static function getExampleLicenses()
	{
		$licenseKeys = ["License-One111One111One", "License-Two222Two222Two"];
		$return = [];

		foreach($licenseKeys as $licenseKey)
		{
			$licenseObject = new License();
			$licenseObject->setKey($licenseKey);
			$return[$licenseKey] = $licenseObject;
		}

		return $return;
	}
}

