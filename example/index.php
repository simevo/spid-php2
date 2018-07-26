<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");

use SpidPHP\PhpSaml;
$base = "http://sp.simevo.com:8000";
$settings = [
        'spBaseUrl' => $base,
        'spEntityId' => $base."/metadata.php",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
        'spAcsUrl' => $base."/index.php?acs",
        'spSloUrl' => $base."/index.php?slo"
    ];

    print_r($settings);

$onelogin = new PhpSaml($settings);
$onelogin->login("testenv2");
//if (!$onelogin->isAuthenticated()) $onelogin->login();

//if ($onelogin->login()) $onelogin->logout();
