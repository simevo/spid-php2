<?php

interface PhpSamlInterface {
    public function init($settings);
    public function login();
    public function logout();
}