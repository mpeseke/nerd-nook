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
	 *
	 */
}