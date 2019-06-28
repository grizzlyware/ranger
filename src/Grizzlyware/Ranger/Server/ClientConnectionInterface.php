<?php

namespace Grizzlyware\Ranger\Server;

interface ClientConnectionInterface
{
	public function initialiseDataStore();
	public function findLicense($licensePayload);
	public function unpackPayload($payload);
	public function handleRequest($payload);
}



