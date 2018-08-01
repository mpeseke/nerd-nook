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
	 * id of the event creator; foreign key
	 * @var Uuid $eventProfileId
	 */
	private $eventProfileId;

	/**
	 * id for the event Category; foreign key
	 * @var Uuid $eventCategoryId
	 */
	private $eventCategoryId;

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
	 * id for the event location, listed in latitude and longitude
	 * @var float $eventLat
	 * @var float $eventLong
	 */
	private $eventLat;

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
		 * accessor method fo the event Id
		 * @return Uuid value of the event
		 **/
		public function getEventId(): Uuid {
			return ($this->eventId);
		}

		/** mutator function for the event Id
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
		 * accessor method for the event profile Id
		 * @return Uuid value of the event profile Id
		 */
		public function getEventProfileId(): Uuid {
			return ($this->eventProfileId);
		}

		/** mutator method for the event profile Id
		 * @param string $newEventProfileId new value of the EventProfileId
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

}