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

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value for profile id
	 **/
	public function getProfileId(): void {
		return ($this->profileId);
	}


	/**
	 * mutator method for profile id
	 *
	 * @param Uuid/string $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid.e
	 */
	public function setProfileId($newProfileId): void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store profile id
		$this->profileId = $uuid;
	}

	/**
	 * accessor method for profile activation token
	 *
	 * @return string value of the activation token
	 **/
	public function getProfileActivationToken() : string {
		return ($this->profileActivationToken);
	}


	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 *
	 **/
	public function setProfileActivationToken(?string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}

		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw(new\RangeException("profile activation token has to be 32"));
		}

		// convert and store profile hash
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for at handle
	 *
	 * @return string value of at handle
	 **/
	public function getProfileAtHandle(): string {
		return ($this->profileAtHandle);
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newProfileAtHandle new value of at handle
	 * @throws \InvalidArgumentException if at handle is not a string or insecure
	 * @throws \RangeException if at handle is > 32 characters
	 * @throws \TypeError if at handle is not a string
	 **/
	public function setProfileAtHandle(string $newProfileAtHandle): void {
		// verify the at handle is secure
		$newProfileAtHandle = trim($newProfileAtHandle);
		$newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAtHandle) === true) {
			throw(new\InvalidArgumentException("profile at handle is empty or insecure"));

		}
		// verify the at handle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new\RangeException("profile at handle is too large"));
		}
		// store the at handle
		$this->profileAtHandle = $newProfileAtHandle;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of email
	 **/
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if profile email is not a valid email or insecure
	 * @throws \RangeException if profile email is > 128 characters
	 * @throws \TypeError if profile email is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail): void {
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new\InvalidArgumentException("profile email is empty or insecure"));

		}
		// verify the email will fit in the database
		if(strlen($newProfileEmail) > 128) {
			throw(new\RangeException("profile email is too large"));

		}
		// store the email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of hash
	 **/
	public function getProfileHash() {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash password
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 **/
	public function setProfileHash(string $newProfileHash): void {
		// enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new\InvalidArgumentException("profile password hash empty or insecure"));

		}

		// enforce that the hash is really an Argon Hash
		$profileHashInfo = password_get_info($newProfileHash);
		if(empty($profileHashInfo) === true) {
			throw(new\InvalidArgumentException("profile hash is not a valid hash"));

		}

		// enforce the hash is exactly 97 characters
		if(strlen($newProfileHash) !== 97) {
			throw(new\RangeException("profile hash must be 97 characters"));
		}

		// store the hash
		$this->profileHash = $newProfileHash;
	}





}