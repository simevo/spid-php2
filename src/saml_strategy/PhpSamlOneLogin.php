<?php
require_once('PhpSamlInterface.php');


class PhpSamlOneLogin implements PhpSamlInterface {
    
    var $settings;

    function __construct($settings = null)
    {
        $this->init($settings);
        print_r($this->settings);
    }

    function init($settings)
    {
        require_once(__DIR__ . '/../config/onelogin_saml_config.php');
        $this->settings = is_null($settings) ? $defaultSettings : array_merge($defaultSettings, $settings);
    }

    function login()
    {

    }

    function logout()
    {

    }

}