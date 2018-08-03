<?php

namespace CalebMHeckendorn\NerdNook;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
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
	 * @var string $categoryName
	 */
	private $categoryName;
	/**
	 * @var string $categoryType
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
	 * @return string category name
	 **/
	public function getCategoryName() : string {
		return $this->categoryName;
	}
	/**
	 * mutator method for category id
	 *
	 * @param string $newCategoryName new value of category name
	 * @throws \RangeException if $newCategoryName is > 32 Characters
	 * @throws \TypeError if $newCategoryNae is not a string
	 */
	public function setCategoryName(string $newCategoryName): void {
		// verify the

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
	 * @throws \PDOException when mySQL errors happen
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert (\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO category(categoryId, categoryName, categoryType) VALUES (:categoryId, :categoryName, :categoryType)";
		$statement = $pdo->prepare($query);
		$parameters = ["categoryId" => $this->categoryId->getBytes(), "categoryName" => $this->categoryName->getBytes(), "categoryType" => $this->categoryType->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * delete the category id from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM category WHERE categoryId = :categoryId AND categoryName = :categoryName AND categoryType = :categoryType";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["categoryId" => $this->categoryId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates the Category from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL errors happen
	 */
	public function update(\PDO $pdo): void {
		//create query template
		$query = "UPDATE category SET categoryName = :categoryName, categoryType = :categoryType";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["categoryId" => $this->categoryId->getBytes(), "categoryName" => $this->categoryName, "categoryType" => $this->categoryType];
		$statement->execute($parameters);
		}
		/**
		 * gets the Category by category id
		 *
		 * @param \PDO $pdo $pdo PDO connection object
		 * @return Category|null Category or null if not found
		 * @throws \PDOException when mySQL errors happen
		 * @throws \TypeError when a variable is not the correct data type
		 */

	public static function getCategoryByCategoryId(\PDO $pdo, string $categoryId):?Category {
		//sanitize the category id before searching
		try {
			$categoryId =self::validateUuid($categoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT categoryId, categoryName, categoryType FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);
		//bind the category id to the placeholder in the template
		$parameters = ["categoryId" => $categoryId->getBytes()];
		$statement->execute($parameters);
		//grab the Category from mySQL
		try {
			$category = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$category = new Category($row["categoryId"], $row["categoryName"], $row["categoryType"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(),0, $exception));
		}
		return ($category);
	}
}
