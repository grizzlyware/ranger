<?php

namespace Grizzlyware\Ranger\Client;

class Client
{
	protected $context;
	protected $serverConnection;

	public function __construct(Context $context, ServerConnectionInterface $serverConnection)
	{
		$this->context = $context;
		$this->serverConnection = $serverConnection;
	}

	public function validateLicense(License $license)
	{
		return $this->serverConnection->validateLicense($license, $this->context);
	}
}



