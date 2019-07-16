<?php

namespace Grizzlyware\Ranger\Client;

use Grizzlyware\Ranger\Shared\CanBePackaged;

class Context implements ContextInterface, CanBePackaged
{
	protected $ipAddress;
	protected $directory;
	protected $domain;

	public static function create()
	{
		$parentClass = get_called_class();
		$context = new $parentClass();
		$context->determineContextAttributes();
		return $context;
	}
	
	public function setIpAddress($ipAddress)
	{
		$this->ipAddress = $ipAddress;
	}

	public function setDirectory($directory)
	{
		$this->directory = $directory;
	}

	public function setDomain($domain)
	{
		$this->domain = $domain;
	}

	public static function getPackKey()
	{
		return "client_context";
	}

	public function pack()
	{
		return (object)get_object_vars($this);
	}

	public static function unpack($body)
	{
		// Reconstruct it
		$parentClass = get_called_class();
		$context = new $parentClass();

		// Set the props
		$context->setIpAddress($body->ipAddress);
		$context->setDirectory($body->directory);
		$context->setDomain($body->domain);

		return $context;
	}
}


