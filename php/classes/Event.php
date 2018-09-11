<?php
namespace NerdCore\NerdNook;
require_once ("autoload.php");
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Class Event
 *
 * This data is representative of the stored data for a Nerd Nook Event.
 *
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 **/

class Event implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * Id for the event itself; this is the primary key
	 * @var Uuid $eventId
	 */
	private $eventId;

	/**
	 * id for the event Category; foreign key
	 * @var Uuid $eventCategoryId
	 */
	private $eventCategoryId;

	/**
	 * id of the event creator; foreign key
	 * @var Uuid $eventProfileId
	 */
	private $eventProfileId;

	/**
	 * id for the event's Details
	 * @var string $eventDetails
	 */
	private $eventDetails;

	/**
	 * id for the event's End Time
	 * @var $eventEndDateTime ;
	 */
	private $eventEndDateTime;

	/**
	 * id for the event location, listed in latitude
	 * @var float $eventLat
	 */
	private $eventLat;

	/**
	 * id for the event location, listed in longitude
	 * @var float $eventLong
	 */
	private $eventLong;


	/**
	 * id for the event Name
	 * @var $eventName
	 */
	private $eventName;

	/**
	 * id for the event Start Time
	 * @var  $eventStartDateTime ;
	 */
	private $eventStartDateTime;


	/** Event Constructor for Nerd Nook
	 * @param string|Uuid $newEventId the Uuid representation of the new Event
	 * @param string|Uuid $newEventCategoryId the Uuid representation of the new event Category
	 * @param string|Uuid $newEventProfileId the Uuid representation of the new event Creator
	 * @param string $newEventDetails the string value containing the event's Details
	 * @param \DateTime|string $newEventEndDateTime the End Time DateTime for the new Event
	 * @param float $newEventLat the latitudinal value of the new Event
	 * @param float $newEventLong the longitudinal value of the new Event
	 * @param string $newEventName the name of the new Event
	 * @param \DateTime|string $newEventStartDateTime the Start Time DateTime for the new Event
	 * @throws \InvalidArgumentException if values are invalid|
	 * @throws \RangeException if the values are out of bound of the character limit|
	 * @throws \TypeError if the argument does not match the corresponding function return|
	 * @throws \Exception on any other exception
	 */

	public function __construct($newEventId, $newEventCategoryId, $newEventProfileId, string $newEventDetails, $newEventEndDateTime, float $newEventLat, float $newEventLong, string $newEventName, $newEventStartDateTime) {
		try {
			$this->setEventId($newEventId);
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventProfileId($newEventProfileId);
			$this->setEventDetails($newEventDetails);
			$this->setEventEndDateTime($newEventEndDateTime);
			$this->setEventLat($newEventLat);
			$this->setEventLong($newEventLong);
			$this->setEventName($newEventName);
			$this->setEventStartDateTime($newEventStartDateTime);
		} catch(\InvalidArgumentException| \RangeException| \TypeError| \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for the event Id
	 * @return Uuid value of the event
	 **/
	public function getEventId(): Uuid {
		return ($this->eventId);
	}

	/**
	 * mutator function for the event Id
	 * @param Uuid|string $newEventId new value of the Event
	 * @throws \RangeException if $newEventId is not positive
	 * @throws \TypeError if $newEventId is not a Uuid or string
	 */
	public function setEventId($newEventId): void {
		try {
			$uuid = self::validateUuid($newEventId);
		} catch(\RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the event Id
		$this->eventId = $uuid;
	}

	/**
	 * accessor method for the event Category Id
	 * @return Uuid value of the event Category
	 */
	public function getEventCategoryId(): Uuid {
		return ($this->eventCategoryId);
	}

	/**
	 * mutator method for the event Category Id
	 * @param Uuid|string $newEventCategoryId new value of the eventCategoryId
	 * @throws \RangeException if $newEventCategoryId is not positive
	 * @throws \TypeError if $newEventCategoryId is not a Uuid or string
	 */
	public function setEventCategoryId($newEventCategoryId): void {
		try {
			$uuid = self::validateUuid($newEventCategoryId);
		} catch(\RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//converts and stores the event Category Id
		$this->eventCategoryId = $uuid;
	}

	/**
	 * accessor method for the event profile Id
	 * @return Uuid value of the event profile Id
	 */
	public function getEventProfileId(): Uuid {
		return ($this->eventProfileId);
	}

	/**
	 * mutator method for the event profile Id
	 * @param Uuid|string $newEventProfileId new value of the eventProfileId
	 * @throws \RangeException if $newEventProfileId is not positive
	 * @throws \TypeError if $newEventProfileId is not a Uuid or string
	 */
	public function setEventProfileId($newEventProfileId): void {
		try {
			$uuid = self::validateUuid($newEventProfileId);
		} catch(\RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//converts and stores the event Profile Id
		$this->eventProfileId = $uuid;
	}

	/**
	 * accessor method for the event Details
	 * @return string value of the event Details
	 */
	public function getEventDetails(): string {
		return ($this->eventCategoryId);
	}

	/**
	 * mutator method for event Details
	 * @param string $newEventDetails new value of the eventDetails
	 * @throws \InvalidArgumentException if the values are invalid
	 * @throws \RangeException if $newEventDetails are not positive or more than 512 characters
	 * @throws \TypeError if $newEventDetails are not a string
	 */
	public function setEventDetails(string $newEventDetails): void {
		// verify Event Details are secure
		$newEventDetails = trim($newEventDetails);
		$newEventDetails = filter_var($newEventDetails, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventDetails) === true) {
			throw(new \InvalidArgumentException("Event details are empty or includes insecure data."));
		}
		//verify content will fit into the database
		if(strlen($newEventDetails) > 512) {
			throw(new \RangeException("Please limit event details to 512 characters or less."));
		}
		//store Detail content
		$this->eventDetails = $newEventDetails;
	}

	/**
	 * accessor method for the Event End Time
	 * @returns \DateTime value of the event End Time
	 */
	public function getEventEndDateTime(): \DateTime{
		return ($this->eventEndDateTime);
	}

	/**
	 * mutator method for event End Time
	 * @param \DateTime|string $newEventEndDateTime is a DateTime object
	 * @throws \InvalidArgumentException if $newEventEndDateTime is not a valid object
	 * @throws \RangeException if $newEventEndDateTime is a date that does not exist
	 * @throws \TypeError on invalid format
	 * @throws \Exception on all other exceptions
	 */
	public function setEventEndDateTime( $newEventEndDateTime): void {
		if(empty($newEventEndDateTime) === true) {
			throw(new \TypeError("Date is not formatted correctly."));
		}
		try {
			$newEventEndDateTime = self::validateDateTime($newEventEndDateTime);
		} catch(\InvalidArgumentException | \RangeException | \TypeError |\Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//store the new Event End Time
		$this->eventEndDateTime = $newEventEndDateTime;
	}

	/**
	 * accessor method for new Event Latitude location
	 * @returns float value of the Latitudinal location
	 */
	public function getEventLat(): float {
		return ($this->eventLat);
	}

	/**
	 * mutator method for the new Event Latitude location
	 * @param float $newEventLat is a float object
	 * @throws \TypeError if $newEventLat is not a float
	 * @throws \RangeException if $newEventLat is less than -90, more than 90, or empty string
	 */
	public function setEventLat(float $newEventLat): void {
		if($newEventLat < -90 || $newEventLat > 90 || empty($newEventLat) === true) {
			throw(new \RangeException("Latitude must be between -90 and 90 and must be a float."));
		}
		//Store new Event Latitude value
		$this->eventLat = $newEventLat;
	}

	/**
	 * accessor method for new Event Longitude location
	 * @returns float value of the Longitudinal location
	 */
	public function getEventLong(): float {
		return $this->eventLong;
	}

	/**
	 * mutator method for the new Event Longitude location
	 * @param float $newEventLong is a float object
	 * @throws \TypeError if $newEventLong is not a float
	 * @throws \RangeException if $newEventLong is less than -180, more than 180, or empty string
	 */
	public function setEventLong(float $newEventLong): void {
		if($newEventLong < -180 || $newEventLong > 180 || empty($newEventLong) === true) {
			throw(new \RangeException("Longitude must be between -180 and 180 and must be a float."));
		}
		//store new Event Longitude Location
		$this->eventLong = $newEventLong;
	}

	/** accessor method for the Event Name
	 *@returns \string value of the event Name
	 */

	public function getEventName(): \string {
		return ($this->getEventName);
	}

	/**
	 *mutator method for the Event Name
	 *@param \string $newEventName is a string object
	 *@throws \InvalidArgumentException if $newEventName is not a valid object
	 *@throws \RangeException if $newEventName has more than 36 characters
	 *@throws \TypeError if the data type is not a string
	 *@throws \Exception on all other exceptions
	 */

	public function setEventName(string $newEventName): void {
		// verify Event Details are secure
		$newEventName = trim($newEventName);
		$newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventDetails) === true) {
			throw(new \InvalidArgumentException("Event details are empty or includes insecure data."));
		}
		//verify content will fit into the database
		if(strlen($newEventName) > 36) {
			throw(new \RangeException("Please limit event details to 36 characters or less."));
		}
		//store Detail content
		$this->eventName = $newEventName;
	}

	/**
	 * accessor method for the Event Start Time
	 * @returns \DateTime value of the event Start Time
	 */
	public function getEventStartDateTime(): \DateTime {
		return ($this->eventStartDateTime);
	}

	/**
	 * mutator method for event Start Time
	 * @param \DateTime|string $newEventStartDateTime is a DateTime object
	 * @throws \InvalidArgumentException if $newEventStartDateTime is not a valid object
	 * @throws \RangeException if $newEventStartDateTime is a date that does not exist
	 * @throws \Exception on all other Exceptions
	 */
	public function setEventStartDateTime( $newEventStartDateTime): void {
		if(empty($newEventStartDateTime) === true) {
			throw(new \InvalidArgumentException("Event must have a valid start date and time."));
		}
		try {
			$newEventStartDateTime = self::validateDateTime($newEventStartDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->eventStartDateTime = $newEventStartDateTime;
	}

	/**
	 * Begin PDO Methods
	 */

	/**
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL relations error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo): void {
		//create a query template for the insert method
		$query = "INSERT INTO event(eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventName, eventStartDateTime) 
								VALUES (:eventId, :eventCategoryId, :eventProfileId, :eventDetails, :eventEndDateTime, :eventLat, :eventLong, :eventName, :eventStartDateTime)";
		$statement = $pdo->prepare($query);

		//bind variables to their place in the query template
		$parameters = ["eventId" => $this->eventId->getBytes(), "eventCategoryId" => $this->eventCategoryId->getBytes(),
			"eventProfileId" => $this->eventProfileId->getBytes(), "eventDetails" => $this->eventDetails,
			"eventEndDateTime" => $this->eventEndDateTime->format("Y-m-d H:i:s.u"), "eventLat" => $this->eventLat, "eventLong" => $this->eventLong,
			"eventName" => $this->eventName, "eventStartDateTime" => $this->eventStartDateTime->format("Y-m-d H:i:s.u")];
		$statement->execute($parameters);
	}

	/**
	 * deletes the Event from SQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo): void {
		//create query template for the delete method
		$query = "DELETE FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		//bind variables to their place in the query template
		$parameters = ["eventId" => $this->eventId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates the Event in SQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function update(\PDO $pdo): void {
		//create query template for the update method
		$query = "UPDATE event SET eventId = :eventId, eventCategoryId = :eventCategoryId, eventProfileId = :eventProfileId, 
		eventDetails = :eventDetails, eventEndDateTime = :eventEndDateTime, eventLat = :eventLat, eventLong = :eventLong, 
		eventName = :eventName, eventStartDateTime = :eventStartDateTime WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		//bind variable to their place in the query template
		$parameters = ["eventId" => $this->eventId->getBytes(), "eventCategoryId" => $this->eventCategoryId->getBytes(),
			"eventProfileId" => $this->eventProfileId->getBytes(), "eventDetails" => $this->eventDetails, "eventEndDateTime" => $this->eventEndDateTime->format("Y-m-d H:i:s.u"),
			"eventLat" => $this->eventLat, "eventLong" => $this->eventLong, "eventName" => $this->eventName, "eventStartDateTime" => $this->eventStartDateTime->format("Y-m-d H:i:s.u")];
		$statement->execute($parameters);
	}

	// Writing getFooByBars for Event Class

	/**
	 * get the Event using the eventId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $eventId , the Id of the event we want to search for
	 * @return Event|Null if no such event exists
	 * @throw \PDOException when mySQL related errors occur
	 * @throw \TypeError when the variable is not the correct data type
	 */

	public static function getEventByEventId(\PDO $pdo, $eventId): ?Event {
		//sanitize the eventId before searching
		try {
			$eventId = self::validateUuid($eventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// creating query template

		$query = "SELECT eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventName, eventStartDateTime FROM event WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		//binding the eventId to the placeholders in the template
		$parameters = ["eventId" => $eventId->getBytes()];
		$statement->execute($parameters);

		//retrieve the event from mySQL
		try {
			$event = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$event = new Event($row["eventId"], $row["eventCategoryId"], $row["eventProfileId"], $row["eventDetails"], $row["eventEndDateTime"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventStartDateTime"]);
			}
		} catch(\Exception $exception) {
			//if the new row cannot be converted, throw it again
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($event);
	}

	/**
	 * get the Event by its CategoryId
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $eventCategoryId
	 * @return \SplFixedArray
	 * @throws \PDOException
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getEventByEventCategoryId(\PDO $pdo, $eventCategoryId) : \SplFixedArray {
		//sanitize the string $eventCategoryId before handling
		try {
			$eventCategoryId = self::validateUuid($eventCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create a query template
		$query = "SELECT eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventName, eventStartDateTime FROM event WHERE eventCategoryId = :eventCategoryId";
		$statement = $pdo->prepare($query);
		//bind the event Category Id to the placeholder in the template
		$parameters = ["eventCategoryId" => $eventCategoryId->getBytes()];
		$statement->execute($parameters);
		// builds an array of Events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventCategoryId"], $row["eventProfileId"], $row["eventDetails"], $row["eventEndDateTime"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventStartDateTime"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				//if the row cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(),0, $exception));
			}
		}
		return($events);
	}

	/**
	 * get the Event by its ProfileId
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $eventProfileId
	 * @return \SplFixedArray
	 * @throws \PDOException
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getEventByEventProfileId(\PDO $pdo, $eventProfileId) : \SplFixedArray {
		//sanitize the string $eventProfileId before handling
		try {
			$eventProfileId = self::validateUuid($eventProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create a query template
		$query = "SELECT eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventName, eventStartDateTime FROM event WHERE eventProfileId = :eventProfileId";
		$statement = $pdo->prepare($query);
		//bind the event Profile Id to the placeholder in the template
		$parameters = ["eventProfileId" => $eventProfileId->getBytes()];
		$statement->execute($parameters);
		// builds an array of Events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventCategoryId"], $row["eventProfileId"], $row["eventDetails"], $row["eventEndDateTime"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventStartDateTime"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				//if the row cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(),0, $exception));
			}
		}
		return($events);
		}

	/**
	 * get Event by the Event Name
	 * @param \PDO $pdo connection object
	 * @return \
	 */

	/**
	 * get Event by Event Date Range
	 * @param \PDO $pdo connection object
	 * @return \SplFixedArray of all the events within a given range
	 * @throws \PDOException
	 * @throws \TypeError when variables are not the correct data type
	*/

	public static function getEventByDateRange(\PDO $pdo) : \SplFixedArray {
		$query = "SELECT eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventName, eventStartDateTime 
						FROM event WHERE eventStartDateTime > now()";
		$statement = $pdo->prepare($query);
		//bind the variables to their place holders
		$statement->execute();

		//builds an array of Events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				new Event($row["eventId"], $row["eventCategoryId"], $row["eventProfileId"], $row["eventDetails"], $row["eventEndDateTime"], $row["eventLat"], $row["eventLong"], $row["eventName"], $row["eventStartDateTime"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				//if cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($events);
	}

/*
	public static function getEventByEventEndTime(\PDO $pdo, $eventEndDateTime) : \SplFixedArray {
		//sanitize the \DateTime $eventEndDateTime before handling
		try {
			$eventEndDateTime = self::validateDateTime($eventEndDateTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(),0, $exception));
		}

		//create a query template
		$query = "SELECT eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventStartDateTime FROM event WHERE eventEndDateTime = :eventEndDateTime";
		$statement = $pdo->prepare($query);
		//bind the event End Date Id to the placeholder in the template
		$parameters = ["eventEndDateTime" => $eventEndDateTime->getTimestamp()];
		$statement->execute(($parameters));
		//builds an array of Events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventCategoryId"], $row["eventProfileId"], $row["eventDetails"], $row["eventEndDateTime"], $row["eventLat"], $row["eventLong"], $row["eventStartDateTime"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				//if cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return range($eventEndDateTime, $eventEndDateTime);
	}
*/

/*
	public static function getEventByEventStartDateTime(\PDO $pdo, $eventStartDateTime) : \SplFixedArray {
		//sanitize the \DateTime $eventStartDateTime before handling
		try {
			$eventStartDateTime = self::validateDateTime($eventStartDateTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(),0, $exception));
		}

		//create a query template
		$query = "SELECT eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventStartDateTime FROM event WHERE eventStartDateTime = :eventStartDateTime";
		$statement = $pdo->prepare($query);
		//bind the event Start Date Id to the placeholder in the template
		$parameters = ["eventStartDateTime" => $eventStartDateTime->getTimestamp()];
		$statement->execute(($parameters));
		//builds an array of Events
		$events = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$event = new Event($row["eventId"], $row["eventCategoryId"], $row["eventProfileId"], $row["eventDetails"], $row["eventEndDateTime"], $row["eventLat"], $row["eventLong"], $row["eventStartDateTime"]);
				$events[$events->key()] = $event;
				$events->next();
			} catch(\Exception $exception) {
				//if cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return range($eventStartDateTime, $eventStartDateTime);
	}
*/

	/**
	 * format the state variables for JSON serialization
	 * @return array resulting state variables to serialize.
	 */

	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["eventId"] = $this->eventId->toString();
		$fields["eventCategoryId"] = $this->eventCategoryId->toString();
		$fields["eventProfileId"] = $this->eventProfileId->toString();

		//format the date for front end consumption
		$fields["eventEndDateTime"] = round(floatval($this->eventEndDateTime->format("U.u")) * 1000);
		$fields["eventStartDateTime"] = round(floatval($this->eventStartDateTime->format("U.u")) * 1000);
		return($fields);
		}
	}

