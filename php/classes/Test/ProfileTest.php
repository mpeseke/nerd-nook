<?php

namespace Rbecker8\NerdNook\Test;

use Mpeseke\NerdNook\Test\NerdNookTest;
use Rbecker8\NerdNook\Profile;



// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2). "../lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class.  It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs
 *
 * @see Profile
 * @author Ryan Becker <rbecker8@cnm.edu>
 **/

class ProfileTest extends NerdNookTest {
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 *
	 *
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid at handle to use
	 * @var string $VALID_ATHANDLE
	 **/
	protected $VALID_ATHANDLE = "@phpunit";

	/**
	 * second valid at handle to use
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_ATHANDLE2 = "@passingtests";

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.de";

	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 **/
	protected $VALID_HASH;




	/**
	 * run the default setup operation to create salt and hash
	 **/
	public final function setUp(): void {
			parent::setUp();

			//
			$password = "abc123";
			$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
			$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid profile and verify the actual mySQL data matches
	 **/
	public function testInsertValidProfile(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();

		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our exceptions
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}


	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert it into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		//edit the Profile and update it in mySQL
		$profile->setProfileAtHandle($this->VALID_ATHANDLE2);
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}


	/**
	 * test creating and then deleting it
	 **/
	public function testDeleteValidProfile() : void {
		// count the number or rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expecations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}

	/**
	 * test grabbing a Profile that does not exist
	 **/
	public function testGetInvalidProfileByProfileId(): void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeProfileId = generateUuidV4();
		$profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId);
		$this->assertNull($profile);
	}

	public function testGetValidProfileByAtHandle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		// grab the data from mySQL
		$results = Profile::getProfileByProfileAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		//enforce the results meet expectations
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}

	/**
	 * test grabbing a Profile by at handle that does not exist
	 **/
	public function testGetInvalidProfileByAtHandle(): void {
		// grab an at handle that does not exist
		$profile = Profile::getProfileByProfileAtHandle($this->getPDO(), "@doesnotexist");
		$this->assertCount(0, $profile);
	}

	/**
	 * test grabbing a Profile by email
	 **/
	public function testGetProfileByEmail() :  void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}

	/**
	 * test grabbing a Profile by an email that does not exist
	 **/
	public function testGetInvalidProfileByEmail() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a profile by its activation
	 **/
	public function testGetValidProfileByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		$profileId = genereateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_EMAIL, $this->VALID_HASH);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}

	/**
	 * test grabbing a Profile by an email that does not exist
	 **/
	public function testGetInvalidProfileActivation() : void {
		// grab an email that does not exist
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "6675636b646f6e616c646472756d7066");
		$this->assertNull($profile);
	}
}