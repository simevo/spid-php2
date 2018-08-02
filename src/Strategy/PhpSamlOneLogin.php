<?php

namespace SpidPHP\Strategy;

use SpidPHP\Strategy\Interfaces\PhpSamlInterface;
use SpidPHP\Helpers\ArrayHelper;
use SpidPHP\Helpers\IdpHelper;
use SpidPHP\Helpers\SpHelper;
use SpidPHP\Config\OneloginSamlConfig;

use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Utils;
use OneLogin\Saml2\Settings;

class PhpSamlOneLogin implements PhpSamlInterface
{
    private $idpName = null;
    private $settings = null;

    private $auth;
    private $authRequestID;
    private $settingsHelper;
    private $oneloginSettings;
    private $userdata;

    function __construct($idpName = null, $settings)
    {
        $this->idpName = $idpName ?? "testenv2";     
        $this->settings = $settings;
        $this->init();
    }

    private function init()
    {
        $settingsHelper = new OneloginSamlConfig();
        $this->settingsHelper = $settingsHelper;
        if (!is_null($this->settings)) {
            $diff = ArrayHelper::array_diff_key_recursive($this->settings, get_object_vars($settingsHelper));
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
            $settingsHelper->updateSettings($this->settings);
        }
        
        $this->settingsHelper->updateIdpMetadata($this->idpName);
        $this->oneloginSettings = new Settings($this->settingsHelper->getSettings());
        $this->auth = new Auth($this->settingsHelper->getSettings());
    }

    private function changeIdp($idpName)
    {
        if ($this->idpName != $idpName) {
            $this->idpName = $idpName;
            $this->init();
        }
    }

    public function getSPMetadata()
    {
        $oneloginSettings = new Settings($this->settingsHelper->getSettings());
        $metadata = $oneloginSettings->getSPMetadata();
        
        $errors = $oneloginSettings->validateMetadata($metadata);
        if (!empty($errors)) {
            throw new OneLogin_Saml2_Error(
                'Invalid SP metadata: '.implode(', ', $errors),
                OneLogin_Saml2_Error::METADATA_SP_INVALID
            );
        }
        return $metadata;
    }

    public function getSupportedIdps()
    {
        return array();
    }

    public function isAuthenticated()
    {
        if (isset($_SESSION) && isset($_SESSION['idpName'])) {
            $this->changeIdp($_SESSION['idpName']);
            $this->authRequestID = $_SESSION['authReqID'];
        }

        if (isset($_SESSION) && isset($_SESSION['LogoutRequestID'])) {
            $this->auth->processSLO(false, $_SESSION['LogoutRequestID']);
            unset($_SESSION['LogoutRequestID']);

            $errors = $this->auth->getErrors();
            if (!empty($errors)) {
                return $errors;
            }
            return false;
        }

        if (isset($_SESSION['authReqID']) && isset($_POST['SAMLResponse'])) {
            $this->auth->processResponse($_SESSION['authReqID']);
            unset($_SESSION['authReqID']);
            $errors = $this->auth->getErrors();

            if (!empty($errors)) {
                return $errors;
            }

            $this->userdata = array();
            $this->userdata['samlUserdata'] = $this->auth->getAttributes();
            $this->userdata['samlNameId'] = $this->auth->getNameId();
            $this->userdata['samlNameIdFormat'] = $this->auth->getNameIdFormat();
            $this->userdata['samlSessionIndex'] = $this->auth->getSessionIndex();
            $_SESSION['userdata'] = $this->userdata;

        }
        if ($this->auth->isAuthenticated() === false) {
            return false;
        }
        return true;
    }

    public function login( $idpName, $redirectTo = '', $level = 1 )
    {
        $this->changeIdp($idpName);

        if ($this->auth->isAuthenticated()) {
            return false;
        }
        
        $ssoBuiltUrl = $this->auth->login($redirectTo, array(), false, false, true);

        $this->authRequestID = $this->auth->getLastRequestID();
        $_SESSION['authReqID'] = $this->auth->getLastRequestID();
        $_SESSION['idpName'] = $idpName;

        header('Pragma: no-cache');
        header('Cache-Control: no-cache, must-revalidate');
        header('Location: ' . $ssoBuiltUrl);
        exit();
    }

    public function logout()
    {
        if ($this->auth->isAuthenticated() === false) {
            return false;
        }
        $this->auth->logout();

        $sloBuiltUrl = $this->auth->logout(null, array(), null, null, true);
        $_SESSION['LogoutRequestID'] = $this->auth->getLastRequestID();
        
        header('Pragma: no-cache');
        header('Cache-Control: no-cache, must-revalidate');
        header('Location: ' . $sloBuiltUrl);
        exit();
    }

    public function getAttributes()
    {
        return $this->userdata;
    }

}