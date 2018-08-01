<?php

namespace CalebMHeckendorn\NerdNook;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

//use Ramsey\Uuid\Uuid; WIP
/**
 * @author Caleb Heckendorn <checkendorn@cnm.edu>
 * @version 1.0
 */
class Category {
	/**
	 * id for Category; this is the primary key
	 * @var Uuid $categoryId
	 */
	private $categoryId;
	/**
	 * @var Uuid $categoryName
	 */
	private $categoryName;
	/**
	 * @var Uuid $categoryType
	 */
	private $categoryType;

	public function __construct($newCategoryId, string $newCategoryName, string $newCategoryType) {
		try {
			$this->setCategoryId($newCategoryId);
			$this->setCategoryName($newCategoryName);
			$this->setCategoryType($newCategoryType);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for categoryId
	 *
	 * @return Uuid value of category id
	 **/
	public function getCategoryId(): Uuid {
		return ($this->categoryId);
	}
	/**
	 * mutator method for category id
	 *
	 * @param Uuid|string $newCategoryId new value of personality id
	 * @throws \RangeException if $newCategoryId is n
	 * @throws \TypeError if $newPersonalityId is not a uuid.e
	 **/

	public function setCategoryId(Uuid $newCategoryId): void {
		try {
			$uuid = self::validateUuid($newCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the category
		$this->categoryId = $uuid;
	}
	/**
	 * accessor method for category name
	 *
	 * @return Uuid values of category name
	 **/
	public function getCategoryName() : Uuid {
		return $this->categoryName;
	}
	/**
	 * mutator method for category id
	 *
	 * @param string | Uuid $newCategoryName new value of category name
	 * @throws \RangeException if $newCategoryName is > 32 Characters
	 * @throws \TypeError if $newCategoryNae is not a string
	 */
	public function setCategoryName(Uuid $newCategoryName): void {
		try {
			$uuid = self::validateUuid($newCategoryName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the category name
		$this->categoryName = $uuid;
	}
	/**
	 * accessor method for category type
	 *
	 * @return Uuid values of category type
	 **/
	public function getCategoryType(): Uuid{
		return $this->categoryType;
	}

	/**
	 * mutator method for category type
	 *
	 * @param string | Uuid $newCategoryType new value of category type
	 * @throws \RangeException if $newCategoryType is > 12 characters
	 * @throws \TypeError if $newCategoryType is not a string
	 **/
	public function setCategoryType(Uuid $newCategoryType): void {
		try {
			$uuid = self::validateUuid($newCategoryType);
		} catch(\RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the category type
		$this->categoryType = $uuid;
	}

	/**
	 * inserts this category id into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOExceptionwhen mySQL errors happen
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert (\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO category(categoryId, categoryName, categoryType) VALUES (:categoryId, :categoryName, :categoryType)";
		$statement = $pdo->prepare($query);
	}
}