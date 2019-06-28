<?php

namespace Grizzlyware\Ranger\Client;

interface ContextInterface
{
	public static function create();
	public function determineContextAttributes();
	public function setIpAddress($ipAddress);
	public function setDirectory($directory);
	public function setDomain($domain);
}


