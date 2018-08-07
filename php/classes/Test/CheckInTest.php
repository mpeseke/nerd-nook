<?php
namespace CalebMHeckendorn\NerdNook\Test;

use CalebMHeckendorn\NerdNook\{CheckIn, Event, Profile};


//this Grabs the class we want to look at
require_once (dirname(__DIR__)) . "/autoload.php";

//grabs the Uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 *
 * @see CheckIn
 * @author Caleb M Heckendorn <checkendorn@cnm.edu>
 */
class CheckInTest extends NerdNookTest{

	/**
	 * Event the person checks in to; this is for the foreign key relations3
	 * @var Event event
	 */
	protected $event;
	/**
	 * @var null
	 */
	protected $profile;
	protected $VALID_HASH;
	protected $VALID_DATETIME;
	protected $VALID_REP = 10;
	protected $VALID_REP2 = 20;
	protected $VALID_ACTIVATION;

	public final function setUp(): void {
		parent::setUp();
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
		$this->profile = new Profile(generateUuidV4(), null, "@phpunit", "bob@bobspace.com");
		$this->profile->insert($this->getPDO());
		$this->VALID_DATETIME = new \DateTime();
		$this->event=new Event(generateUuidV4(), null, null, "This is a meet-up to...", "6:00", "35.086111", "-106.649944", "2:00");
	}
	public function testInsertValidCheckIn() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$pdoCheckIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($this->getPDO(), $this->event->getEventId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInEventId(), $this->event->getEventId());
		$this->assertEquals($pdoCheckIn->getCheckInProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimeStamp(), $this->VALID_DATETIME->getTimestamp());
		$this->assertEquals($pdoCheckIn->getCheckInRep(), $this->VALID_REP);
	}

	public function testUpdateValidCheckIn() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$checkIn->setCheckInRep($this->VALID_REP2);
		$checkIn->update($this->getPDO());

		$pdoCheckIn = CheckIn::getCheckInByCheckInEventIdAndCheckInProfileId($this->getPDO(), $this->event->getEventId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInEventId(), $this->event->getEventId());
		$this->assertEquals($pdoCheckIn->getCheckInProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimeStamp(), $this->VALID_DATETIME->getTimestamp());
		$this->assertEquals($pdoCheckIn->getCheckInRep(), $this->VALID_REP2);
	}

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

	public function getValidCheckInByEventId() : void {
		$numRows = $this->getConnection()->getRowCount("checkIn");

		$checkIn = new CheckIn($this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_DATETIME, $this->VALID_REP);
		$checkIn->insert($this->getPDO());

		$results = CheckIn::getCheckInByCheckInEventId($this->getPDO(), $this->event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));


	}
	public function getInvalidCheckInByEventId
		public function getValidCheckInByProfileId
	public function getInvalidCheckInByProfileId
}