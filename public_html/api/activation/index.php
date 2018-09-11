<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3). "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use NerdCore\NerdNook\Profile;

/**
 * API checking the profile activation status
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 */

//Checking the session, and if it not active, then start the session.
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nerdnook.ini");

	//check the HTTP method being use
	$method = array_key_exists("HTTP_X_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"]: $_SERVER["REQUEST_METHOD"];

	//sanitize input for unruly people trying to crash the system
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);

	//make sure the activation token is the correct size
	if(strlen($activation) !== 32 ){
		throw(new InvalidArgumentException("Token is not the right length.", 405));
	}

	//verify that the activation token is a string value of a hexadecimal
	if(ctype_xdigit($activation) === false) {
		throw (new \InvalidArgumentException("There is nothing here. You have to feed me <em>something!</em>", 405));
	}
	//handle the GET HTTP request
	if($method === "GET"){

		//set XSRF COOOOOKIE! ME WANT COOOKIE!
		setXsrfCookie();

		$profile = Profile::getProfileByProfileActivationToken($pdo, $activation);

		//verify the profile is not null, that it exists...
		if($profile !== null){

			//make sure the activation token matches the given profile
			if($activation === $profile->getProfileActivationToken()) {

				//update the profile in the database
				$profile->update($pdo);

				//set the reply for the end user
				$reply->data = "Thank you for joining the Nerd Nook and activating your profile! You will be auto-redirected to your profile in a moment... let the games begin.";
			}
		} else {
			//throw exception for non-existent tokens
			throw(new RuntimeException("There is no profile with this activation code...", 404));
		}
	} else {
		//throw an exception if the HTTP request is not a GET
		throw(new InvalidArgumentException("Invalid HTTP method request. I know you have no idea what this means, but hey, moving on.", 403));
	}
} catch (Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch (TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

//prepare and send the reply
header("Content-type: application/json");
if($reply->data === null) {
		unset($reply->data);
}

header("Location: ../../profile/". $profile->getProfileAtHandle()); /* Redirect browser */
exit();
