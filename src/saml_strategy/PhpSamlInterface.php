<?php

interface PhpSamlInterface {
    public function init($settings);
    public function isAuthenticated();
    public function login();
    public function logout();
}