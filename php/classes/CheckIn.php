<?php

namespace CalebMHeckendorn\NerdNook;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * @author Caleb Heckendorn <checkendorn@cnm.edu>
 * @version 1.0
 */
class CheckIn {
	/**
	 * id for the check in event id; this is a foreign key
	 * @var Uuid $checkInEventId
	 */
	private $checkInEventId;
	/**
	 * id for the check in profile id; this is a foreign key
	 * @var Uuid $checkInProfileId
	 */
	private $checkInProfileId;
	/**
	 * @var \DateTime $checkInDateTime;
	 */
	private $checkInDateTime;
	/**
	 * @var int $checkInRep
	 */
	private $checkInRep;

	public function __construct($newCheckInEventId, $newCheckInProfileId, $newCheckInDateTime, $newCheckInRep) {
		try {
			$this->setCheckInEventId($newCheckInEventId);
			$this->setCheckInProfileId($newCheckInProfileId);
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
		return $this->checkInEventId;
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
		$this->checkInEventId = $newCheckInEventId;
	}
	/**
	 * accessor method for check in profile id
	 *
	 * @return Uuid value of check in profile id
	 */
	public function getCheckInProfileId(): Uuid {
		return $this->checkInProfileId;
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
		return $this->checkInDateTime;
	}

	/**
	 * mutator method for check in date time
	 *
	 * @param \DateTime $newCheckInDateTime new value of check in date time
	 * @throws \RangeException if $newCheckInDateTime is \mysqli_sql_exception
	 * @throws \TypeError if $newCheckInDateTime is not a valid date time
	 */
	public function setCheckInDateTime($newCheckInDateTime): void {
		try {
			$newCheckInDateTime = self::validateDateTime($newCheckInDateTime);
		} catch(\RangeException | \TypeError $exception){
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
		return $this->checkInRep;
	}

	/**
	 * mutator method for check in rep
	 *
	 * @param int $newCheckInRep new value of check in rep
	 * @throws \RangeException if $newCheckInRep is \mysqli_sql_exception
	 * @throws \TypeError if $newCheckInRep is not a int
	 */
	public function setCheckInRep($newCheckInRep): void {
		if ($newCheckInRep < 0){
			throw(new \RangeException("cannot be less than 0"));
		}

		//convert and store the check in rep
		$this->checkInRep = $newCheckInRep;
	}


	/*
	 * checkInEventId
	 * checkInProfileId
	 * checkInDateTime
	 * checkInRep
	 */




	/**
	 * inserts this check in event id into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors happen
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert (\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO checkIn(checkInEventId, checkInProfileId, checkInDateTime, checkInRep) VALUES (:checkInEventId, :checkInProfileId, :checkInDateTime, :checkInRep)";
		$statement = $pdo->prepare($query);
		$parameters = ["checkInEventId" => $this->checkInEventId->getBytes(), "checkInProfileId" => $this->checkInProfileId->getBytes(), "checkInDateTime" => $this->checkInDateTime->getBytes(), "checkInRep" => $this->checkInRep->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * delete the check in  from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM checkIn WHERE checkInProfileId = :checkInProfileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["checkInProfileId" => $this->checkInProfileId->getBytes()];
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
		$parameters = ["checkInProfileId" => $this->checkInProfileId->getBytes(), "checkInEventId" => $this->checkInEventId, "checkInDateTime" => $this->checkInDateTime, "checkInRep" => $this->checkInRep];
		$statement->execute($parameters);
	}

	/**
	 * @param \PDO $pdo
	 * @param string $checkInEventId
	 * @return CheckIn|null
	 */
	public static function getCheckInByCheckInEventId(\PDO $pdo, string $checkInEventId):?CheckIn {
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
	 * @param \PDO $pdo
	 * @param string $checkInProfileId
	 * @return CheckIn|null
	 */

	public static function getCheckInByCheckInProfileId(\PDO $pdo, string $checkInProfileId):?CheckIn {
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
	 * formats the variables for serialization
	 * @return array
	 */
	function jsonSerialize() : array{
		$fields = get_object_vars($this);

		$fields["checkInEventId"] = $this->checkInEventId->toString();
		$fields["checkInProfileId"] = $this->checkInProfileId->toString();
	}
}

