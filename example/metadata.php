<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

$sp = new Spid\Sp($settings);

$metadata = $sp->getSPMetadata();

header('Content-Type: text/xml');
echo $metadata;
