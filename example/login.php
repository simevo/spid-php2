<?php

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

$sp = new Italia\Spid2\Sp($settings);

if ($sp->isAuthenticated() === false) {
    $sp->login("testenv2");
} else {
    echo "Already logged in!";
}
