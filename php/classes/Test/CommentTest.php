<?php
namespace ChelseaDavid\NerdNook\Test;

use ChelseaDavid\NerdNook\{Event,Profile,Comment};

// grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");