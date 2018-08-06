<?php

namespace CalebMHeckendorn\NerdNook;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * @author Caleb Heckendorn <checkendorn@cnm.edu>
 * @version 1.0
 */
class Category implements \JsonSerializable {
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
		$this->categoryName = $newCategoryName;
	}
	/**
	 * accessor method for category type
	 *
	 * @return string values of category type
	 **/
	public function getCategoryType(): string{
		return $this->categoryType;
	}

	/**
	 * mutator method for category type
	 *
	 * @param string $newCategoryType new value of category type
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
		$this->categoryType = $newCategoryType;
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
	 * get Category by Category Id
	 * @param \PDO $pdo
	 * @param string $categoryId
	 * @return Category|null
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

	/**
	 * get All the Categories. All the things.
	 * @param \PDO $pdo
	 * @return \SplFixedArray
	 */

	public static function getAllCategories (\PDO $pdo): \SplFixedArray {
		//creates the query template
		$query = "SELECT categoryId, categoryName, categoryType FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of Categories
		$categories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
		try {
			$category = new Category($row["categoryId"], $row["categoryName"], $row["categoryType"]);
			$categories[$categories->key()] = $category;
			$categories->next();
		} catch(\Exception $exception) {
			//if the row cannot be converted, throw again
			throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return ($categories);
	}
	function jsonSerialize() : array{
		$fields = get_object_vars($this);
		$fields["categoryId"] = $this->categoryId->toString();
		return($fields);
	}
}

//JSON serializer NEEDED
