<?php
namespace NerdCore\NerdNook\Test;


use NerdCore\NerdNook\Test\NerdNookTest;
use NerdCore\NerdNook\{Event, Category, Profile, Comment};


// grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Comment class
 *
 * This is a complete PHPUnit test of the Comment class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Comment
 * @author Chelsea David<cryan17@cnm.edu>
 **/
class CommentTest extends NerdNookTest {
	/**
	 * Event that this comment is posted to; this is for foreign key relations
	 * @var Event event
	 */
	protected $event = null;

	/**
	 * Profile that this comment is posted to; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/*
		 * Category that this comment will be associated with;
		 * @var Category category
		 */

	protected $category = null;



	/**
	 * valid profile activation token for the profile object that will own the test.
	 * @var $VALID_PROFILE_TOKEN
	 */

	protected $VALID_PROFILE_TOKEN;


	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;


	/**
	 * content of the Comment
	 * @var string $VALID_COMMENTCONTENT
	 **/
	protected $VALID_COMMENTCONTENT = "PHPUnit test passing";
	/**
	 * content of the updated Comment
	 * @var string $VALID_COMMENTCONTENT2
	 **/
	protected $VALID_COMMENTCONTENT2 = "PHPUnit test still passing";
	/**
	 * timestamp of the COMMENT; this starts as null and is assigned later
	 * @var \DateTime $VALID_COMMENTDATE
	 **/
	protected $VALID_COMMENTDATE = null;

	/*
	 * valid Event lat
	 * @var $VALID_LAT
	 */

	protected $VALID_EVENTLAT;

	/*
	 * valid Event long
	 * @var $VALID_LONG
	 */
	protected $VALID_EVENTLONG;
	/**
	 * Valid timestamp to use as eventEndDateTime
	 */
	protected $VALID_EVENTENDDATETIME = null;
	/**
	 * Valid timestamp to use as sunsetCommentDate
	 */
	protected $VALID_EVENTSTARTDATETIME = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_COMMENTDATE = new \DateTime();
		//format the sunrise date to use for testing
		$this->VALID_EVENTENDDATETIME = new \DateTime();
		$this->VALID_EVENTSTARTDATETIME = new \DateTime();
		// create and insert a Profile to own the test Comment
		$this->profile = new Profile(generateUuidV4(), $this->VALID_PROFILE_TOKEN,
			"@handle", "blamemdav@gmail.com", $this->VALID_PROFILE_HASH);
		$this->profile->insert($this->getPDO());
		// create and insert a Category to house the comment
		$this->category= new Category(generateUuidV4(),"Harry Potter", "Books");
		$this->category->insert($this->getPDO());
		// create and insert a Event to house the test Comment
		$this->event = new Event(generateUuidV4(), $this->category->getCategoryId(), $this->profile->getProfileId(), "blame mdav", $this->VALID_EVENTENDDATETIME, 35.156537, 106.514417, $this->VALID_EVENTSTARTDATETIME);
		$this->event->insert($this->getPDO());





		//format the sunrise date to use for testing
		//$this->VALID_SUNRISEDATE = new \DateTime();
		//$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		//$this->VALID_SUNSETDATE = new\DateTime();
		//$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}

	/**
	 * test inserting a valid Comment and verify that the actual mySQL data matches
	 **/
	public function testInsertValidComment(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");
		// create a new Comment and insert to into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_COMMENTCONTENT, $this->VALID_COMMENTDATE);
		$comment->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentId(), $commentId);
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
//		$this->assertEquals($pdoComment->getCommentCategoryId(), $this->profile->getCategoryId());
		$this->assertEquals($pdoComment->getCommentEventId(), $this->event->getEventId());
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoComment->getCommentDateTime()->getTimestamp(), $this->VALID_COMMENTDATE->getTimestamp());
	}
	/*
* 		test inserting a Comment, editing it, an then updating it
*
*/
	public function testUpdateValidComment() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new Comment and insert into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_COMMENTCONTENT, $this->VALID_COMMENTDATE);
		$comment->insert($this->getPDO());

		//edit the Comment and update it in mySQL
		$comment->setCommentContent($this->VALID_COMMENTCONTENT2);
		$comment->update($this->getPDO());


		// grab the data from mySQL and enforce the fields match our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($pdoComment->getCommentId(), $commentId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentEventId(), $this->event->getEventId());
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTCONTENT2);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoComment->getCommentDateTime()->getTimeStamp(), $this->VALID_COMMENTDATE->getTimestamp());
	}

	/*
	 *
	 * test creating a comment and then deleting it.
	 *
	 */
	public function testDeleteValidComment() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		//create a new comment and insert into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this->event->getEventId(), $this->profile->getProfileId(), $this->VALID_COMMENTCONTENT, $this->VALID_COMMENTDATE);
		$comment->insert($this->getPDO());

		//delete the comment from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$comment->delete($this->getPDO());

		//grab the data from mySQL ad enforce the Comment does not exist
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertNull($pdoComment);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("comment"));
	}
	// test grabbing a comment that does not exist

	public function testGetInvalidCommentByCommentId() : void {
		// grab a profile id the exceeds the maximum allowable profile id
		$comment = Comment::getCommentByCommentId($this->getPDO(), generateUuidV4());
		$this->assertNull($comment);
	}



	/**
	 * test inserting a Comment and re-grabbing it from mySQL
	 **/
	public function testGetValidCommentByCommentEventId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");
		// create a new Comment and insert to into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this->event->getEventId(),$this->profile->getProfileId(), $this->VALID_COMMENTCONTENT, $this->VALID_COMMENTDATE);
		$comment->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Comment::getCommentByCommentEventId($this->getPDO(), $comment->getCommentEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertCount(1, $results);
//		$this->assertContainsOnlyInstancesOf("NerdCore\\NerdNook\\Comment", $results);
		// grab the result from the array and validate it
		$pdoComment = $results[0];
		$pdoProfile = $results[0];

		$this->assertEquals($pdoComment->comment->getCommentId(), $commentId);
		$this->assertEquals($pdoComment->comment->getCommentEventId(), $this->event->getEventId());
		$this->assertEquals($pdoComment->comment->getCommentContent(), $this->VALID_COMMENTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoComment->comment->getCommentDateTime()->getTimestamp(), $this->VALID_COMMENTDATE->getTimestamp());
		$this->assertEquals($pdoProfile->profileAtHandle, $this->profile->getProfileAtHandle());
	}
	/**
	 * test grabbing a Comment that does not exist
	 **/
	public function testGetInvalidCommentByCommentEventId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$comment = Comment::getCommentByCommentEventId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $comment);
	}

	/**
	 * test inserting a Comment and re-grabbing it from mySQL
	 **/
	public function testGetValidCommentByCommentProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");
		// create a new Comment and insert to into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this->event->getEventId(),$this->profile->getProfileId(), $this->VALID_COMMENTCONTENT, $this->VALID_COMMENTDATE);
		$comment->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Comment::getCommentByCommentProfileId($this->getPDO(), $comment->getCommentProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("NerdCore\\NerdNook\\Comment", $results);
		// grab the result from the array and validate it
		$pdoComment = $results[0];

		$this->assertEquals($pdoComment->getCommentId(), $commentId);
		$this->assertEquals($pdoComment->getCommentEventId(), $this->event->getEventId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoComment->getCommentDateTime()->getTimestamp(), $this->VALID_COMMENTDATE->getTimestamp());
	}
	/**
	 * test grabbing a Comment that does not exist
	 **/
	public function testGetInvalidCommentByCommentProfileId() : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$comment = Comment::getCommentByCommentProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $comment);
	}

}