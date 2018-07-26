<?php

namespace SpidPHP\Strategy\Interfaces;

interface PhpSamlInterface {
    public function getSupportedIdps();
    public function isAuthenticated();
    public function login( $idpName, $redirectTo = null, $level = 1 );
    public function logout();
}