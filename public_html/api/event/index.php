<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use NerdCore\NerdNook\ {
	Event
};

/**
 * api for the Event Class
 *
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nerdnook.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize inputs
	$eventId = filter_input(INPUT_GET, "eventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventCategoryId = filter_input(INPUT_GET,"eventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventProfileId = filter_input(INPUT_GET, "eventProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$eventDateTime = filter_input(INPUT_GET,"eventDateTime", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($eventId) === true)) {
		throw(new InvalidArgumentException("Id cannot be empty of negative", 402));
	}

	//handle the GET request - if ID is present, that event is returned, otherwise, all events are returned
	if($method === "GET") {
		//set XSRF Cookie
		setXsrfCookie();

		//get a specific tweet or all tweets and update reply
		if(empty($eventId) === false) {
			$reply->data = Event::getEventByEventId($pdo, $eventId);
			}
		} else if (empty($eventCategoryId) === false) {
			//if the user is logged in grab all the events by that user based on who is logged in, basically, get the users events if the are logged in.
			$reply->data = Event::getEventByEventCategoryId($pdo, $eventCategoryId)->toArray();
		} else if (empty($eventProfileId) === false) {
			$reply->data = Event::getEventByEventProfileId($pdo, $eventProfileId)->toArray();
		} else if (empty($eventContent) === false) {
			$reply->data = Event::getEventByDateRange($pdo, $eventDateTime)->toArray();
	}
	//PUT and POST methods
	else if($method === "PUT" || $method === "POST") {

		//enforce the user has an XSRF token, to make sure they are allowed to be making updates, yo.
		verifyXsrf();

		//retrieves the JSON package that the front end sent, and store it in $requestContent.
		$requestContent = file_get_contents("php://input");

		//decode the JSON package and stores the result in $requestObject
		$requestObject = json_decode($requestContent);

		//make sure event Category is available
		if(empty($requestObject->eventCategoryId) === true) {
		throw(new \InvalidArgumentException("Event not found in this Category", 405));
		}

		//make sure the event Profile Id exists
		if(empty($requestObject->eventProfileId) === true) {
		throw(new \InvalidArgumentException("Not a valid profile Id", 405));
		}

		//make sure the event Date is accurate
		if(empty($requestObject->eventDateTime) === true) {
			$requestObject->eventDateTime = null;
		} else {
			//if the date exists, Angular's milliseconds since the beginning of time MUST be converted, yo.
			$eventDateTime = DateTime::createFromFormat("U.u", $requestObject->eventDateTime / 1000);
			if($eventDateTime === false) {
				throw(new RuntimeException("Invalid Event Date/Time", 400));
			}
			$requestObject->eventDateTime = $eventDateTime;
		}

		//make sure eventId exists
		if(empty($requestObject->eventId) === true) {
			throw(new \InvalidArgumentException("This Event does not exist.", 405));
		}

		//perform the PUT or POST
		if($method === "PUT") {

			//retrieve the event to update
			$event = Event::getEventByEventId($pdo, $eventId);
			if($event === null){
				throw(new RuntimeException("Event does not exist.", 404));
			}

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["profile"]) === true|| $_SESSION["profile"]->getProfileId()->toString() !== $event->getEventProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event. Make your own and edit that! Oh, and have a nice day.", 403));
			}
			//update all attributes
			$event->setEventDetails($requestObject->eventDetails);
			$event->setEventLat($requestObject->eventLat);
			$event->setEventLong($requestObject->eventLong);
			$event->setEventEndDateTime($requestObject->eventEndDateTime);
			$event->setEventStartDateTime($requestObject->eventStartDateTime);
			$event->update($pdo);

			//update reply
			$reply->message = "Your event was successfully updated!";

		} else if($method === "POST") {

			//enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You have to log in to create Events.", 403));
			}

			//create new event and insert into the database
			$event = new Event(generateUuidV4(), $_SESSION["category"]->getEventCategoryId, $_SESSION["profile"]->getEventProfileId, $requestObject->eventDetails, $requestObject->eventEndDateTime,
			$requestObject->eventLat, $requestObject->eventLong, $requestObject->eventStartDateTime);
			$event->insert($pdo);

			//creation reply
			$event->message = "Event was successfully created.";
			} else if ($method === "DELETE") {

			//enforce that the end user is allowed in... has an XSRF token
			verifyXsrf();

			//retrieve the Event to be deleted
			$event = Event::getEventByEventId($pdo, $eventId);
			if($event === null) {
				throw(new RuntimeException("Event does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own Event
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $event->getEventProfileId()) {
				throw(new \InvalidArgumentException("Get your own event to delete, sucka.", 403));
			}

			//delete Event
			$event->delete($pdo);
			//update reply
			$reply->message = "Event deleted OK";
			}
		}
		//update the $reply->status $reply->message
	} catch (\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
//encode and return reply to front end caller
header("Content-type:application/json");
echo json_encode($reply);

//finally -JSON encodes the $reply object and sends it back to the front end