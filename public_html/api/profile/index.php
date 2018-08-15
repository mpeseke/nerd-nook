<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use NerdCore\NerdNook\ {
			Profile
};

/**
 * API for Profile
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 */

//verify the session, if it not active start it
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

			//prepare which HTTP method was used
			$method = array_change_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

			//sanitize input
			$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$profileAtHandle = filter_input(INPUT_GET, "profileAtHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

			//make sure the if is valid for methods that require it
			if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
					throw(new InvalidArgumentException("id cannot be empty or negative", 405));
			}

			if($method === "GET") {
						//set the XSRF cookie
						setXsrfCookie();

						//gets a profile by content
						if(empty($id) === false) {
								$profile = Profile::getProfileByProfileId($pdo, $id);
								if($profile !== null) {
										$reply->data = $profile;
								}
						} else if(empty($profileAtHandle) === false) {
								$profile = Profile::getProfileByProfileAtHandle($pdo, $profileAtHandle);
								if($profile !== null) {
										$reply->data = $profile;
								}
						} else if(empty($profileEmail) === false) {
								$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
								if($profile !== null) {
										$reply->data = $profile;
								}
						}

			} elseif($method === "PUT") {

						//enforce that the XSRF token is present in the header
						verifyXsrf();

						//enforce the end user is signed in and only trying to edit their own profile
						if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $id) {
									$throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
						}

						//enforce the end user has a JWT token
						validateJwtHeader();

						//decode the response from the front end
						$requestContent = file_get_contents("php://input");
						$requestObject = json_decode($requestContent);

						//retrieve the profile to be updated
						$profile = Profile::getProfileByProfileId($pdo, $id);
						if($profile === null) {
								throw(new RuntimeException("Profile does not exist", 404));
						}

						//profile at handle
						if(empty($requestObject->profileAtHandle) === true) {
								throw(new \InvalidArgumentException("No profile at handle", 405));
						}

						//profile email is a required field
						if(empty($requestObject->profileEmail) === true) {
								throw(new \InvalidArgumentException("No profile email presnet", 405));
						}

						$profile->setProfileAtHandle($requestObject->profileAtHandle);
						$profile->setProfileEmail($requestObject->profileEmail);
						$profile->update($pdo);

						// update reply
						$reply->message = "Profile information updated";

			} elseif($method === "DELETE") {

						//enforce that the XSRF token is present in the header
						verifyXsrf();

						//enforce the end user has a JWT token
						//validateJwtHeader();

						$profile = Profile::getProfileByProfileId($pdo, $id);
						if($profile === null) {
								throw(new RuntimeException("Profile does not exist", 404));
						}

						//enforce the user is signed in and only trying to edit their own profile
						if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $profile->getProfileId()->toString()) {
								throw(new \InvalidArgumentException("You are not allowed to access this profile", 403));
						}

						validateJwtHeader();

						//delete the post from the database
						$profile->delete($pdo);
						$reply->message = "Profile Deleted";
			} else {
						throw(new InvalidArgumentException("Invalid HTTP request", 400));
			}
			//catch any exceptions that were thrown and update the status and message state variable field
} catch(\Exception | TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
		unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);