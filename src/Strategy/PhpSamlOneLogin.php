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
        if ($this->auth->isAuthenticated) {
            return false;
        }
        $this->auth->login();

        $requestID = null;
        if (isset($_SESSION['AuthNRequestID'])) {
            $requestID = $_SESSION['AuthNRequestID'];
        }

        $this->auth->processResponse($requestID);
        unset($_SESSION['AuthNRequestID']);

        $errors = $this->auth->getErrors();
        if (!empty($errors)) {
            return $errors;
        }

        if (!$this->auth->isAuthenticated()) {
            return false;
        }

        $_SESSION['samlUserdata'] = $this->auth->getAttributes();
        $_SESSION['samlNameId'] = $this->auth->getNameId();
        $_SESSION['samlNameIdFormat'] = $this->auth->getNameIdFormat();
        $_SESSION['samlSessionIndex'] = $this->auth->getSessionIndex();

        if (!empty($_SESSION['samlUserdata'])) {
            return true;
        }

        return false;
    }

    public function logout()
    {
        if (!$this->auth->isAuthenticated()) {
            return false;
        }
        $this->auth->logout();
        $this->auth->processSLO();

        $errors = $this->auth->getErrors();
        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

}