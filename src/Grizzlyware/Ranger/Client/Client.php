<?php

namespace Grizzlyware\Ranger\Client;

class Client
{
	protected $context;

	public function __construct(Context $context)
	{
		$this->context = $context;
	}

	public function validateLicense(License $license)
	{
		return true;
	}
}



