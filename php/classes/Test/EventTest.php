<?php
namespace Mpeseke\NerdNook\Test;

use CalebMHeckendorn\NerdNook\Category;
use Mpeseke\NerdNook\Event;
use Rbecker8\NerdNook\Profile;

//grab the class we want to look at
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator (still have to add this to directory)
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit Test for the Event Class
 *
 * This is a complete test because it tests the class in the case of both valid and invalid inputs for the mySQL/PDO enabled
 * methods
 *
 * @see Event
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 **/

class EventTest extends NerdNookTest {

	/**
	 * Category the Event falls under; this is for the foreign key relations
	 * @var Category category
	 */
	protected $category = null;

	/**
	 * Profile that created the Event; this is for the foreign key relations
	 * @var Profile profile
	 */
	protected $profile = null;

	/**
	 * valid profile hash to create the profile object that will own the test,
	 * this creates a valid "fake" profile to test the unit against.
	 *
	 * @var $VALID_PROFILE_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * Event Content
	 * @var string $VALID_EVENTDETAILS
	 */
	protected $VALID_EVENTDETAILS = "Event content is good.";

	/**
	 * Updated Event Content
	 * @var string $VALID_EVENTDETAILS2
	 */
	protected $VALID_EVENTDETAILS2 = "Event content is better.";

	/**
	 * Event End Date
	 * @var \DateTime $VALID_EVENTENDDATETIME
	 */
	protected $VALID_EVENTENDDATETIME = null;


	//Used the actual GPS coordinates of Active Imagination and Twin Suns Comics and Games

	/**
	 * Event Latitude Location
	 * @var float $VALID_EVENTLAT
	 */
	protected $VALID_EVENTLAT = 35.129905;

	/**
	 * Event Latitude Location
	 * @var float $VALID_EVENTLAT2
	 */
	protected $VALID_EVENTLAT2 = 35.156537;

	/**
	 * Event Longitude Location
	 * @var float $VALID_EVENTLONG
	 */
	protected $VALID_EVENTLONG = -106.514417;

	/**
	 * Event Longitude Location
	 * @var float $VALID_EVENTLONG2
	 */
	protected $VALID_EVENTLONG2 = -106.680244;

	/**
	 * Event Start Date
	 * @var \DateTime $VALID_EVENTSTARTDATETIME
	 */
	protected $VALID_EVENTSTARTDATETIME = null;

/**
 * create dependent objects before running each of our tests
 */

public final function setUp() : void {
	//run default setUp() method first
	parent::setUp();
	$password = "marlonIsAwesome1916";
	$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

	// create and insert a Profile to own the test Event
	$this->profile = new Profile(generateUuidV4(), null, "@handle", "test@iloveunittests.com", $this->VALID_PROFILE_HASH);
	$this->profile->insert($this->getPDO());

	//calc the date
	$this->VALID_EVENTENDDATETIME = new \DateTime();
	$this->VALID_EVENTSTARTDATETIME = new \DateTime();

	// create and insert a Category to own the test Event
	$this->category = new Category(generateUuidV4(), "Dungeons and Dragons", "Table Top Games");
	$this->category->insert($this->getPDO());


	}




	/**
	 * test creating a valid Event and verify that the actual mySQL data matches
	 **/

	public function testInsertValidEvent() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		//create a new Event and insert into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		// retrieve data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventCategoryId()->$this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventProfileId()->$this->profile->getEventProfileId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
	}

	/**
	 * test inserting an Event, editing, and then updating
	 **/

	public function testUpdateValidEvent(): void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("event");

		//create a new Event and insert into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//edit the Event and update in mySQL
		$event->setEventDetails($this->VALID_EVENTDETAILS2);
		$event->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS2);
		//format the date to second since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT2);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG2);
	}

	/**
	 * test creating an Event and then deleting it
	 **/
	public function testDeleteValidEvent() : void {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("event");

		//create the new Event and inject into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//delete the Event from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$event->delete($this->getPDO());

		//grab the data from mySQL and enforce that there is no spoon, oh, um Event
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertNull($pdoEvent);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("event"));
	}

	/**
	 * test grabbing an Event that does not exist; eventId
	 */

	public function testGetInvalidEventByEventId() : void {
		//grab a profile id that exceeds the maximum allowable profile Id
		$event = Event::getEventByEventId($this->getPDO(), generateUuidV4());
		$this->assertNull($event);
	}

	/**
	 * test inserting an Event and re-grabbing it from mySQL
	 **/

	public function testGetValidEventByEventProfileId() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectation
		$results = Event::getEventByEventProfileId($this->getPDO(), $event->getEventProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Mpeseke\\NerdNook\\Event", $results);

		//grab the array results and validate
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
	}
	/**
	 * test grabbing an Event that does not exist; eventProfileId
	 */

	public function testGetInvalidEventByEventProfileId(): void {
		//grab a profile id that exceeds the maximum allowable profile Id
		$event = Event::getEventByEventProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $event);
	}

	/**
	 * test grabbing an Event by eventCategoryId
	 */
	public function testGetValidEventByEventCategoryId() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and inject into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventCategoryId($this->getPDO(), $event->getEventCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		//grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
	}
	/**
	 * test grabbing an Event that does not exist; eventCategoryId
	 */
	public function testGetInvalidEventByEventCategoryId(): void {
		//grab a profile id that exceeds the max allowable profile Id
		$event = Event::getEventByEventCategoryId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $event);
	}

	/**
	 * test grabbing an Event by eventDetails
	 */
	public function testGetValidEventByEventDetails() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and inject into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//grab the event data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventDetails($this->getPDO(), $event->getEventDetails());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		//grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
	}
	/**
	 * test grabbing an Event that will NEVER exist; eventDetails
	 */
	public function testGetInvalidEventByEventDetails(): void {
		//grab a profile id that exceed the max allowable profile Id
		$event = Event::getEventByEventDetails($this->getPDO(), "Let's get together and talk about the successes of MDav!");
		$this->assertCount(0,$event);
	}

	/**
	 * test grabbing an Event by eventEndDateTime
	 */
	public function testGetValidEventByEndDateTime(): void {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("event");

		//create the new event and inject into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventEndDateTime($this->getPDO(), $event->getEventEndDateTime());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		//grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
	}

	/**
	 * test grabbing an Event that does not exist; eventEndDateTime
	 */
	public function testGetInvalidEventByEventEndDateTime() : void {
		//grab a profile id that exceed the max allowable profile Id
		$event = Event::getEventByEventEndDateTime($this->getPDO(), "null");
		$this->assertCount(0, $event);
	}

	/**
	 * test grabbing an Event by eventStartDateTime
	 */
	public function testGetValidEventByStartDateTime(): void {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("event");

		//create the new event and inject into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTLAT, $this->VALID_EVENTLONG, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventStartDateTime($this->getPDO(), $event->getEventStartDateTime());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		//grab the result from the array and validate it
		$pdoEvent = $results[0];

		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoEvent->getEventCategoryId(), $this->category->getCategoryId());
		$this->assertEquals($pdoEvent->getEventDetails(), $this->VALID_EVENTDETAILS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDateTime()->getTimestamp(), $this->VALID_EVENTENDDATETIME->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDateTime()->getTimestamp(), $this->VALID_EVENTSTARTDATETIME->getTimestamp());
		//GPS Coordinates
		$this->assertEquals($pdoEvent->getEventLat(), $this->VALID_EVENTLAT);
		$this->assertEquals($pdoEvent->getEventLong(), $this->VALID_EVENTLONG);
	}

	/**
	 * test grabbing an Event that does not exist; eventStartDateTime
	 */
	public function testGetInvalidEventByEventStartDateTime() : void {
		//grab a profile id that exceed the max allowable profile Id
		$event = Event::getEventByEventStartDateTime($this->getPDO(), "null");
		$this->assertCount(0, $event);
	}
}