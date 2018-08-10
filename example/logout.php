<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

$sp = new Spid\Sp($settings);

if ($sp->isAuthenticated()) {
    $sp->logout();
} else {
    echo "Logged out!";
    echo '<p><a href="index.php" >Go back</a></p>';
}
