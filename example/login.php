<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

use SpidPHP\SpidPHP;

$onelogin = new SpidPHP($settings);

if ($onelogin->isAuthenticated() === false) {
    $onelogin->login("testenv2");
} else {
	echo "Already logged in!";
}
    
