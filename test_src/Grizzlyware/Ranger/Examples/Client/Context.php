<?php

namespace Grizzlyware\Ranger\Examples\Client;

final class Context extends \Grizzlyware\Ranger\Client\Context
{
	public function determineContextAttributes()
	{
		$this->setApplicationKey('EJowW2M3');
		$this->setIpAddress('1.1.1.1');
		$this->setDirectory(__DIR__);
		$this->setDomain('mydomain.com');
	}
}



