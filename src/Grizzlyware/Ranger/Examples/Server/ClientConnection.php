<?php

namespace Grizzlyware\Ranger\Examples\Server;

class ClientConnection extends \Grizzlyware\Ranger\Server\ClientConnection
{
	public function initialiseDataStore()
	{
		$this->store = new Store();
	}
}





