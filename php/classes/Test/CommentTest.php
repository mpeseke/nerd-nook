<?php
namespace ChelseaDavid\NerdNook\Test;

use ChelseaDavid\NerdNook\{Event,Profile,Comment};

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
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class CommentTest extends NerdNookTest {
	/**
	 * Event that this comment is posted to; this is for foreign key relations
	 * @var Event event
	 */
	protected $event = null;

	/**
	 * Event that this comment is posted to; this is for foreign key relations
	 * @var Profile profile
	 */

	protected $profile = null;
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
	/**
	 * Valid timestamp to use as sunriseCommentDate
	 */
	protected $VALID_SUNRISEDATE = null;
	/**
	 * Valid timestamp to use as sunsetCommentDate
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		// create and insert a Profile to own the test Comment
		$this->profile = new Profile(generateUuidV4(), null, "@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de", $this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_COMMENTDATE = new \DateTime();
		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
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
		$this->assertEquals($pdoComment->getCommentEventId(), $this->event->getEventId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTCONTENT);
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoComment->getCommentDate()->getTimestamp(), $this->VALID_COMMENTDATE->getTimestamp());
	}

}