<?php

namespace Grizzlyware\Ranger\Server;

abstract class ClientConnection implements ClientConnectionInterface
{
	public function unpackPayload($payload)
	{
		return json_decode($payload); // TODO
	}
}


