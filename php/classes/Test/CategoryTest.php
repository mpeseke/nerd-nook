<?php

namespace NerdCore\NerdNook\Test;

//grab the class we want to look at
use NerdCore\NerdNook\{Category};
use Ramsey\Uuid\Uuid;

require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHP Unit Test for the Category Class
 *
 * Includes both valid and invalid inputs for the test subject, therefore making it complete.
 *
 * @see \NerdCore\NerdNook\Category
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 *
 * categoryId
 * categoryName
 * categoryType
 */

class CategoryTest extends NerdNookTest {

	/**
	 *the Id of the Category; primary key
	 *@var Uuid category
	 */
	protected $category = null;

	/**
	 *name of the Category
	 *@var string $VALID_CATEGORYNAME
	 */
	protected $VALID_CATEGORYNAME = "Dungeons and Dragons";

	/**
	 *name of the Category
	 *@var string $VALID_CATEGORYNAME2
	 */
	protected $VALID_CATEGORYNAME2 = "Pokémon Go!";

	/**
	 *type of Category
	 *@var string $VALID_CATEGORYTYPE
	 */
	protected $VALID_CATEGORYTYPE = "Table Top Games";

	/**
	 *type of Category
	 *@var string $VALID_CATEGORYTYPE2
	 */
	protected $VALID_CATEGORYTYPE2 = "Books";


	/**
	 * create the dependent objects before running the test.
	 */

	public final function setUp(): void {
		//default setup method
		parent::setUp();
		$this->category = new Category(generateUuidV4(), $this->VALID_CATEGORYNAME, $this->VALID_CATEGORYTYPE);
	}

	/**
	 * test inserting a valid Category and verify that the actual mySQL data matches
	 */
	public function testInsertValidCategory(): void {
		//count the number of Rows and save for later.
		$numRows = $this->getConnection()->getRowCount("category");

		//create new Category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME, $this->VALID_CATEGORYTYPE);
		$category->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
		$this->assertEquals($pdoCategory->getCategoryType(), $this->VALID_CATEGORYTYPE);
	}

//	/**
//	 * test inserting a Category and re-grabbing it from mySQL
//	 */
//	public function testGetValidCategoryByCategoryId() {
//		//count the number of Rows and save for later
//		$numRows = $this->getConnection()->getRowCount("category");
//
//		//create a new Category and insert into mySQL
//		$categoryId = generateUuidV4();
//		$category = new Category($categoryId, $this->VALID_CATEGORYNAME, $this->VALID_CATEGORYTYPE);
//		$category->insert($this->getPDO());
//
//		//grab the data from mySQL and enforce the fields match our expectations
//		$results = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
//		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
//		$this->assertCount(1, $results);
//
//		//enforce no other objects are bleeding into the test

//		$this->assertContainsOnlyInstancesOf("NerdCore\\NerdNook\\Category", $results);
//
//		// grab the results of the array and validate
//		$pdoCategory = $results[0];
//
//		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
//		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
//		$this->assertEquals($pdoCategory->getCategoryType(), $this->VALID_CATEGORYTYPE);
//	}
	/**
	 * test grabbing an event that does not exist
	 */


	public function testGetInvalidCategoryByCategoryId(): void {
		$category = Category::getCategoryByCategoryId($this->getPDO(), generateUuidV4());
		$this->assertCount(1, [$category]);
	}

	/**
	 * test grabbing all Categories
	 */
	public function testGetAllValidCategories() : void {
		//count the number of Rows and save for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new Category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME, $this->VALID_CATEGORYTYPE);
		$category->insert($this->getPDO());

		//grab the data from mySQL and enforce that the fields match our expectations
		$results = Category::getAllCategories($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("NerdCore\\NerdNook\\Category", $results);

		//grab the result from the array and validate the information
		$pdoCategory = $results[0];
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
		$this->assertEquals($pdoCategory->getCategoryType(), $this->VALID_CATEGORYTYPE);
	}
}