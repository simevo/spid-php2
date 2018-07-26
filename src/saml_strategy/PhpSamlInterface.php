<?php

namespace SpidPHP\Strategy\Interfaces;

interface PhpSamlInterface {
    public function isAuthenticated();
    public function login();
    public function logout();
}