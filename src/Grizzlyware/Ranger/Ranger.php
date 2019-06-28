<?php

namespace Grizzlyware\Ranger;

use Grizzlyware\Ranger\Client\Client;
use Grizzlyware\Ranger\Client\ContextInterface as ClientContext;
use Grizzlyware\Ranger\Client\LicenseInterface as ClientLicense;
use Grizzlyware\Ranger\Client\ServerConnectionInterface;
use Grizzlyware\Ranger\Server\Server;

class Ranger
{
	public static function client(ClientContext $context, ServerConnectionInterface $serverConnection)
	{
		return new Client($context, $serverConnection);
	}

	public static function server()
	{
		return new Server();
	}
}


