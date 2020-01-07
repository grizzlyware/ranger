<?php

namespace Grizzlyware\Ranger\Server\License;

use Grizzlyware\Ranger\Client\License;
use Grizzlyware\Ranger\Shared\CanBePackaged;

final class ValidationResult implements CanBePackaged
{
	protected $valid;

	public function __get($name)
	{
		switch($name)
		{
			case 'valid':
				return $this->valid;
		}

		return null;
	}

	public function __set($name, $value)
	{
		switch($name)
		{
			case 'valid':
				if(!isset($this->valid)) $this->valid = $value;
				break;
		}
	}

	public static function notFound()
	{
		$result = new self();
		$result->valid = false;
		return $result;
	}

	public static function valid(License $license)
	{
		$result = new self();
		$result->valid = true;
		return $result;
	}

	public static function serverError(License $license)
	{
		$result = new self();
		$result->valid = false;
		return $result;
	}

	public function isValid()
	{
		return $this->valid;
	}

	//

	public static function getPackKey()
	{
		return "validation_result";
	}

	public function pack()
	{
		return (object)get_object_vars($this);
	}

	public static function unpack($body)
	{
		// Build the instance
		$instance = new self();
		$instance->valid = $body->valid;
		return $instance;
	}
}


