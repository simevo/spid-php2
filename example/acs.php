<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

$sp = new Spid\Sp($settings);

if ($sp->isAuthenticated()) {
    $attributes = $sp->getAttributes();
    echo "logged in !" . PHP_EOL;
    foreach ($attributes as $key => $attribute) {
        echo $key .": " . $attribute . "<br>";
    }

    echo '<p><a href="logout.php" >Logout</a></p>';
} else {
    echo "not logged in !" . PHP_EOL;
    echo '<p><a href="login.php" >Login</a></p>';
}
