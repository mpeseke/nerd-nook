<?php

namespace Rbecker8\NerdNook\Test;

use Mpeseke\NerdNook\Test\NerdNookTest;
use Rbecker8\NerdNook\Profile;



// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2). "/lib/uuid.php");

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
			$password = "abc123"
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
		$pdoProfile = Profile::getProfileByProfileId(), $profile->getProfileId();
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
	}








}