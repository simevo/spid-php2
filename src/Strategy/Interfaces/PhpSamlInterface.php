<?php

namespace SpidPHP\Strategy\Interfaces;

interface PhpSamlInterface
{
    public function getSPMetadata();
    public function getSupportedIdps();
    public function isAuthenticated();
    public function login($idpName, $redirectTo = '', $level = 1);
    public function logout();
    public function getAttributes();
}
