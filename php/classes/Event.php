<?php

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
	 * id for the event location
	 */
}