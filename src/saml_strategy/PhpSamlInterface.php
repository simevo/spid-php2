<?php

interface PhpSamlInterface {
    public function isAuthenticated();
    public function login();
    public function logout();
}