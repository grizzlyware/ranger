<?php

namespace Grizzlyware\Ranger\Client;

use Grizzlyware\Ranger\Shared\CanHandlePackagedPayloads;

abstract class ServerConnection implements ServerConnectionInterface
{
	use CanHandlePackagedPayloads;
}


