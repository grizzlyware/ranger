<?php

namespace Grizzlyware\Ranger;

use Grizzlyware\Ranger\Client\Client;
use Grizzlyware\Ranger\Client\ContextInterface as ClientContext;
use Grizzlyware\Ranger\Client\LicenseInterface as ClientLicense;
use Grizzlyware\Ranger\Server\Server;

class Ranger
{
	public static function client(ClientContext $context)
	{
		return new Client($context);
	}

	public static function server()
	{
		return new Server();
	}
}


