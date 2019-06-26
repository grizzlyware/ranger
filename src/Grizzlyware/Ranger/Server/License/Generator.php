<?php

namespace Grizzlyware\Ranger\Server\License;

use Grizzlyware\Ranger\Server\Exceptions\GenerationAttemptsReachedException;

class Generator
{
	protected $options;
	protected $store;

	public function __construct(Store $store, $overrideOptions = null)
	{
		// Set the defaults up
		$defaultOptions =
		[
			"key" =>
			[
				"generationAttempts" => 50,
				"length" => 20,
				"prefix" => null,
				"suffix" => null
			]
		];

		$this->options = json_decode(json_encode(self::mergeOptions($defaultOptions, $overrideOptions)));
		$this->store = $store;
	}

	public function getKey()
	{
		$attempts = 0;
		$potentialKey = null;

		while($attempts === 0 || !$this->store->isLicenseKeyAvailable($potentialKey))
		{
			$potentialKey = $this->generateKey();
			$attempts++;
			if($attempts >= $this->options->key->generationAttempts) throw new GenerationAttemptsReachedException();
		}

		return $potentialKey;
	}

	protected static function mergeOptions($defaults, $overrides)
	{
		if(!is_array($overrides)) $overrides = [];

		foreach($defaults as $optionKey => &$defaultValue)
		{
			if(isset($overrides[$optionKey]))
			{
				if(is_array($defaultValue))
				{
					$defaultValue = self::mergeOptions($defaultValue, $overrides[$optionKey]);
				}
				else
				{
					$defaultValue = $overrides[$optionKey];
				}
			}
		}

		return $defaults;
	}

	protected function generateKey()
	{
		$characters = array_merge(range("a", "z"), range(0, 9));
		$totalCharacters = count($characters);

		$generatedPortion = "";

		for($i = 0; $i < $this->options->key->length; $i++)
		{
			$generatedPortion .= $characters[rand(0, $totalCharacters - 1)];
		}

		return $this->options->key->prefix . $generatedPortion . $this->options->key->suffix;
	}
}




