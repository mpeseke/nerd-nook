<?php


/**
 * Class Profile
 *
 * This data is representative of the stored data for a NerdNook Profile
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

class Profile {
	use ValidateUuid;
	/**
	 * id for Profile; this is a primary key
	 * @var Uuid $profileId
	 **/
	private $profileId;
	/**
	 * token handed out to verify that the profile is valid and not malicious
	 * @var $profileActivationToken;
	 **/
	private $profileActivationToken;
	/**
	 * at handle for this Profile; this is a unique index
	 * @var string $profileAtHandle
	 *
	 **/
	private $profileAtHandle;
	/**
	 * email for this Profile; this is a unique index
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * hash for profile password
	 * @var $profileHash
	 **/


	/**
	 * Profile constructor
	 * @param string\Uuid $newProfileId string containing id of this profile
	 * @param string $newProfileActivationToken string containing activation token to safe guard against malicious accounts
	 * @param string $newProfileAtHandle string containing at handle
	 * @param string $newProfileEmail string containing email
	 * @param string $newProfileHash string containing password hash
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings to long, negative integers)
	 * @throws \TypeError if data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(Uuid $newProfileId, ?string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, string $newProfileHash) {
			try {
				$this->setProfileId($newProfileId);
				$this->setProfileActivationToken($newProfileActivationToken);
				$this->setProfileAtHandle($newProfileAtHandle);
				$this->setProfileEmail($newProfileEmail);
				$this->setProfileHash($newProfileHash);
			} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
				// determine what exception was thrown
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
	}


}