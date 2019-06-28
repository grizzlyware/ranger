<?php

namespace Grizzlyware\Ranger\Client;

// This will enable a client to communicate with a remote server
interface ServerConnectionInterface
{
	public function validateLicense(License $license, Context $context);
	public function packPayload(License $license, Context $context);
}

