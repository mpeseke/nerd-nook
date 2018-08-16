<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use NerdCore\NerdNook\Profile;

/**
 *
 * api for handling sign-in
 *
 * @author Cryan17
 *
 **/
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data=null;
try{

	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
	}
	// grab mySQL statement
	$pdo = connectToEncryptedMYSQL("/etc/apache2/capstone-mysql/nerdnook.ini");

	// determine which HTTP method is being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	//if method is post handle the sign in logic
	if($method === "POST") {

		// make sure the XSRF Token is valid
		verifyXsrf();

		//process the request content and decode the json object into php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check to make sure the password and email field is not empty.s
		if(empty($requestObject->profileEmail) === true) {
				throw(new \InvalidArgumentException("Wrong email address.", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}

		if(empty($requestObject->profilePassword) === true) {
				throw(new \InvalidArgumentException("Must enter a password", 401));
		} else {
				$profilePassword = $requestObject->profilePassword;
		}

		//grab the profile from the database by email provided
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
				throw(new \InvalidArgumentException("Invalid email", 401));
		}
		$profile->setProfileActivationToken(null);
		$profile->update($pdo);

		//if the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null) {
				throw(new \InvalidArgumentException("you are not allowed to sign in unless you have activated your account", 401));
		}

		// verify the profile hash is correct
		if(password_verify($requestObject->profilePassword, $profile->getProfileHash()) === false) {
			throw(new \InvalidArgumentException("Password or email is incorrect", 401));
		}

		//grab profile from database and put into a session
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());

		$_SESSION["profile"] = $profile;

		//create the Auth payload
		$authObject = (object) [
			"profileId" =>$profile->getProfileId(),
			"profileAtHandle" => $profile->getProfileAtHandle()
		];

		//create and set the JWT Token
		setJwtAndAuthHeader("auth",$authObject);


		$reply->message = "Sign in successful.";
	} else {
			throw(new \InvalidArgumentException("Invalid HTTP Method Request.", 418));
	}

	// if an exception is thrown, update
} catch(Exception | TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
echo json_encode($reply);