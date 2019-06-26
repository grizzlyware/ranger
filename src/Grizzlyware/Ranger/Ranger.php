<?php

namespace Grizzlyware\Ranger;

use Grizzlyware\Ranger\Client\Client;
use Grizzlyware\Ranger\Client\Context as ClientContext;
use Grizzlyware\Ranger\Client\License as ClientLicense;
use Grizzlyware\Ranger\Server\Server;

class Ranger
{
	public static function client(ClientLicense $license, ClientContext $context)
	{
		return new Client($license, $context);
	}

	public static function server()
	{
		return new Server();
	}
}


