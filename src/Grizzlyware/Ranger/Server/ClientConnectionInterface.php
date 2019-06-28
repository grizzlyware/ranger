<?php

namespace Grizzlyware\Ranger\Server;

interface ClientConnectionInterface
{
	public function validateLicense(\Grizzlyware\Ranger\Client\License $license, \Grizzlyware\Ranger\Client\Context $context);
	public function unpackPayload($payload);
}



