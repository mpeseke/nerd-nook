<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__,3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");


use NerdCore\NerdNook\ {

	Comment

};


/*
 * api for Comment Class
 *
 * @author Chelsea David <cryan17@cnm.edu>
 *
 */

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
}


// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMYSQL("/etc/apache2/capstone-mysql/nerdnook.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize the input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentEventId = filter_input(INPUT_GET, "commentEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentProfileId = filter_input(INPUT_GET, "commentProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentContent = filter_input(INPUT_GET, "commentContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentDateTime = filter_input(INPUT_GET, "commentDateTime", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw (new InvalidArgumentException("id cannot be empty", 405));
	}

	//handle GET request - if id is present, that comment is returned
	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		// get a specific comment and update reply
		if(empty($id) === false) {
			$reply->data = Comment::getCommentByCommentId($pdo, $id);
		} else if(empty($commentEventId) === false) {
			$reply->data = Comment::getCommentByCommentEventId($pdo, $commentEventId)->toArray();
		} else if(empty($commentProfileId) === false) {
			$reply->data = Comment::getCommentByCommentProfileId($pdo, $commentProfileId)->toArray();
		}
	} else if($method === "PUT" || $method === "POST") {
		// enforce that the user has an XSRF token
		verifyXsrf();

		$requestContent = file_get_contents("php://input");
		//retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function,here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContent);
		// This line then decodes the JSON package and stores that result in $requestObject

		// make sure comment content is available (required field)
		if(empty($requestObject->commentContent) === true) {
			throw (new \InvalidArgumentException ("No Content for Comment", 405));
		}

		// make sure the comment date is accurate (optional field)
		if(empty($requestObject->commentDateTime) === true) {
			$requestObject->commentDateTime = null;
		} else {
			// if the date exists, Angulars milliseconds since the beginning of time MUST be converted
			$commentDateTime = DateTime::createFromFormat("U.u", $requestObject->commentDateTime / 1000);
			if($commentDateTime === false) {
				throw (new RuntimeException("Invalid Comment Date", 400));
			}
			$requestObject->commentDateTime = $commentDateTime;
		}

		// make sure event ID is available
		if(empty($requestObject->commentEventId) === true) {
			throw(new \InvalidArgumentException("No Event ID", 405));
		}

		//make sure the profile ID is available
		if(empty($requestObject->commentProfileId) === true) {
			throw (new \InvalidArgumentException("No Profile ID", 405));
		}

		// perform the actual put or post
		if($method === "PUT") {

			// retrieve the comment to update
			$comment = Comment:: getCommentByCommentId($pdo, $id);
			if($comment === null) {
				throw(new RuntimeException("Comment does not exist", 404));
			}

			//enforce the user is signed in and only trying to update their own comment
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $comment->getCommentProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this comment", 403));
			}

			//update all attributes
			$comment->setCommentId($requestObject->commentId);
			$comment->setCommentEventId($requestObject->commentEventId);
			$comment->setCommentProfileId($requestObject->commentProfileId);
			$comment->setCommentContent($requestObject->commentContent);
			$comment->setCommentDateTime($requestObject->commentDateTime);
			$comment->update($pdo);

			//update reply
			$reply->message = "Comment updated OK";
		} else if($method === "POST") {

			//enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post a comments", 403));
			}

			//create new comment and insert into the database
			$comment = new Comment(generateUuidV4(), $_SESSION["event"]->getEventId(), $_SESSION["profile"]->getProfileId(), $requestObject->commentContent, null);
			$comment->insert($pdo);

			//update reply
			$reply->message = "Comment created OK";
		}
	} else if($method === "Delete") {

		// enforce that the end user has a XSRF token.
		verifyXsrf();

		//retrieve the Comment to be deleted
		$comment = Comment::getCommentByCommentId($pdo, $id);
		if($comment === null) {
			throw(new RuntimeException("Comment does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own comment
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $comment->getCommentProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this comment", 403));
		}

		//delete comment
		$comment->delete($pdo);
		//update reply
		$reply->message = "Tweet deleted OK";
	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request", 418));
	}
	// update the $reply ->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	}

	header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);


