<?php

namespace Grizzlyware\Ranger\Examples\Server;

use Grizzlyware\Ranger\Server\License\ValidationResult;

class ClientConnection extends \Grizzlyware\Ranger\Server\ClientConnection
{
	public function validateLicense(\Grizzlyware\Ranger\Client\License $license, \Grizzlyware\Ranger\Client\Context $context)
	{
		$result = new ValidationResult();
		$result->valid = true;
		return $result;
	}
}





