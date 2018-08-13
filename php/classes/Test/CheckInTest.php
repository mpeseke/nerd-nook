<?php
namespace NerdCore\NerdNook\Test;


use NerdCore\NerdNook\{Category, CheckIn, Event, Profile};


//this Grabs the class we want to look at
require_once (dirname(__DIR__) . "/autoload.php");

//grabs the Uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 *
 * @see CheckIn
 * @author Caleb M Heckendorn <checkendorn@cnm.edu>
 */
class CheckInTest extends NerdNookTest{

	/**
	 * Event the person checks in to; this is for the foreign key relations
	 * @var Event event
	 */
	protected $event;
	/**
	 * profile that checks in to the event
	 * @var Profile profile
	 */
	protected $profile;
	/**
	 * @var null
	 */
	protected $category;
	/**
	 * Check in
	 * @var CheckIn $checkIn
	 **/
	protected $checkIn;
	/**
	 * valid hash to use
	 * @var null
	 */
	protected $VALID_HASH;
	/**
	 * @var \DateTime
	 */
	protected $VALID_DATETIME;
	/**
	 * @var int checkInRep
	 */
	protected $VALID_REP = 1;
	/**
	 * @var int checkInRep
	 */
	protected $VALID_REP2 = 2;
	/**
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;
	/**
	 * @var "@phpunit"
	 */
	protected $VALID_AT_HANDLE;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() : void {
//		run the default setUp() method first
		parent::setUp();

		//create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 3884]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert the mocked profile
		$this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, "@phpunit", "bob@bobspace.com", $this->VALID_HASH);
		$this->profile->insert($this->getPDO());

		//create and insert the mock category
		$this->category=new Category(generateUuidV4(), "Catan", "Board Games");
		$this->category->insert($this->getPDO());
		//create and insert the mocked event
		$this->event=new Event(generateUuidV4(), $this->category->getCategoryId(), $this->profile->getProfileId(), "This is a meet-up to...", new \DateTime(), 35.086111, -106.649944,  new \DateTime());
		$this->event->insert($this->getPDO());
		$this->VALID_DATETIME = new \DateTime();
	}

	/**
	 * test inserting valid CheckIn and verify that the actual mySQL data matches
	 */
	public function testInsertValidCheckIn() : void {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("checkIn");

		//create a new CheckIn and insert into mySQL
		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		var_dump($checkIn->getCheckInEventId()->toString());
		$checkIn->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCheckIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($this->getPDO(), $this->event->getEventId(), $this->profile->getProfileId());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertEquals($pdoCheckIn->getCheckInEventId(), $this->event->getEventId());
		$this->assertEquals($pdoCheckIn->getCheckInProfileId(), $this->profile->getProfileId());

		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_DATETIME->getTimestamp());

		$this->assertEquals($pdoCheckIn->getCheckInRep(), $this->VALID_REP);
	}

	/**
	 * test updating valid check in
	 */
	public function testUpdateValidCheckIn() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME->getTimestamp(), $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$checkIn->setCheckInRep($this->VALID_REP2);
		$checkIn->update($this->getPDO());

		$pdoCheckIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($this->getPDO(), $this->event->getEventId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInEventId(), $this->event->getEventId());
		$this->assertEquals($pdoCheckIn->getCheckInProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_DATETIME);
		$this->assertEquals($pdoCheckIn->getCheckInRep(), $this->VALID_REP2);
	}

	/**
	 *
	 */
	public function testDeleteValidCheckIn() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$checkIn->delete($this->getPDO());

		$pdoCheckIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($this->getPDO(), $this->event->getEventId(), $this->profile->getProfileId());
		$this->assertNull($pdoCheckIn);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("checkIn"));
	}

	/**
	 *
	 */
	public function getValidCheckInByEventId() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$results = CheckIn::getCheckInByCheckInEventId($this->getPDO(), $this->event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("NerdCore\\NerdNook\\CheckIn", $results);

		$pdoCheckIn = $results[0];

		$this->assertEquals($pdoCheckIn->getCheckInEventId(), $this->event->getEventId());
		$this->assertEquals($pdoCheckIn->getCheckInProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_DATETIME);
		$this->assertEquals($pdoCheckIn->getCheckInRep(), $this->VALID_REP);
	}

	/**
	 *
	 */
	public function getInvalidCheckInByEventId(): void {
		$checkIn = CheckIn::getCheckInByCheckInEventId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $checkIn);
	}

	/**
	 *
	 */
	public function getValidCheckInByProfileId() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$results = CheckIn::getCheckInByCheckInProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("NerdCore\\NerdNook\\CheckIn", $results);

		$pdoCheckIn = $results[0];

		$this->assertEquals($pdoCheckIn->getCheckInEventId(), $this->event->getEventId());
		$this->assertEquals($pdoCheckIn->getCheckInProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_DATETIME);
		$this->assertEquals($pdoCheckIn->getCheckInRep(), $this->VALID_REP);
	}

	/**
	 *
	 */
	public function getInvalidCheckInByProfileId(): void {
		$checkIn = CheckIn::getCheckInByCheckInProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $checkIn);
	}
}