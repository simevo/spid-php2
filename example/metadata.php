<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

use SpidPHP\SpidPHP;

$onelogin = new SpidPHP($settings);

$metadata = $onelogin->getSPMetadata();

header('Content-Type: text/xml');
echo $metadata;
//if (!$onelogin->isAuthenticated()) $onelogin->login();

//if ($onelogin->login()) $onelogin->logout();
