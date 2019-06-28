<?php

namespace Grizzlyware\Ranger\Client;

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
}





