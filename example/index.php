<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");

use SpidPHP\SpidPHP;
$base = "http://spid.test.com";
$settings = [
        'spBaseUrl' => $base,
        'spEntityId' => $base."/metadata.php",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
        'spAcsUrl' => $base."/index.php?acs",
        'spSloUrl' => $base."/index.php?slo"
    ];

$onelogin = new SpidPHP($settings);
//$result = $onelogin->login("testenv2");

$metadata = $onelogin->getSPMetadata();

header('Content-Type: text/xml');
echo $metadata;
//if (!$onelogin->isAuthenticated()) $onelogin->login();

//if ($onelogin->login()) $onelogin->logout();
