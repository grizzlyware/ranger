<?php

namespace Grizzlyware\Ranger\Client;

interface LicenseInterface
{
	// This should accept a string and return a license object
	public static function formWithString($licenseKey);
}


