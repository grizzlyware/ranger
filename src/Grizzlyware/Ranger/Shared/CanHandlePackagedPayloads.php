<?php

namespace Grizzlyware\Ranger\Shared;

use Grizzlyware\Ranger\Client\Context;
use Grizzlyware\Ranger\Client\License;
use Grizzlyware\Ranger\Server\License\ValidationResult;

trait CanHandlePackagedPayloads
{
	public function packPayload(...$payload)
	{
		$packedPayload = [];

		foreach($payload as $item)
		{
			$packedPayload[$item::getPackKey()] = $item->pack();
		}

		return json_encode($packedPayload);
	}

	public function unpackPayload($payload)
	{
		$packKeys = self::getRegisteredPackKeys();

		$payload = is_string($payload) ? json_decode($payload) : $payload;
		$response = (object)[];

		foreach($payload as $packKey => $packLoad)
		{
			$packedClass = $packKeys->{$packKey};
			$response->{$packKey} = $packedClass::unpack($packLoad);
		}

		return $response;
	}

	private static function getRegisteredPackKeys()
	{
		$registeredPackKeys = (object)[];

		foreach(self::registeredPackClasses() as $registeredPackClass)
		{
			$registeredPackKeys->{$registeredPackClass::getPackKey()} = $registeredPackClass;
		}

		return $registeredPackKeys;
	}

	private static function registeredPackClasses()
	{
		return
		[
			License::class,
			Context::class,
			ValidationResult::class
		];
	}
}


