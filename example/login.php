<?php

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

$sp = new Italia\Spid2\Sp($settings);

$sp->login("testenv2");
