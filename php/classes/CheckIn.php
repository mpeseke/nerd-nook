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
	 * @var Uuid $checkInDateTime;
	 */
	private $checkInDateTime;
	/**
	 * @var Uuid $checkInRep
	 */
	private $checkInRep;

	public function __construct($newCheckInEventId, $newCheckInProfileId, $newCheckInDateTime, $newCheckInRep) {
		try {
			$this->checkInEventId($newCheckInEventId);
			$this->checkInProfileId($newCheckInProfileId);
			$this->checkInDateTime($newCheckInDateTime);
			$this->checkInRep($newCheckInRep);
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
		$this->checkInProfileId = $newCheckInProfileId;
	}
}

