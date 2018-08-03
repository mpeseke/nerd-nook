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
		$event = new Event($eventId, $this->profile->getProfileId(), $this->VALID_EVENTDETAILS, $this->VALID_EVENTENDDATETIME, $this->VALID_EVENTSTARTDATETIME);
		$event->insert($this->getPDO());

		// retrieve data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		//not finished
	}


}