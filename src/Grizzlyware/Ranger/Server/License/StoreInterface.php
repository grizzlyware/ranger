<?php

namespace Grizzlyware\Ranger\Server\License;

interface StoreInterface
{
	public function isLicenseKeyAvailable($licenseKey);
	public function findLicenseByKey($licenseKey);
	public function findLicenseByPayload($payload);
	
	// Abstracted methods
	public function generator();
}



