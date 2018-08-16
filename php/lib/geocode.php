<?php
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once ("etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * function to get latitude and longitude by address
 * insert address, return the lat and long...
 *
 * @param string $eventAddress address the event is being held
 * @throws \InvalidArgumentException if $address is not a string or is insecure
 *
 * @return \stdClass $reply
 */

function getCordsByAddress ($eventAddress) : \stdClass {
	if(empty($eventAddress) === true) {
		throw(new \InvalidArgumentException("Address content is empty or not secure."));
	}
	$eventAddress = filter_var($eventAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	$url = "https://maps.googleapis.com/maps/api/geocode/json";
		$config = readConfig("/etc/apache2/capstone-mysql/nerdnook.ini");
		$api = $config["google"];

		$json = file_get_contents($url . '?address=' . urlencode($eventAddress) . "&key=" . $api);
		$jsonObject = json_decode($json);
		$lat = $jsonObject->results[0]->geometry->location->lat;
		$long = $jsonObject->results[0]->geometry->location->long;
		$reply = new stdClass();
		$reply->lat = $lat;
		$reply->long = $long;

		return $reply;
	}

	/**
	 * function to get address by latitude and longitude
	 *
	 * @param float $eventLat event address
	 * @param float $eventLong event address
	 * @throws \InvalidArgumentException if $eventLat or $eventLong is not a float or is insecure
	 *
	 * @return \stdClass $reply
	 */

	function getAddressByCords($eventLat, $eventLong) : \stdClass {
		if(empty($eventLat) or empty($eventLong) === true) {
			throw new(\InvalidArgumentException("Address content is empty"));
		}

		$url = "https://maps.googleapis.com/maps/api/geocode/json";
		$config = readConfig("/etc/apache2/capstone-mysql/nerdnook.ini");
		$api = $config["google"];

		$json = file_get_contents($url . "?latlng=" . $eventLat . "," . $eventLong . "&key=" . $api);
		$jsonObject = json_decode($json);
		$eventAddress = $jsonObject->results[0]->formatted_address;
		$reply = new \stdClass();
		$reply->formatted_address = $eventAddress;

		return $reply;
	}

