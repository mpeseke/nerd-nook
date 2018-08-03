<?php
namespace Mpeseke\NerdNook\Test;

use CalebMHeckendorn\NerdNook\Category;
use Mpeseke\NerdNook\Event;
use Rbecker8\NerdNook\Profile;

//grab the class we want to look at
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator (still have to add this to directory)
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit Test for the Event Class
 *
 * This is a complete test because it tests the class in the case of both valid and invalid inputs for the mySQL/PDO enabled
 * methods
 *
 * @see Event
 * @author Marlon Oliver Peseke <mpeseke@gmail.com>
 **/

class EventTest extends NerdNookTest {
	/**
	 * Category the Event falls under; this is for the foreign key relations
	 * @var Category category
	 */
	protected $category = null;

	/**
	 * Profile that created the Event; this is for the foreign key relations
	 * @var Profile profile
	 */
	protected $profile = null;

	/**
	 * valid profile hash to create the profile object that will own the test,
	 * this creates a valid "fake" profile to test the unit against.
	 *
	 * @var $VALID_PROFILE_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * Event Content
	 * @var string $VALID_EVENTCONTENT
	 */
	protected $VALID_EVENTCONTENT = "Event content is good.";

	/**
	 * Updated Event Content
	 * @var string $VALID_EVENTCONTENT2
	 */
	protected $VALID_EVENTCONTENT2 = "Event content is better.";

	//Used the actual GPS coordinates of Active Imagination and Twin Suns Comics and Games

	/**
	 * Event Latitude Location
	 * @var float $VALID_EVENTLAT
	 */
	protected $VALID_EVENTLAT = 35.129905;

	/**
	 * Event Latitude Location
	 * @var float $VALID_EVENTLAT2
	 */
	protected $VALID_EVENTLAT2 = 35.156537;

	/**
	 * Event Longitude Location
	 * @var float $VALID_EVENTLONG
	 */
	protected $VALID_EVENTLONG = -106.514417;

	/**
	 * Event Longitude Location
	 * @var float $VALID_EVENTLONG2
	 */
	protected $VALID_EVENTLONG2 = -106.680244;
}