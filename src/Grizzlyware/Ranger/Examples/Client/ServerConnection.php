<?php

namespace Grizzlyware\Ranger\Examples\Client;

use Grizzlyware\Ranger\Client\Context;
use Grizzlyware\Ranger\Client\License;
use Grizzlyware\Ranger\Examples\Server\ClientConnection;

class ServerConnection extends \Grizzlyware\Ranger\Client\ServerConnection
{
	public function validateLicense(License $license, Context $context)
	{
		// We're going to now speak to the server... over whichever transport layer we want...
		
		// Package the call up..
		$packedPayload = $this->packPayload($license, $context);

		// Client sending data... -----> --> . . . . .. ---> Received by the server...

		// Build the server instance
		$serverClientConnection = new ClientConnection();
		$serversResponse = $serverClientConnection->handleRequest($packedPayload);

		// Package the servers response up and send it back to the client...
		$packedServerResponse = $serverClientConnection->packPayload($serversResponse);

		// Server sending data... -----> --> . . . . .. ---> Received by the client...

		// Unpack the servers response
		$unpackedServersResponse = $this->unpackPayload($packedServerResponse);

		return $unpackedServersResponse->validation_result;
	}
}


