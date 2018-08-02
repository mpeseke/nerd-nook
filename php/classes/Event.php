<?php


/**
 * Class Event
 *
 * This data is representative of the stored data for a Nerd Nook Event.
 *
 * @author Marlon Peseke <mpeseke@gmail.com>
 **/

class Event {

	/**
	 * Id for the event itself; this is the primary key
	 * @var Uuid $imageId
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
	 * @var DateTime $eventEndDateTime;
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
	 * id for the event Start Time
	 * @var DateTime $eventStartDateTime;
	 */
	private $eventStartDateTime;

	/** Event Constructor for Nerd Nook
	 * @param string|Uuid $newEventId the Uuid representation of the new Event
	 * @param string|Uuid $newEventProfileId the Uuid representation of the new event Creator
	 * @param string|Uuid $newEventCategoryId the Uuid representation of the new event Category
	 * @param string $newEventDetails the string value containing the event's Details
	 * @param \DateTime $newEventEndDateTime the End Time DateTime for the new Event
	 * @param float $newEventLat the latitudinal value of the new Event
	 * @param float $newEventLong the longitudinal value of the new Event
	 * @param \DateTime $newEventStartDateTime the Start Time DateTime for the new Event
	 * @throws \InvalidArgumentException if values are invalid|
	 * @throws \RangeException if the values are out of bound of the character limit|
	 * @throws \TypeError if the argument does not match the corresponding function return|
	 * @throws \Exception on any other exception
	 */

	public function __construct($newEventId, $newEventProfileId, $newEventCategoryId, string $newEventDetails,
		\DateTime $newEventEndDateTime, float $newEventLat, float $newEventLong, \DateTime $newEventStartDateTime) {
		try {
			$this->eventId = $newEventId;
			$this->eventProfileId = $newEventProfileId;
			$this->eventCategoryId = $newEventCategoryId;
			$this->eventDetails = $newEventDetails;
			$this->eventEndDateTime = $newEventEndDateTime;
			$this->eventLat = $newEventLat;
			$this->eventLong = $newEventLong;
			$this->eventStartDateTime = $newEventStartDateTime;
		} catch (\InvalidArgumentException| \RangeException| \TypeError| \Exception $exception) {
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
		public function setEventId( $newEventId) : void {
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
			return($this->eventCategoryId);
		}

		/**
		 * mutator method for the event Category Id
		 * @param Uuid|string $newEventCategoryId new value of the eventCategoryId
		 * @throws \RangeException if $newEventCategoryId is not positive
		 * @throws \TypeError if $newEventCategoryId is not a Uuid or string
		 */
		public function setEventCategoryId ( $newEventCategoryId) : void {
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
	public function setEventProfileId ( $newEventProfileId) : void {
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
		public function getEventDetails() : string {
			return($this->eventCategoryId);
		}

		/**
		 * mutator method for event Details
		 * @param string $newEventDetails new value of the eventDetails
		 * @throws \InvalidArgumentException if the values are invalid
		 * @throws \RangeException if $newEventDetails are not positive or more than 512 characters
		 * @throws \TypeError if $newEventDetails are not a string
		 */
		public function setEventDetails (string $newEventDetails) : void {
			// verify Event Details are secure
			$newEventDetails = trim($newEventDetails);
			$newEventDetails = filter_var($newEventDetails, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newEventDetails) === true){
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
		public function getEventEndDateTime() : \DateTime {
			return ($this->eventEndDateTime);
		}

		/**
		 * mutator method for event End Time
		 * @param \DateTime $newEventEndDateTime is a DateTime object
		 * @throws \InvalidArgumentException if $newEventEndDateTime is not a valid object
		 * @throws \RangeException if $newEventEndDateTime is a date that does not exist
		 */
	public function setEventEndDateTime(\DateTime $newEventEndDateTime): void {
		if(empty($newEventEndDateTime) === true) {
			throw(new \InvalidArgumentException("Event must have a valid end date and time."));
		}
		try {
			$newEventEndDateTime = self::validateDateTime($newEventEndDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
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
		public function setEventLat(float $newEventLat) : void {
				if($newEventLat < -90 || $newEventLat > 90 || empty($newEventLat) === true) {
					throw(new \RangeException("Latitude must be between -90 and 90"));
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
				throw(new \RangeException("Longitude must be between -180 and 180"));
			}
			//store new Event Longitude Location
			$this->eventLong = $newEventLong;
		}

		/**
		 * accessor method for the Event Start Time
		 * @returns \DateTime value of the event Start Time
		 */
		public function getEventStartDateTime() : \DateTime {
			return ($this->eventStartDateTime);
		}

		/**
		 * mutator method for event Start Time
		 * @param \DateTime $newEventStartDateTime is a DateTime object
		 * @throws \InvalidArgumentException if $newEventStartDateTime is not a valid object
		 * @throws \RangeException if $newEventStartDateTime is a date that does not exist
		 */
		public function setEventStartDateTime(\DateTime $newEventStartDateTime): void {
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
	/* Begin PDO Methods
	 *
	 * inserts Event into SQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL relations error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
    */

	public function insert(\PDO $pdo): void {
		//create a query template for the insert method
		$query = "INSERT INTO event(eventId, eventCategoryId, eventProfileId, eventDetails, eventEndDateTime, eventLat, eventLong, eventStartDateTime) VALUES (:eventId, :eventCategoryId, :eventProfileId, :eventDetails, :eventEndDateTime, :eventLat, :eventLong, :eventStartDateTime)";
		$statement = $pdo->prepare($query);

		//bind variables to their place in the query template
		$parameters =["eventId" => $this->eventId->getBytes(), "eventCategoryId" => $this->eventCategoryId->getBytes(), "eventProfileId" => $this->eventProfileId->getBytes(), "eventDetails" => $this->eventDetails, "eventEndDateTime" => $this->eventEndDateTime, "eventLat" => $this->eventLat, "eventLong" => $this->eventLong, "eventStartDateTime" => $this->eventStartDateTime];
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
		$query = "UPDATE event SET eventId = :eventId, eventCategoryId = :eventCategoryId, eventProfileId = :eventProfileId, eventDetails = :eventDetails, eventEndDateTime = :eventEndDateTime, eventLat = :eventLat, eventLong = :eventLong, eventStartDateTime = :eventStartDateTime WHERE eventId = :eventId";
		$statement = $pdo->prepare($query);

		//bind variable to their place in the query template
		$parameters = ["eventId" => $this->eventId->getBytes(), "eventCategoryId" => $this->eventCategoryId->getBytes(), "eventProfileId" => $this->eventProfileId->getBytes(), "eventDetails" => $this->eventDetails, "eventEndDateTime" => $this->eventEndDateTime, "eventLat" => $this->eventLat, "eventLong" => $this->eventLong, "eventStartDateTime" => $this->eventStartDateTime];
		$statement->execute($parameters);
	}


}

