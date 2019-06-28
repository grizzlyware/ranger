<?php

namespace Grizzlyware\Ranger\Server\License;

interface StoreInterface
{
	public function isLicenseKeyAvailable($licenseKey);
	public function findLicenseByKey($licenseKey);

	// Abstracted methods
	public function generator();
}



