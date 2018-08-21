<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use NerdCore\NerdNook\ {
	Category
};

/**
 *API for Category
 *
 *@author  Caleb Heckendorn
 *@version 1.0
 */

//verify the session, if it's not active, start it
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

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$categoryId = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$categoryName = filter_input(INPUT_GET, "categoryName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$categoryType = filter_input(INPUT_GET, "categoryType", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	//make sure that the id is valid for methods that require it
	if($method === "GET"){
		//set XSRF cookie
		setXsrfCookie();

		//gets a category using it's Id
		if(empty($categoryId) === false) {
			$reply->data = Category::getCategoryByCategoryId($pdo, $categoryId);
		} else {
			$reply->data = Category::getAllCategories($pdo)->toArray();
			}
		}
		//PUT method
//		else if($method === "PUT") {
//			//enforce that the XSRF token is present in the header
//			verifyXsrf();
//
//			//retrieves the JSON package that the front end sent, and store it in the $requestContent variable
//			$requestContent = file_get_contents("php://input");
//
//			//decode the JSON package and stores the result in $requestObject
//			$requestObject = json_decode($requestContent);
//
//			//make sure the category content is available (Required field)
//			if(empty($requestObject->categoryId) === true){
//				throw(new \InvalidArgumentException ("Category does not exist.", 405));
//			}
//			if(empty($requestObject->categoryId) === true) {
//				throw(new \InvalidArgumentException("No Category ID.", 405));
//			}
//		}
	}catch(\Exception | \TypeError $exception){
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
}

//encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

