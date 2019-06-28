<?php

namespace Grizzlyware\Ranger\Server\License;

use Grizzlyware\Ranger\Shared\CanBePackaged;

class ValidationResult implements CanBePackaged
{
	public $valid;

	public function notFound()
	{
		$result = new self();
		$result->valid = false;
		return $result;
	}

	//

	public static function getPackKey()
	{
		return "validation_result";
	}

	public function pack()
	{
		// TODO: Implement pack() method.
		return json_encode($this);
	}

	public static function unpack($body)
	{
		// Decode
		$body = json_decode($body);

		// Build the instance
		$instance = new self();
		$instance->valid = $body->valid;
		return $instance;
	}
}


