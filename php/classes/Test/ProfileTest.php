<?php

namespace Rbecker8\NerdNook\Test;

use Rbecker8\NerdNook\Profile;



// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2). "");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class.  It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs
 *
 * @see Profile
 * @author Ryan Becker <rbecker8@cnm.edu>
 **/

class ProfileTest extends DataDesignTest {
	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 *
	 *
	 */
	protected $VALID_ACTIVATION;
