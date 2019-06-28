<?php

namespace Grizzlyware\Ranger\Server\License;

use Grizzlyware\Ranger\Client\License;
use Grizzlyware\Ranger\Shared\CanBePackaged;

final class ValidationResult implements CanBePackaged
{
	// TODO make protected
	public $valid;

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


