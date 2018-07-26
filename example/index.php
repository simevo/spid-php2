<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");

use SpidPHP\PhpSaml;

$settings = [
        'spBaseUrl' => "sp.simevo.com:8000",
        'spEntityId' => "sp.simevo.com:8000/metadata.php",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
        'spAcsUrl' => "sp.simevo.com:8000/index.php?acs",
        'spSloUrl' => "sp.simevo.com:8000/index.php?slo"
    ];

    print_r($settings);

$onelogin = new PhpSaml($settings);
$onelogin->login("testenv2");
//if (!$onelogin->isAuthenticated()) $onelogin->login();

//if ($onelogin->login()) $onelogin->logout();
