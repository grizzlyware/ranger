<?php

namespace Grizzlyware\Ranger\Shared;

interface CanBePackaged
{
	public static function getPackKey();
	public function pack();
	public static function unpack($body);
}




