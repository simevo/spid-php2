<?php

/**
 *  SAML Handler
 */
session_start();

require_once("../vendor/autoload.php");
require_once("../src/saml_strategy/PhpSamlOneLogin.php");

$onelogin = new PhpSamlOneLogin;
