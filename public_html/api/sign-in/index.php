<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__,3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use NerdCore\NerdNook\Profile;

/**
 *
 * api for handling sign-in
 *
 * @author Cryan17
 *
 **/
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data=null;
