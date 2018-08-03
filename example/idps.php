<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

use SpidPHP\SpidPHP;


$onelogin = new SpidPHP($settings);
foreach ($onelogin->getSupportedIdps() as $key => $idp) {
    echo $key . ' - ' . $idp . '<br>';
}