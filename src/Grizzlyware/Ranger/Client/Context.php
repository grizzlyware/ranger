<?php

namespace Grizzlyware\Ranger\Client;

abstract class Context implements ContextInterface
{
	protected $ipAddress;
	protected $directory;
	protected $domain;

	public function __construct()
	{
		$this->determineContextAttributes();
	}

	public static function create()
	{
		$parentClass = get_called_class();
		$context = new $parentClass();
		return $context;
	}

	protected function determineContextAttributes()
	{
		$this->ipAddress = '1.1.1.';
		$this->directory = __DIR__;
		$this->domain = 'mydomain.com';
	}
}


