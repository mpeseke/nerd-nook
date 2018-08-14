<?php
namespace NerdCore\NerdNook;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * Cross Section of the the Nerd Nook Category Class
 * This class illustrates the back end for the Category class and the data it can hold, and can be extended for more
 * features in the future.
 *
 * @author Caleb Heckendorn <checkendorn@cnm.edu>
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 * @version 1.0
 */


class Category implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**
	 * id for Category; this is the primary key
	 * @var Uuid $categoryId
	 */
	private $categoryId;

	/**
	 * the name of the Category
	 * @var string $categoryName
	 */
	private $categoryName;

	/**
	 * the Type of Category
	 * @var string $categoryType
	 */
	private $categoryType;

	/**
	 * Category constructor.
	 * @param string|Uuid $newCategoryId new category id
	 * @param string $newCategoryName name of the new category
	 * @param string $newCategoryType type of the new category
	 * @throws \InvalidArgumentException if data type is not valid
	 * @throws \RangeException if data is out of bounds
	 * @throws \TypeError if the data types are invalid
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct($newCategoryId, $newCategoryName, $newCategoryType) {
		try {
			$this->setCategoryId($newCategoryId);
			$this->setCategoryName($newCategoryName);
			$this->setCategoryType($newCategoryType);
		} catch(\InvalidArgumentException| \RangeException| \TypeError| \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for categoryId
	 * @return Uuid value of category id
	 **/
	public function getCategoryId(): Uuid {
		return ($this->categoryId);
	}
	/**
	 * mutator method for category id
	 *
	 * @param Uuid|string $newCategoryId new value of personality id
	 * @throws \RangeException if $newCategoryId is not positive
	 * @throws \TypeError if $newPersonalityId is not a uuid
	 **/

	public function setCategoryId( $newCategoryId): void {
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
	 * accessor method for category Name
	 * @return string category Name
	 **/
	public function getCategoryName() : string {
		return $this->categoryName;
	}
	/**
	 * mutator method for category Name
	 * @param string $newCategoryName new value of category name
	 * @throws \RangeException if $newCategoryName is > 32 Characters
	 * @throws \TypeError if $newCategoryName is not a string
	 */
	public function setCategoryName($newCategoryName): void {
		// verify the categoryName is secure
		$newCategoryName = trim($newCategoryName);
		$newCategoryName = filter_var($newCategoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCategoryName) === true) {
			throw(new \InvalidArgumentException("Category must have a name."));
		}
		if(strlen($newCategoryName) > 32) {
			throw(new \RangeException("Category name is too large"));
		}
		//convert and store the category name
		$this->categoryName = $newCategoryName;
	}

	/**
	 * accessor method for category type
	 * @return string values of category type
	 **/
	public function getCategoryType(): string {
		return $this->categoryType;
	}

	/**
	 * mutator method for category type
	 *
	 * @param string $newCategoryType new value of category type
	 * @throws \RangeException if $newCategoryType is > 12 characters
	 * @throws \TypeError if $newCategoryType is not a string
	 **/

	public function setCategoryType($newCategoryType): void {
		// verify Category Type is secure
		$newCategoryType = trim($newCategoryType);
		$newCategoryType = filter_var($newCategoryType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCategoryType) === true ){
			throw(new \InvalidArgumentException("Category must have a Type."));
		}
		if(strlen($newCategoryType) > 24) {
			throw(new \RangeException("Category Type is too long"));
		}
		//convert and store the Category Type
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

		//bind variables to their place in the query template
		$parameters = ["categoryId" => $this->categoryId->getBytes(), "categoryName" => $this->categoryName, "categoryType" => $this->categoryType];
		$statement->execute($parameters);
	}

	/**
	 * get Category by Category Id
	 * @param \PDO $pdo PDO connection object
	 * @param string $categoryId new category id
	 * @throws \Exception when encountering an exception to params
	 * @throws \TypeError when the input is not the correct type
	 * @throws \RangeException when the input parameters are off
	 * @throws \InvalidArgumentException when argument input is not valid
	 * @return Category|null new Category or null if not found
	 */

	public static function getCategoryByCategoryId(\PDO $pdo, $categoryId): ?Category {
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
	 * @param \PDO $pdo PDO connection object
	 * @throws \Exception on exceptions
	 * @return \SplFixedArray SplFixedArray of categories found
	 */

	public static function getAllCategories (\PDO $pdo): \SplFixedArray {
		//creates the query template
		$query = "SELECT categoryId, categoryName, categoryType FROM category";
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

	/**
	 * format the state variables for JSON serialization
	 * @return array resulting state variables to serialize.
	 */

	function jsonSerialize() : array{
		$fields = get_object_vars($this);
		$fields["categoryId"] = $this->categoryId;
		return($fields);
	}
}


