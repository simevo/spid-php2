<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

use SpidPHP\SpidPHP;

$onelogin = new SpidPHP($settings);

if ($onelogin->isAuthenticated()) {
    $attributes = $onelogin->getAttributes();
    echo "logged in !" . PHP_EOL;
    var_dump($attributes);
    foreach ($attributes as $key => $attribute) {
        echo $attribute . "\n";
    }
} else {
    echo "not logged in !" . PHP_EOL;
}

echo '<p><a href="login.php" >Login</a></p>';
