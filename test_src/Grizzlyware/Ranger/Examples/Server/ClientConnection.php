<?php

namespace Grizzlyware\Ranger\Examples\Server;

use Grizzlyware\Ranger\Examples\Client\Context;
use Grizzlyware\Ranger\Examples\Client\License;
use Grizzlyware\Ranger\Server\License\ValidationResult;

class ClientConnection extends \Grizzlyware\Ranger\Server\ClientConnection
{
	public function initialiseDataStore()
	{
		$this->store = new Store();
	}

	// This is optional
	protected function getRegisteredPackClasses()
	{
		return
		[
			License::class,
			Context::class,
			ValidationResult::class
		];
	}
}





