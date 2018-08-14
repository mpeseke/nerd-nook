<?php

namespace NerdCore\NerdNook;
require_once ("autoload.php");

require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 *
 * @author Caleb Heckendorn <checkendorn@cnm.edu>
 * @version 1.0
 */
class CheckIn implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/** id for the check in profile id; this is a foreign key
	 * @var Uuid $checkInProfileId
	 */
	private $checkInProfileId;
	/**
	 * id for the check in event id; this is a foreign key
	 * @var Uuid $checkInEventId
	 */
	private $checkInEventId;
	/**
	 * @var \DateTime $checkInDateTime ;
	 */
	private $checkInDateTime;
	/**
	 * @var int $checkInRep
	 */
	private $checkInRep;

	/**
	 * CheckIn constructor.
	 * @param string|Uuid $newCheckInEventId id of the parent Event
	 * @param string|Uuid $newCheckInProfileId id of the parent Profile
	 * @param \DateTime|null $newCheckInDateTime date the person checked in or null if current time
	 * @param integer $newCheckInRep integer to keep track of a profiles reputation
	 *
	 * @throws \InvalidArgumentException if data types aren't valid
	 * @throws \RangeException if data types are out of bounds
	 * @throws \TypeError if data violates type hints
	 * @throws \Exception if some other exception is thrown
	 */
	public function __construct($newCheckInEventId, $newCheckInProfileId, $newCheckInDateTime = null, $newCheckInRep) {
		try {
			$this->setCheckInEventId($newCheckInEventId);
			$this->setCheckInProfileId($newCheckInProfileId);
			$this->setCheckInDateTime($newCheckInDateTime);
			$this->setCheckInRep($newCheckInRep);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for event id
	 *
	 * @return Uuid value of event id
	 */
	public function getCheckInEventId(): Uuid {
		return ($this->checkInEventId);
	}

	/**
	 * mutator method for check in event id
	 *
	 * @param string $newCheckInEventId new value of event id
	 * @throws \RangeException if $newEventId is not positive
	 * @throws \TypeError if $newEventId is not an integer
	 */
	public function setCheckInEventId($newCheckInEventId): void {
		try {
			$uuid = self::validateUuid($newCheckInEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception| \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the check in event id
		$this->checkInEventId = $uuid;
	}

	/**
	 * accessor method for profile id
	 *
	 * @return uuid value of profile id
	 **/
	public function getCheckInProfileId(): Uuid {
		return ($this->checkInProfileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param string $newCheckInProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newCheckInProfileId is not an integer
	 */
	public function setCheckInProfileId($newCheckInProfileId): void {
		try {
			$uuid = self::validateUuid($newCheckInProfileId);
		} catch(\RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the check in profile id
		$this->checkInProfileId = $uuid;
	}

	/**
	 * accessor method for check in date time
	 *
	 * @return \DateTime value of check in date time
	 */
	public function getCheckInDateTime(): \DateTime {
		return ($this->checkInDateTime);
	}

	/**
	 * mutator method for check in date time
	 *
	 * @param \DateTime|string|null $newCheckInDateTime check in date time as a DateTime object or a string
	 * @throws \InvalidArgumentException if $newCheckInDateTime is not a valid object or string
	 * @throws \RangeException if $newCheckInDateTime is a date that does not exist
	 * @throws \Exception on all other exceptions
	 */
	public function setCheckInDateTime($newCheckInDateTime): void {
		//if the date is null, use current date and time
		if($newCheckInDateTime === null) {
			$this->checkInDateTime = new \DateTime();
			return;
		}
		//store the check in date using the ValidateDateTime trait
		try {
			$newCheckInDateTime = self::validateDateTime($newCheckInDateTime);
		} catch(\InvalidArgumentException |\RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the check in date time
		$this->checkInDateTime = $newCheckInDateTime;
	}

	/**
	 * accessor method for check in rep
	 *
	 * @return int value of check in rep
	 */
	public function getCheckInRep(): int {
		return ($this->checkInRep);
	}

	/**
	 * mutator method for check in rep
	 *
	 * @param int $newCheckInRep new value of check in rep
	 * @throws \RangeException if $newCheckInRep is less than 0
	 * @throws \TypeError if $newCheckInRep is not a int
	 */
	public function setCheckInRep($newCheckInRep): void {
		if($newCheckInRep < 0) {
			throw(new \RangeException("cannot be less than 0"));
		}

		//convert and store the check in rep
		$this->checkInRep = $newCheckInRep;
	}

	/**
	 * inserts this CheckIn into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors happen
	 **/
	public function insert(\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO checkIn (checkInEventId, checkInProfileId,  checkInDateTime, checkInRep)VALUES(:checkInEventId, :checkInProfileId, :checkInDateTime, :checkInRep)";
		$statement = $pdo->prepare($query);

		$formattedDate = $this->checkInDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["checkInEventId" => $this->checkInEventId->getBytes(), "checkInProfileId" => $this->checkInProfileId->getBytes(), "checkInDateTime" => $formattedDate, "checkInRep" => $this->checkInRep];
		$statement->execute($parameters);
	}

	/**
	 * updates the CheckIn from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors happen
	 */
	public function update(\PDO $pdo): void {
		//create query template
		$query = "UPDATE checkIn SET checkInEventId = :checkInEventId, checkInProfileId = :checkInProfileId, checkInDateTime = :checkInDateTime, checkInRep = :checkInRep WHERE checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$formattedDate = $this->checkInDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["checkInEventId" => $this->checkInEventId->getBytes(), "checkInProfileId" => $this->checkInProfileId->getBytes(), "checkInDateTime" => $formattedDate, "checkInRep" => $this->checkInRep];
		$statement->execute($parameters);
	}

	/**
	 * deletes the CheckIn from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM checkIn WHERE checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);

		$parameters = ["checkInProfileId" => $this->checkInProfileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the check in by event id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $checkInEventId event id to search for
	 * @param string $checkInProfileId profile id to search for
	 * @return CheckIn|null CheckIn found or null if not found
	 */
	public static function getCheckInByCheckInEventIdAndCheckInProfileId(\PDO $pdo, string $checkInEventId, string $checkInProfileId): ?CheckIn {
		//sanitize the profile id before searching
		try {
			$checkInEventId = self::validateUuid($checkInEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		try {
			$checkInProfileId = self::validateUuid($checkInProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT checkInEventId, checkInProfileId, checkInDateTime, checkInRep FROM checkIn WHERE checkInEventId = :checkInEventId AND checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);
		//bind the profile id to the placeholder in the template
		$parameters = ["checkInEventId" => $checkInEventId->getBytes(), "checkInProfileId" => $checkInProfileId->getBytes()];
		$statement->execute($parameters);
		//grab the CheckIn from mySQL
		try {
			https://www.thecodedeveloper.com/mysql-sum-function/
		} catch(\Exception $exception) {
//			if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($checkIn);
	}

	/**
	 * gets the CheckIn by event id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $checkInEventId event id to search for
	 * @return CheckIn|null CheckIn found or null if not found
	 * @throws \PDOException when mySQL related errors happen
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCheckInByCheckInEventId(\PDO $pdo, string $checkInEventId): \SplFixedArray {
		//Sanitize the Check In Event Id before searching
		try {
			$checkInEventId = self::validateUuid($checkInEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT checkInEventId, checkInProfileId, checkInDateTime, checkInRep FROM checkIn WHERE checkInEventId = :checkInEventId";
		$statement = $pdo->prepare($query);
		//bind the check in event id to the placeholder in the template
		$parameters = ["checkInEventId" => $checkInEventId->getBytes()];
		$statement->execute($parameters);
		//build an array of checkIns
		$checkInTwo = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$checkIn = new CheckIn($row["checkInEventId"], $row["checkInProfileId"], $row["checkInDateTime"], $row["checkInRep"]);
				$checkInTwo[$checkInTwo->key()] = $checkIn;
				$checkInTwo->next();
			} catch(\Exception $exception) {
				//if the row can't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($checkInTwo);
	}

	/**
	 * gets the checkIn by Profile Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $checkInProfileId profile id to search for
	 * @return CheckIn|null CheckIn found or null if not found
	 */

	public static function getCheckInByCheckInProfileId(\PDO $pdo, string $checkInProfileId): \SplFixedArray {
		//sanitize the check in profile id before searching
		try {
			$checkInProfileId = self::validateUuid($checkInProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT checkInEventId, checkInProfileId, checkInDateTime, checkInRep FROM checkIn WHERE checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);

		//bind the check in profile id to the placeholder in the template
		$parameters = ["checkInProfileId" => $checkInProfileId->getBytes()];
		$statement->execute($parameters);

		//build an array of Check-Ins
		$checkIns = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$checkIn = new CheckIn($row["checkInEventId"], $row["checkInProfileId"], $row["checkInDateTime"], $row["checkInRep"]);
				$checkIns[$checkIns->key()] = $checkIn;
				$checkIns->next();
			} catch(\Exception $exception) {
				//if the row cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($checkIns);
	}

	/**
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileId
	 * @return ProfileId|null ProfileId or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 */
	public function getProfileRepByProfileId(\PDO $pdo, string $profileId): void {
		try {
			$checkInProfileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new\PDOException($exception->getMessage(), 0, $exception));
		}
		// create the query template
		$query = "SELECT SUM(checkInRep) FROM checkIn WHERE checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);

		//bind the check in profile id to the placeholders in the template
		$parameters = ["checkInProfileId" => $checkInProfileId->getBytes()];
		$statement->execute($parameters);

		// grab the Profile rep
			try {
				$profileid = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);

			catch(\Exception $exception) {
				// if the row cannot be converted, throw again
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
	return($profileRep);
	}

	/**
	 * formats the variables for serialization
	 * @return array of fields
	 */
	function jsonSerialize() : array{
		$fields = get_object_vars($this);

		$fields["checkInEventId"] = $this->checkInEventId;
		$fields["checkInProfileId"] = $this->checkInProfileId;
		$fields["checkInDateTime"] = round(floatval($this->checkInDateTime->format("U.u")) * 1000);
		$fields["checkInRep"] = $this->checkInRep;
	return($fields);
	}
}