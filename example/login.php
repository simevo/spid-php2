<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

use SpidPHP\SpidPHP;

$onelogin = new SpidPHP($settings);

if ($onelogin->isAuthenticated() === false) {
    $result = $onelogin->login("testenv2");
    print_r($result);
    exit();    
}

$attributes = $onelogin->getAttributes();

foreach ($attributes as $key => $attribute) {
    echo $attribute . "\n";
}

    
