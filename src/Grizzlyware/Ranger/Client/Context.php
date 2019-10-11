<?php

namespace Grizzlyware\Ranger\Client;

use Grizzlyware\Ranger\Shared\CanBePackaged;

class Context implements ContextInterface, CanBePackaged
{
	protected $ipAddress;
	protected $directory;
	protected $domain;
	protected $applicationKey;

	public static function create()
	{
		$parentClass = get_called_class();
		$context = new $parentClass();
		$context->determineContextAttributes();
		return $context;
	}

	public function getIpAddress()
	{
		return $this->ipAddress;
	}

	public function getDirectory()
	{
		return $this->directory;
	}

	public function getDomain()
	{
		return $this->domain;
	}

	public function getApplicationKey()
	{
		return $this->applicationKey;
	}
	
	public function setIpAddress($ipAddress)
	{
		// Remove any ranges..
		$ipAddress = explode("/", $ipAddress, 2)[0];

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

	public function setApplicationKey($applicationKey)
	{
		$this->applicationKey = $applicationKey;
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
		$context->setApplicationKey($body->applicationKey);

		return $context;
	}

	public function determineContextAttributes()
	{
		throw new \Exception('The determineContextAttributes method has not been defined on the context');
	}
}


