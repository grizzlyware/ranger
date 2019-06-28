<?php

namespace Grizzlyware\Ranger\Client;

abstract class ServerConnection implements ServerConnectionInterface
{
	public function packPayload(License $license, Context $context)
	{
		return json_encode([1, 2, 3]); // TODO
	}
}


