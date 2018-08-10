<?php
require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

$sp = new Spid\Sp($settings);
foreach ($sp->getSupportedIdps() as $key => $idp) {
    echo $key . ' - ' . $idp . '<br>';
}
