<?php
namespace ChelseaDavid\NerdNook;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "../vendor/autoload.php");

use Rbecker8\NerdNook\ValidateUuid;
use Mpeseke\NerdNook\ValidateDate;
use Ramsey\Uuid\Uuid;

/**
 *Small cross section of a Nerd Nook comment
 *This comment can be considered a small example of what services Nerd Nook store when comments are posted. This can easily
 *be extended to emulate more features of Nerd Nook
 *
 *@author Chelsea David <cryan17@cnm.edu
 *@version 1.0
 **/

class comment implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/*
	*id or this comment; this is the primary key
	*@var Uuid $comment
	*/
	private $commentId;
	/*
	 * id of the event the comment will be posted to; this is a foreign key
	 * @var Uuid $commentProfileId
	 *
	 */
	private $commentEventId;
	/*
	 * id of the profile that posted the comment
	 * @var Uuid $commentProfileId;
	 */
	private $commentProfileId;
	/*
	 * actual textual content of this comment
	 * @var string $commentContent
	 */
	private $commentContent;
	/*
	 * date and time this question was sent, in a PHP DateTime object
	 * @var \DateTime $commentDateTime
	 */
	private $commentDateTime;

	/*
	 * constructor for this comment
	 *
	 * @param Uuid $newCommentId
	 * @param Uuid $newCommentEventId
	 * @param Uuid $newCommentProfileId
	 * @param string $newCommentContent
	 * @param DateTime $newCommentDateTime
	 * @throws InvalidArgumentException
	 * @throws RangeException
	 * @throws Exception
	 * @throwsTypeError
	 */

	public function __construct($newCommentId,$newCommentEventId,$newCommentProfileId, string $newCommentContent, string $newCommentDateTime) {
		try {
			$this->setCommentId($newCommentId);
			$this->setCommentEventId($newCommentEventId);
			$this->setCommentProfileId($newCommentProfileId);
			$this->setCommentContent($newCommentContent);
			$this->setCommentDateTime($newCommentDateTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/*
	 * accessor method for commentId
	 *
	 * @return Uuid value of commentId
	 *
	 */
	public function getCommentId(): Uuid {
		return ($this->commentId);
	}

	/*
	 * mutator method for commentId
	 *
	 * @param Uuid/string $newCommentId new value of commentId
	 * @throws \RangeException if $newCommentId is n
	 * @throws \TypeError if $newCommentId is not a uuid
	 */

	public function setCommentId($newCommentId): void {
		try {
			$uuid = self:: validateUuid($newCommentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the comment id
		$this->commentId = $uuid;
	}

	/*
	 * accessor method for commentEventId
	 *
		@return Uuid value of the commentEventId
	 *
	 */
	public function getCommentEventId(): Uuid {
		return ($this->commentEventId);
	}

	/*
	 * mutator method for commentEventId
	 *
	 * @param string | Uuid $newCommentEventId new value of commentEventId
	 * @throws \InvalidArgumentException if $newCommentEventId is not a string or insecure
	 * @throws \TypeError if $newCommentEventId is not a Uuid
	 */

	public function setCommentEventId($newCommentEventId): void {
		try {
			$uuid = self::ValidateUuid($newCommentEventId);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event id
		$this->commentEventId = $uuid;
	}

	/*
	 * accessor for commentProfileId
	 *
	 * @return Uuid value of the commentProfileId
	 */
	public function getCommentProfileId(): Uuid {
		return ($this->commentProfileId);
	}

	/*
	 * mutator method for commentProfileId
	 *
	 * @param string | UUid $newCommentProfileId new value of commentProfileId
	 * @throws \InvalidArgumentException if $newCommentProfileId is not a string or insecure
	 * @throws \TypeError if $newCommentProfileId is not a Uuid
	 */

	public function setCommentProfileId($newCommentProfileId): void {
		try {
			$uuid = self::ValidateUuid($newCommentProfileId);
		} catch(\InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the profile id
		$this->commentProfileId = $uuid;
	}

	/*
	 * accessor for commentContent
	 *
	 * @return string value of the commentContent
	 */

	public function getCommentContent(): string {
		return ($this->commentContent);
	}

	/*
	 * mutator method for commentContent
	 *
	 * @param string $newCommentContent new value of commentContent
	 * @throws \InvalidArgumentException if $newCommentContent is not a string or insecure
	 * @throws \RangeException if $newCommentContent is > 500 characters
	 * @throws \TypeError is $newCommentContent is not a string
	 */

	public function setCommentContent(string $newCommentContent): void {
		// verify the comment content is secure
		$newCommentContent = trim($newCommentContent);
		$newCommentContent = filter_var($newCommentContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentContent) === true) {
			throw(new\InvalidArgumentException("Comment is empty or insecure"));
		}
		//verify the comment content will fit in the database
		if(strlen($newCommentContent) > 500) {
			throw(new \RangeException("Comment must not exceed 500 characters"));
		}
		// store the comment content
		$this->commentContent = $newCommentContent;
	}

	/*
	 * accessor for commentDateTime
	 *
	 * @return \DateTime value of questionDateTime
	 */

	public function getCommentDateTime(): \DateTime {
		return $this->commentDateTime;
	}

	/*
	 * mutator method for comment date

	@param \DateTime|string|null $newCommentDateTime comment date as a DateTime object or a string (or null to load the current time)
	@throws \InvalidArgumentException if $newCommentDateTime is not a valid object or string
	@throws \RangeException if $newCommentDateTime is a date that does not exist.
	 */
	public function setCommentDateTime($newCommentDateTime = null): void {
		// base case: if the date is null, use the current date and time
		if($newCommentDateTime === null) {
			$this->commentDateTime = new \DateTime();
			return;
		}
		//store the date using the validateDate
		try {
			$newCommentDateTime = self::validateDateTime($newCommentDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->commentDateTime = $newCommentDateTime;
	}

	/*
	 * inserts this comment into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDO exception when mySQL related errors occur
	 * @throws \TypeError if $pdo in not a PDO connection object
	*/
	public function insert(\PDO $pdo): void {

		//create query template
		$query = "INSERT INTO comment(commentId,commentEventId,commentProfileId,commentContent,commentDateTime) 
					VALUES (:commentId, :commentEventId, :commentProfileId, :commentContent, :commentDateTime)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->commentDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["commentId" => $this->commentId->getBytes(), "commentEventId" => $this->commentEventId->getBytes(), "commentProfileId" => $this->commentProfileId->getBytes(), "commentContent" => $this->commentContent, "commentDateTime" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes the comment from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM comment WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["commentId" => $this->commentId->getBytes()];
		$statement->execute($parameters);
	}

	/*
	 * updates this comment in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo): void {
		//create query template
		$query = "UPDATE comment SET commentEventId = :commentEventId, commentProfileId = :commentProfileId, commentContent = :commentContent, commentDateTime = :commentDateTime WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		$formattedDate = $this->commentDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["commentId" => $this->commentId->getBytes(), "commentEventId" => $this->commentEventId->getBytes(), "commentProfileId" => $this->commentProfileId->getBytes(), "commentContent" => $this->commentContent, "commentDateTime" => $formattedDate];
		$statement->execute($parameters);
	}

	/*
	 * gets this comment by commentId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|UUid $commentId comment id to search for
	 * @return Comment|null Comment found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 */
	public static function getCommentByCommentId(\PDO $pdo, $commentId): ?Comment {
		//sanitize the commentId before searching
		try {
			$commentId = self::validateUuid($commentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query teplate
		$query = "SELECT commentId,commentEventId, commentProfileId, commentContent, commentDateTime FROM comment WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		// bind the comment id to the place holder in the template
		$parameters = ["commentId" => $commentId->getBytes()];
		$statement->execute($parameters);

		//grab the comment from mySQL
		try {
			$comment = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentProfileId"], $row["commentContent"], $row["commentDateTime"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOExecption($exception->getMessage(), 0, $exception));
		}
		return ($comment);
	}

	/*
	 * gets the Comment by event Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of comments found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCommentByCommentEventId(\PDO $pdo, string $commentEventId) : \SplFixedArray {
		try {
			$commentEventId = self::validateUuid($commentEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT commentId, commentEventId,commentProfileId,commentContent,commentDateTime FROM comment WHERE commentEventId = :commentEventId";
		$statement = $pdo->prepare($query);
		//bind the comment event id to the place holder in the template
		$parameters = ["commentEventId" => $commentEventId->getBytes()];
		$statement ->execute($parameters);
		//build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row =$statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentEventId"], $row["commentProfileId"],$row["commentContent"], $row["commentDateTime"]);
				$comments[$comments->key()] = $comment;
				$comments->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0 , $exception));
			}
		}
		return($comments);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["commentId"] = $this->commentId;
		$fields["commentEventId"]=$this->commentEventId;
		$fields["commentProfileId"] = $this->commentProfileId;
		//format the date so that the front end can consume it
		$fields["commentDateTime"] = round(floatval($this->commentDateTime->format("U.u")) * 1000);
		return($fields);
	}
}
