<?php
namespace NerdCore\NerdNook;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Class Profile
 *
 * This data is representative of the stored data for a NerdNook Profile
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

class Profile implements \JsonSerializable {
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
	private $profileHash;


	/**
	 * Profile constructor
	 * @param string|Uuid $newProfileId id of this profile
	 * @param string $newProfileActivationToken string containing activation token to safe guard against malicious accounts
	 * @param string $newProfileAtHandle string containing at handle
	 * @param string $newProfileEmail string containing email
	 * @param string $newProfileHash string containing password hash
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings to long, negative integers)
	 * @throws \TypeError if data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct($newProfileId, ?string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileEmail, string $newProfileHash) {
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
	public function getProfileId(): Uuid {
		return ($this->profileId);
	}


	/**
	 * mutator method for profile id
	 *
	 * @param Uuid| string $newProfileId new value of profile id
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
	public function getProfileActivationToken() : ?string {
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
	public function getProfileHash(): string {
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
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new\InvalidArgumentException("profile hash is not a valid hash"));

		}

		// enforce the hash is exactly 97 characters
		if(strlen($newProfileHash) !== 97) {
			throw(new\RangeException("profile hash must be 97 characters"));
		}

		// store the hash
		$this->profileHash = $newProfileHash;
	}


	/**
	 * inserts this Profile into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void{
		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash) VALUES (:profileId, :profileActivationToken, :profileAtHandle, :profileEmail, :profileHash)";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this Profile in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {


				// create query template
				$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAtHandle = :profileAtHandle, profileEmail = :profileEmail, profileHash = :profileHash WHERE profileId = :profileId";
				$statement = $pdo->prepare($query);

				// bind the profile variables to the place holders in the template
				$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash];
				$statement->execute($parameters);
	}

	/**
	 * gets the Profile by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $profileId profile Id to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileId(\PDO $pdo, $profileId):?Profile {
		// sanitize the profile id before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new\PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * gets the Profile by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileEmail email to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail): ?Profile {
		// sanitize the email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_VALIDATE_EMAIL);

		if(empty($profileEmail) === true) {
			throw(new \PDOException("not a valid email"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);

		// bind the profile id to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"]);
			}
		} catch(\Exception $exception) {
			// if row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * gets the Profiles by at handle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileAtHandle at handle to search for
	 * @return \SplFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfilesByProfileAtHandle(\PDO $pdo, string $profileAtHandle): \SplFixedArray {
		// sanitize the at handle before searching
		$profileAtHandle = trim($profileAtHandle);
		$profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileAtHandle) === true) {
			throw(new\PDOException("not a valid at handle"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash FROM profile WHERE profileAtHandle = :profileAtHandle";
		$statement = $pdo->prepare($query);

		// bind the profile at handle to the place holder in the template
		$parameters = ["profileAtHandle" => $profileAtHandle];
		$statement->execute($parameters);

		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}

	/**
	 * gets the Profile by activation token
	 *
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
		// sanitize the token before searching
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new\InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}

		// create a query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);

		// bind the profile activation token to the place holder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileEmail"], $row["profileHash"]);
			}
		} catch(\Exception $exception) {
			// if row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * gets the Profile by specific at handle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileAtHandle at handle to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileAtHandle(\PDO $pdo, string $profileAtHandle): ?Profile {
		// sanitize the at handle before searching
		$profileAtHandle = trim($profileAtHandle);
		$profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($profileAtHandle) === true) {
			throw(new\PDOException("not a valid at handle"));
		}

		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash FROM profile WHERE profileAtHandle = :profileAtHandle";
		$statement = $pdo->prepare($query);

		// bind the profile at handle to the place holder in the template
		$parameters = ["profileAtHandle" => $profileAtHandle];
		$statement->execute($parameters);

		// grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"],  $row["profileEmail"], $row["profileHash"]);
			}
		} catch(\Exception $exception) {
			// if row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * format the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize.
	 **/

	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->profileId;
		$fields["profileEmail"]=$this->profileEmail;
		unset($fields["profileHash"]);
		unset($fields["profileActivationToken"]);

		return($fields);
	}
}