<?php
use NerdCore\NerdNook\{Category};

//grab the class we want to take a look at
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once("uuid.php");

//grab the uuid generator
require_once("uuid.php");
$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nerdnook.ini");

$categoryId = generateUuidV4();
$category = new Category($categoryId, $category->getCategoryId(),"Mariokart Wii", "Video Games");
$category->insert($pdo);
echo "first category";

$categoryId2 = generateUuidV4();
$category2 = new Category($categoryId2, $category2->getCategoryId(),"Chess", "Board Games");
$category->insert($pdo);
echo "second category";

$categoryId3 = generateUuidV4();
$category3 = new Category($categoryId3, $category3->getCategoryId(),"Harry Potter", "Books");
$category->insert($pdo);
echo "third category";