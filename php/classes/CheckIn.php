<?php

namespace NerdCore\NerdNook;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
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
	 * @var \DateTime $checkInDateTime;
	 */
	private $checkInDateTime;
	/**
	 * @var int $checkInRep
	 */
	private $checkInRep;

	public function __construct($newCheckInProfileId, $newCheckInEventId, \DateTime $newCheckInDateTime, int $newCheckInRep) {
		try {
			$this->setCheckInProfileId($newCheckInProfileId);
			$this->setCheckInEventId($newCheckInEventId);
			$this->setCheckInDateTime($newCheckInDateTime);
			$this->setCheckInRep($newCheckInRep);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for check in event id
	 *
	 * @return Uuid value of check in event id
	 */
	public function getCheckInEventId(): Uuid {
		return ($this->checkInEventId);
	}

	/**
	 * mutator method for check in event id
	 *
	 * @param Uuid|string $newCheckInEventId new value of check in event id
	 * @throws \RangeException if $newCheckInEventId is n
	 * @throws \TypeError if $newCheckInEventId is not a uuid.e
	 */
	public function setCheckInEventId($newCheckInEventId) : void {
		try {
			$uuid = self::validateUuid($newCheckInEventId);
		} catch(\RangeException | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the check in event id
		$this->checkInEventId = $uuid;
	}
	/**
	 * accessor method for check in profile id
	 *
	 * @return Uuid value of check in profile id
	 */
	public function getCheckInProfileId() : Uuid {
		return ($this->checkInProfileId);
	}

	/**
	 * mutator method for check in profile id
	 *
	 * @param Uuid|string $newCheckInProfileId new value of check in profile id
	 * @throws \RangeException if $newCheckInProfileId is \mysqli_sql_exception
	 * @throws \TypeError if $newCheckInProfileId is not a uuid.e
	 */
	public function setCheckInProfileId($newCheckInProfileId): void {
		try {
			$uuid = self::validateUuid($newCheckInProfileId);
		} catch(\RangeException | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the check in profile id
		$this->checkInProfileId = $newCheckInProfileId;
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
	 * @param \DateTime $newCheckInDateTime new value of check in date time
	 * @throws \InvalidArgumentException if $newCheckInDateTime is not a valid object or string
	 * @throws \RangeException if $newCheckInDateTime is \mysqli_sql_exception
	 * @throws \Exception on all other exceptions
	 *
	 */
	public function setCheckInDateTime($newCheckInDateTime = null): void {
		//if the date is null, use current date and time
		if($newCheckInDateTime === null){
			$this->checkInDateTime = new \DateTime();
			return;
		}
		//store the check in date using the ValidateDateTime trait
		try {
			$newCheckInDateTime = self::validateDateTime($newCheckInDateTime);
		} catch(\InvalidArgumentException |\RangeException $exception){
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
		if ($newCheckInRep < 0){
			throw(new \RangeException("cannot be less than 0"));
		}

		//convert and store the check in rep
		$this->checkInRep = $newCheckInRep;
	}

	/**
	 * inserts this CheckIn into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors happen
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert (\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO checkIn (checkInEventId, checkInProfileId,  checkInDateTime, checkInRep) VALUES ( :checkInEventId, :checkInProfileId, :checkInDateTime, :checkInRep)";
		$statement = $pdo->prepare($query);

		$formattedDate= $this->checkInDateTime->format("Y-m-d H:i:s.u");

		$parameters = ["checkInEventId" => $this->checkInEventId->getBytes(),  "checkInProfileId" => $this->checkInProfileId->getBytes(), "checkInDateTime" =>$formattedDate, "checkInRep" => $this->checkInRep];
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
		$query = "UPDATE checkIn SET checkInEventId = :checkInEventId, checkInDateTime = :checkInDateTime, checkInRep = :checkInRep";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = [ "checkInEventId" => $this->checkInEventId->getBytes(), "checkInProfileId" => $this->checkInProfileId->getBytes(),"checkInDateTime" => $this->checkInDateTime, "checkInRep" => $this->checkInRep];
		$statement->execute($parameters);
	}

	/**
	 * gets the check in by event id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $checkInEventId event id to search for
	 * @return CheckIn|null CheckIn found or null if not found
	 */
	public static function getCheckInByEventId(\PDO $pdo, string $checkInEventId):?CheckIn {
		//Sanitize the Check In Event Id before searching
		try{
			$checkInEventId =self::validateUuid($checkInEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT checkInEventId, checkInProfileId, checkInDateTime, checkInRep FROM checkIn WHERE checkInEventId = :checkInEventId";
		$statement = $pdo->prepare($query);
		//bind the check in event id to the placeholder in the template
		$parameters = ["checkInEventId" => $checkInEventId->getBytes()];
		$statement->execute($parameters);
		//grab the CheckIn from mySQL
		try{
			$checkIn = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false){
				$checkIn = new CheckIn($row["checkInEventId"], $row["checkInProfileId"], $row["checkInDateTime"], $row["checkInRep"]);
			}
		} catch(\Exception $exception){
			//if the row can't be converted rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($checkIn);
	}

	/**
	 * gets the checkIn by Profile Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $checkInProfileId profile id to search for
	 * @return CheckIn|null CheckIn found or null if not found
	 */

	public static function getCheckInByProfileId(\PDO $pdo, string $checkInProfileId):?CheckIn {
		//sanitize the check in profile id before searching
		try {
			$checkInProfileId =self::validateUuid($checkInProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT checkInEventId, checkInProfileId, checkInDateTime, checkInRep FROM checkIn WHERE checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);
		//bind the check in profile id to the placeholder in the template
		$parameters = ["checkInProfileId" => $checkInProfileId->getBytes()];
		$statement->execute($parameters);
		//grab the CheckIn from mySQL
		try {
			$checkIn  = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$checkIn = new CheckIn($row["checkInEventId"], $row["checkInProfileId"], $row["checkInDateTime"], $row["checkInRep"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(),0, $exception));
		}
		return ($checkIn);
	}

	/**
	 * gets the check in by event id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param uuid $checkInEventId event id to search for
	 * @param uuid $checkInProfileId profile id to search for
	 * @return CheckIn|null CheckIn if found null if not found
	 */
	public static function getCheckInByEventIdAndProfileId(\PDO $pdo, $checkInEventId, $checkInProfileId): ?CheckIn{
		//sanitize the profile id before searching
		try{
			$checkInEventId = self::validateUuid($checkInEventId);
			$checkInProfileId = self::validateUuid($checkInProfileId);

		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
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
			$checkIn  = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$checkIn = new CheckIn($row["checkInEventId"], $row["checkInProfileId"], $row["checkInDateTime"], $row["checkInRep"]);
			}
		} catch(\Exception $exception) {
//			if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($checkIn);
	}
	/**
	 * formats the variables for serialization
	 * @return array
	 */
	function jsonSerialize() : array{
		$fields = get_object_vars($this);

		$fields["checkInEventId"] = $this->checkInEventId->toString();
		$fields["checkInProfileId"] = $this->checkInProfileId->toString();
	}
}

