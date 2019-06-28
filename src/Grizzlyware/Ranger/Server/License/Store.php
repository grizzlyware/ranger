<?php

namespace Grizzlyware\Ranger\Server\License;

abstract class Store implements StoreInterface
{
	protected $keyLength = null;
	protected $keyPrefix = null;
	protected $keySuffix = null;

	public function generator()
	{
		// Create the options
		$generatorOptions = ["key" => []];
		if($this->keyLength) $generatorOptions["key"]["length"] = $this->keyLength;
		if($this->keyPrefix) $generatorOptions["key"]["prefix"] = $this->keyPrefix;
		if($this->keySuffix) $generatorOptions["key"]["suffix"] = $this->keySuffix;

		// Build the generator
		return new Generator($this, $generatorOptions);
	}
}



