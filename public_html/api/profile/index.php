<?php

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use NerdCore\NerdNook\ {
			Profile
};

/**
 * API for Profile
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 */

//verify the session, if it not active start it
if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

