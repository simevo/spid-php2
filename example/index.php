<?php

/**
 *  SAML Handler
 */
session_start();

require_once("../vendor/autoload.php");

use SpidPHP\PhpSaml;

$settings = [
        'sp' => array(
            'entityId' => $this->spEntityId,
            'assertionConsumerService' => array(
                'url' => $this->spAcsUrl,
            ),
            'singleLogoutService' => array(
                'url' => $this->spSloUrl,
            ),
            'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
        ),
    ];

$onelogin = new PhpSaml("http://idp.simevo.com", $settings);

if (!$onelogin->isAuthenticated()) $onelogin->login();

if ($onelogin->login()) $onelogin->logout();
