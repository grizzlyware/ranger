<?php

require __DIR__ . "/../vendor/autoload.php";

class TestStore implements \Grizzlyware\Ranger\Server\License\Store
{
	public function isLicenseKeyAvailable($licenseKey)
	{
		return rand(0, 10) === 0;
	}
}

$testStore = new TestStore();

$generator = new \Grizzlyware\Ranger\Server\License\Generator($testStore,
[
	"key" =>
	[
		"prefix" => "MyApp-"
	]
]);

echo $generator->getKey();
echo "\n";


