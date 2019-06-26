<?php

namespace Grizzlyware\Ranger\Server\License;

interface Store
{
	public function isLicenseKeyAvailable($licenseKey);
}



