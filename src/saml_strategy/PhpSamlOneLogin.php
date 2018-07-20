<?php
require_once('PhpSamlInterface.php');

use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Utils;

class PhpSamlOneLogin implements PhpSamlInterface {
    
    var $settings;
    var $auth;

    function __construct($settings = null)
    {
        $this->init($settings);
        print_r($this->settings);
    }

    private function init($settings)
    {
        require_once(__DIR__ . '/../config/onelogin_saml_config.php');
        $this->settings = is_null($settings) ? $defaultSettings : array_merge($defaultSettings, $settings);
        $auth = new OneLogin_Saml2_Auth($this->settings);
    }

    function login()
    {
        if ($auth->isAuthenticated) {
            return false;
        }
        $auth->login();

        $requestID = null;
        if (isset($_SESSION['AuthNRequestID'])) {
            $requestID = $_SESSION['AuthNRequestID'];
        }
        
        $auth->processResponse($requestID);
        unset($_SESSION['AuthNRequestID']);
        
        $errors = $auth->getErrors();
        if (!empty($errors)) {
            return $errors;
        }
        
        if (!$auth->isAuthenticated()) {
            return false;
        }

        $_SESSION['samlUserdata'] = $auth->getAttributes();
        $_SESSION['samlNameId'] = $auth->getNameId();
        $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
        $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();

        if (!empty($_SESSION['samlUserdata'])) {
            return true;
        }

        return false;
    }

    function logout()
    {               
        if (!$auth->isAuthenticated()) {
            return false;
        }
        $auth->logout();
        $auth->processSLO();

        $errors = $auth->getErrors();
        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

}