<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use NerdCore\NerdNook\Profile;


/**
 * api for signing up to NerdNook
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

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

		if($method === "POST") {

					//decode the json and turn it into a php object
					$requestContent = file_get_contents("php://input");
					$requestObject = json_decode($requestContent);

					//profile at handle is a required field
					if(empty($requestObject->profileAtHandle) === true) {
								throw(new \InvalidArgumentException("No profile @handle", 405));
					}

					//profile email is a required field
					if(empty($requestObject->profileEmail) === true) {
								throw(new \InvalidArgumentException("No profile email is present", 405));
					}

					//verify that the profile password is present
					if(empty($requestObject->profilePassword) === true) {
								throw(new \InvalidArgumentException("Must input valid password", 405));
					}

					//verify that the confirm password is present
					if(empty($requestObject->profilePasswordConfirm) === true) {
								throw(new \InvalidArgumentException("Must input valid password", 405));
					}

					//make sure the password and confirm password match
					if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
								throw(new \InvalidArgumentException("passwords do not match"));
					}
					$hash = password_hash($requestObject->profilePassword, PASSWORD_ARGON2I, ["time_cost" => 384]);

					$profileActivationToken = bin2hex(random_bytes(16));

					//create the profile object and prepare the insert into the database
					$profile = new Profile(generateUuidV4(), $profileActivationToken, $requestObject->profileAtHandle, $requestObject->profileEmail, $hash);

					//insert the profile into the database
					$profile->insert($pdo);

					//compose the email message to send with the activation token
					$messageSubject = "One step closer -- Account Activation";

					//building the activation link that can travel to another server and still work.  This is the link that will be clicked to confirm the account.
					//make sure URL is /public_html/api/activation/$activation
					$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

					//create the path
					$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;

					//create the redirect link
					$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

					//compose message to send with mail
					$message = <<< EOF
<h2>Welcome to NerdNook.</h2>
<p>In order to start checking in for events you must confirm your account</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;
					//create swift email
					$swiftMessage = new Swift_Message();

					//attach the sender to the message
					//this takes the form of an associative array where the email is the key to a real name
					$swiftMessage->setFrom(["ryguy6861@gmail.com" => "Ryan Becker"]);

					/**
					 * attach recipients to the message
					 * notice this is an array that can include or omit the recipient's name
					 * use the recipient's real name where possible;
					 * this reduces probability of the email is marked as spam
					 */
					//define who the recipient is
					$recipients = [$requestObject->profileEmail];
					//set the recipient to the swift message
					$swiftMessage->setTo($recipients);

					//attach the subject line to the email message
					$swiftMessage->setSubject($messageSubject);

					/**
					 * attach the message to the email
					 * set two versions of the message, an html formatted version and a filter_var()ed version of the message, plain text
					 * notice the tactic used is to display the entire $confirmLink to plain text
					 * this lets users who are not viewing the html content to still access the link
					 */
					//attach the html version to the message
					$swiftMessage->setBody($message, "text/html");

					//attach the plain text version of the message
					$swiftMessage->addPart(html_entity_decode($message), "text/plain");

					/**
					 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
					 * this default may or may not be available on all web hosts, consult their documentation for details
					 * SwiftMailer supports many different transport methodsl SMTP was chosen because it's the most compatible and has the best error handling
					 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
					 **/

					//setup smtp
					$smtp = new Swift_SmtpTransport(
								"localhost", 25);
					$mailer = new Swift_Mailer($smtp);

					//send the message
					$numSent = $mailer->send($swiftMessage, $failedRecipients);

					/**
					 * the send method returns the number of recipients that accepted the Email
					 * so, if the number attempted is not the number accepted, this is an exception
					 **/

					if($numSent !== count($recipients)) {
								//the $failedRecipients parameter passed in the send() method now contains an array of the Emails that failed
								throw(new RuntimeException("unable to send email", 400));

					}

					//update reply
					$reply->message = "Thank you for creating a profile with NerdNook";
		} else {

					throw(new InvalidArgumentException("invalid http request"));
		}
} catch (\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
		$reply->trace = $exception->getTraceAsString();
}

header("Content-type: application/json");
echo json_encode($reply);