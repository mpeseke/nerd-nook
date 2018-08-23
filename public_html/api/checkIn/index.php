<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");



use NerdCore\NerdNook\{
	CheckIn
};

/**
 * api for the checkIn class
 *
 * @author Caleb Heckendorn
 **/

//verify the session start if not active
if (session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nerdnook.ini");

	//determine what HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize parameters
	$checkInEventId = $id = filter_input(INPUT_GET, "checkInEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$checkInProfileId = $id = filter_input(INPUT_GET, "checkInProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//make sure the id is valid for methods that require it
	if($method === "GET") {
		//Set XRSF cookie
		setXsrfCookie();

		//gets a specific checkIn associated based on its composite key
		if($checkInEventId !== null && $checkInProfileId !== null) {
			$checkIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($pdo, $checkInEventId, $checkInProfileId);

			if($checkIn !== null) {
				$reply->data = $checkIn;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($checkInEventId) === false) {
			$reply->data = CheckIn::getCheckInByCheckInEventId($pdo, $checkInEventId)->toArray();
			//get all the checkIns associated the the eventId
		} else if(empty($checkInProfileId) === false) {
			$reply->data = CheckIn::getCheckInByCheckInProfileId($pdo, $checkInProfileId)->toArray();
		} else {
			throw new \InvalidArgumentException("Incorrect search parameters ", 404);
		}

	} else if($method === "POST" || $method === "PUT") {

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		if(empty($requestObject->checkInDateTime) === true) {
			$requestObject->checkInDateTime = date("y-m-d H:i:s");
		}

		if(empty($requestObject->checkInRep) === true) {
			$requestObject->checkInRep = is_integer(20);
		}

		if($method === "POST"){
		//enforce that the end user has a XSRF token
		verifyXsrf();


		//enforce that the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to Check In", 403));
		}

		validateJwtHeader();

		$checkIn = new CheckIn($requestObject->checkInEventId,$_SESSION["profile"]->getProfileId(),$requestObject->checkInDateTime, $requestObject->checkInRep);
		$checkIn->insert($pdo);
		$reply->message = "Thank you for RSVP'ing! We look forward to seeing you there!";
		//if any other HTTP request is sent throw an exception
		} else if($method === "PUT") {
			 //enforce the user has a XSRF token
			verifyXsrf();

			//enforce they have a JWT token
			validateJwtHeader();

			//grab the checkIn by it's composite key.
			$checkIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($pdo, $requestObject->checkInEventId, $requestObject->checkInProfileId);
			if($checkIn === null){
				throw (new RuntimeException("Check in doesn't exist"));
			}

			//enforce that the user is singed in and only trying to edit their own checkIn
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $checkIn->getCheckInProfileId()) {
				throw(new \InvalidArgumentException("You must be logged in to check in ", 403));
			}

			//perform the actual checkIn
			$checkIn->update($pdo);

			//update the message
			$reply->message = "You Checked in! ";

		}
		//if any other HTTP request is sent throw an exception
	} else {
	throw new \InvalidArgumentException("Invalid HTTP request", 400);
	}
	//catch any exception that is thrown and
} catch(\Exception | \TypeError $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}
//encode and return reply to the front end caller
echo json_encode($reply);