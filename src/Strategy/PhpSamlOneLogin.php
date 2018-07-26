<?php

namespace SpidPHP\Strategy;

use SpidPHP\Strategy\Interfaces\PhpSamlInterface;
use SpidPHP\Helpers\ArrayHelper;
use SpidPHP\Helpers\IdpHelper;
use SpidPHP\Helpers\SpHelper;
use SpidPHP\Config\OneloginSamlConfig;

use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Utils;

class PhpSamlOneLogin implements PhpSamlInterface
{
    private $auth;

    function __construct($idpName, $settings)
    {
        $this->init($idpName, $settings);
        print_r($this->settings);
    }

    private function init($idpName, $settings)
    {
        $settingsHelper = new OneloginSamlConfig();
        if (!is_null($settings)) {
            $diff = ArrayHelper::array_diff_key_recursive($settings, get_object_vars($settingsHelper));
            if (!empty($diff)) {
                $message = "The following keys are invalid for the provided settings array: ";
                $first = true;
                foreach ($diff as $key => $value) {
                    if ($first) $message .= $key;
                    $first = false;
                    $message .= ", " . $key;
                }
                throw new \Exception($message, 1);
            }
            $settingsHelper->updateSettings($settings);
        }
        $settingsHelper->updateIdpMetadata($idpName);
        print_r($settingsHelper->getSettings()); die();
        $this->auth = new Auth($settingsHelper->getSettings());
    }

    public function getSupportedIdps()
    {
        return array();
    }

    public function isAuthenticated()
    {
        if ($auth->isAuthenticated) {
            return false;
        }
        return true;
    }

    public function login( $idpName, $redirectTo = null, $level = 1 )
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

    public function logout()
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