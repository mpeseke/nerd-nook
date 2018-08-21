<?php
use NerdCore\NerdNook\{Category};


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