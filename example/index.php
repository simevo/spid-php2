<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");

use SpidPHP\PhpSaml;

$settings = [
        'spBaseUrl' => "BASE URL",
        'spEntityId' => "ENTITY ID",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
    ];

    print_r($settings);

$onelogin = new PhpSaml($settings);
$onelogin->login("nome");
//if (!$onelogin->isAuthenticated()) $onelogin->login();

//if ($onelogin->login()) $onelogin->logout();
