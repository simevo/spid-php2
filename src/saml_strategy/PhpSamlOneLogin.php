<?php
require_once('PhpSamlInterface.php');
require_once(__DIR__ . '/../helper/ArrayHelper.php');
require_once(__DIR__ . '/../helper/IdpHelper.php');
require_once(__DIR__ . '/../config/OneloginSamlConfig.php');

use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Utils;

class PhpSamlOneLogin implements PhpSamlInterface
{

    var $settings;
    var $auth;

    function __construct($idpUrl, $settings = null)
    {
        if (filter_var($idpUrl, FILTER_VALIDATE_URL)) {
            throw new Exception("The provided idp URL is not a valid URL", 1);
        }
        $this->init($idpUrl, $settings);
        print_r($this->settings);
    }

    private function init($idpUrl, $settings)
    {
        $settingsHelper = new OneloginSamlConfig();
        $defaultSettings = $settingsHelper->getSettings();
        if (!is_null($settings)) {
            $diff = ArrayHelper::array_diff_key_recursive($settings, $defaultSettings);
            if (!empty($diff)) {
                $message = "The following keys are invalid for the provided settings array: ";
                array_walk_recursive($diff, function ($v, $k) {
                    $message .= $k . ", ";
                });
                throw new Exception($message, 1);
            }
        }
        $this->settings = is_null($settings) ? $defaultSettings : array_merge_recursive($defaultSettings, $settings);
        $metadata = IdpHelper::getMetadata($idpUrl);


        $auth = new OneLogin_Saml2_Auth($this->settings);
    }

    public function login()
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