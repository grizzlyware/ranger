<?php

namespace Grizzlyware\Ranger\Client;

class Client
{
	protected $license;
	protected $context;

	public function __construct(License $license, Context $context)
	{
		$this->license = $license;
		$this->context = $context;
	}
}



