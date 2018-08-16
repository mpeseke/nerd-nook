<?php

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";
require_once  dirname(__DIR__) . "/lib/uuid.php";

use Lcobucci\JWT\{
		Builder, Singer\Hmac\Sha512, Parser, ValidationData
};

/**
 * this method creates a JWT that will be used on the front end to authenticate users, activate protected routes, and verification of who is logged in.
 * this token is viewable by anyone and SHOULD NOT contain any sensitive information about the user.
 *
 * @see https://github.com/lcobucci/jwt/blob/3.2/README.md documentation for the composer package used for JWT
 * @param string $value name of the custom object that will be used for validation.
 * @param stdClass $content the actual object that will be used for authentication on the front end
 */

function setJwtAndAuthHeader(string $value, stdClass $content): void {

	//enforce that the session is active
	if(session_status() !== PHP_SESSION_ACTIVE) {
		throw(new \RuntimeException("session not active"));
	}

	//create the signer object
	$signer = new Sha512();

	//create a UUID to sign the JWT and then store it in the session
	$signature = generateUuidV4();

	//store the signature in string format
	$_SESSION["signature"] = $signature->toString();

	$token = (new Builder())
		->set($value, $content)
		->setIssuer("https://bootcamp-coders.cnm.edu")
		->setAudience("https://bootcamp-coders.cnm.edu")
		->setId(session_id())
		->setIssuedAt(time())
		->setExpiration(time() + 3600)
		->sign($signer, $signature->toString())
		->getToken();

	$_SESSION["JWT-TOKEN"] = (string)$token;

	// add the JWT to the header
	header("X-JWT-TOKEN: $token");
	}
