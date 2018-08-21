<?php
use NerdCore\NerdNook\{Category, Event};


//grab the class we want to take a look at

require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("uuid.php");

//grab the uuid generator
require_once("uuid.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nerdnook.ini");


$category = new Category(generateUuidV4(), "Mario Kart", "Video Games");
$category->insert($pdo);
echo "first category";


$category2 = new Category(generateUuidV4(), "Dungeons and Dragons", "Table Games");
$category2->insert($pdo);
echo "second category";


$category3 = new Category(generateUuidV4(), "Harry Potter", "Books");
$category3->insert($pdo);
echo "third category";

$eventId = generateUuidV4();
$event = new Event($eventId,"0715482b-fbe3-43db-8807-ffcb96351771", "4d383a61-e7b1-492e-9794-e2ef37022f08","Check out those deets","2018-08-21 07:00:00.0",35.085859,-106.649434,"2018-08-21 09:00:00.0");
$event->insert($pdo);
echo"first event";

//$eventId2 = generateUuidV4();
//$event2 = new Event($eventId,$category->getEventCategoryId(), $profile->getEventProfileId(),"Check out those deets","2018-08-21 07:00:00.0",35.085859,-106.649434,"2018-08-21 09:00:00.0");
//$event2->insert($pdo);
//echo"second event";

/*
$commentId = generateUuidV4();
$comment = new Comment($commentId,$event->getCommentEventId(), $profile->getCommentProfileId(),"Every day is taco ipsum tuesday. Does guac cost extra? Fish tacos with cabbage slaw and a side of chips and guac. ", "2022-11-04 19:45:32.4426");
$comment->insert($pdo);
echo "first comment";
*/