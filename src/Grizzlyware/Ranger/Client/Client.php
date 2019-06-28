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
		// Attempt to validate the license locally with its fingerprint
		return $license->validateForClient($this);
	}

	public function getContext()
	{
		return $this->context;
	}

	public function getServerConnection()
	{
		return $this->serverConnection;
	}
}



