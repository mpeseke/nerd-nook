<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname("/etc/apache2/nerd-nook-mysql/encrypted-config.php");

use NerdCore\NerdNook\{
	CheckIn
};

/**
 * api for the checkIn class
 *
 * @author Caleb Heckendorn <programmingpianist@gmail.com>
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/nerd-nook-mysql/nerdnook.ini");

	//determine what HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize parameters
	$checkInProfileId = filter_input(INPUT_GET, "checkInProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$checkInEventId = filter_input(INPUT_GET, "checkInEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
//make sure the id is valid for methods that require it
	if($method === "GET") {
		//Set XRSF cookie
		setXsrfCookie();

		//gets a specific checkIn associated based on its composite key
		if($checkInProfileId !== null && $checkInEventId !== null) {
			$checkIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($pdo, $checkInProfileId, $checkInEventId);

			if($checkIn !== null) {
				$reply->data = $checkIn;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($checkInEventId) === false) {
			$checkIn = CheckIn::getCheckInByCheckInEventId($pdo, $checkInEventId)->toArray();
			if($checkIn !== null) {
				$reply->data = $checkIn;
			}
			//get all the checkIns associated the the eventId
		} else if(empty($checkInEventId) === false) {
			$checkIn = CheckIn::getCheckInByCheckInProfileId($pdo, $checkInProfileId)->toArray();

			if($checkIn !== null) {
				$reply->data = $checkIn;
			}
		} else {
			throw new InvalidArgumentException("Incorrect search parameters ", 404);
		}

	} else if($method === "POST" || $method === "PUT") {

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->checkInEventId) === true) {
			throw (new \InvalidArgumentException("No Event linked to the CheckIn", 405));
		}

		if(empty($requestObject->checkInProfileId) === true) {
			throw (new \InvalidArgumentException("No Profile linked to the CheckIn", 405));
		}

		if(empty($requestObject->checkInDateTime) === true) {
			$requestObject->checkInDateTime = date("y-m-d H:i:s");
		}

		if(empty($requestObject->checkInRep) === true) {
			$requestObject->checkInRep = is_integer(20);
		}

		if($method === "POST") {

			//enforce that the end user has a XSRF token
			verifyXsrf();
		}

			//enforce that the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to Check In", 403));


				$checkIn = new CheckIn($_SESSION["profile"]->getProfileId(), $requestObject->checkInEventId);
				$checkIn->insert($pdo);
				$reply->message = "Check In Successful!";
			}
			//if anyt other HTTP request is sent throw an exception
		} else {
			throw new \InvalidArgumentException("Invalid HTTP Request", 400);
		}
		//catch any exception that is thrown and update the status and message
	} catch(\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}

//encode and return reply to front end caller
echo json_encode($reply);
