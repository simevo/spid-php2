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
        if ( $auth->isAuthenticated ) {
            return;
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

        if (isset($_POST['RelayState']) && OneLogin_Saml2_Utils::getSelfURL() != $_POST['RelayState']) {
            $auth->redirectTo($_POST['RelayState']);
        }

        $attributes = $_SESSION['samlUserdata'];
        $nameId = $_SESSION['samlNameId'];

        echo '<h1>Identified user: '. htmlentities($nameId) .'</h1>';

        if (!empty($attributes)) {
            echo '<h2>'._('User attributes:').'</h2>';
            echo '<table><thead><th>'._('Name').'</th><th>'._('Values').'</th></thead><tbody>';
            foreach ($attributes as $attributeName => $attributeValues) {
                echo '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
                foreach ($attributeValues as $attributeValue) {
                    echo '<li>' . htmlentities($attributeValue) . '</li>';
                }
                echo '</ul></td></tr>';
            }
            echo '</tbody></table>';
        } else {
            echo _('No attributes found.');
        }
    }

    function logout()
    {               
        if (isset($_GET['sso'])) {    // SSO action.  Will send an AuthNRequest to the IdP
        $auth->login();
        } else if (isset($_GET['sso2'])) {              // Another SSO action
        $returnTo = $spBaseUrl.'/demo1/attrs.php';  // but set a custom RelayState URL
        $auth->login($returnTo);
        } else if (isset($_GET['slo'])) {  // SLO action. Will sent a Logout Request to IdP
        $auth->logout();
        } else if (isset($_GET['acs'])) {  // Assertion Consumer Service
        $auth->processResponse();      // Process the Response of the IdP, get the
                    // attributes and put then at
                    // $_SESSION['samlUserdata']

        $errors = $auth->getErrors();  // This method receives an array with the errors
                    // that could took place during the process

        if (!empty($errors)) {
        echo '<p>', implode(', ', $errors), '</p>';
        }
                            // This check if the response was
        if (!$auth->isAuthenticated()) {      // sucessfully validated and the user
        echo "<p>Not authenticated</p>";  // data retrieved or not
        exit();
        }

        $_SESSION['samlUserdata'] = $auth->getAttributes(); // Retrieves user data
        if (isset($_POST['RelayState']) && OneLogin_Saml2_Utils::getSelfURL() != $_POST['RelayState']) {
        $auth->redirectTo($_POST['RelayState']);  // Redirect if there is a
        }                                             // relayState set
        } else if (isset($_GET['sls'])) {   // Single Logout Service
        $auth->processSLO();            // Process the Logout Request & Logout Response
        $errors = $auth->getErrors(); // Retrieves possible validation errors
        if (empty($errors)) {
        echo '<p>Sucessfully logged out</p>';
        } else {
        echo '<p>', implode(', ', $errors), '</p>';
        }
        }

        if (isset($_SESSION['samlUserdata'])) {   // If there is user data we print it.
        if (!empty($_SESSION['samlUserdata'])) {
        $attributes = $_SESSION['samlUserdata'];
        echo 'You have the following attributes:<br>';
        echo '<table><thead><th>Name</th><th>Values</th></thead><tbody>';
        foreach ($attributes as $attributeName => $attributeValues) {
        echo '<tr><td>' . htmlentities($attributeName) . '</td><td><ul>';
        foreach ($attributeValues as $attributeValue) {
        echo '<li>' . htmlentities($attributeValue) . '</li>';
        }
        echo '</ul></td></tr>';
        }
        echo '</tbody></table>';
        } else {                             // If there is not user data, we notify
        echo "<p>You don't have any attribute</p>";
        }

        echo '<p><a href="?slo" >Logout</a></p>'; // Print some links with possible
        } else {                                      // actions
        echo '<p><a href="?sso" >Login</a></p>';
        echo '<p><a href="?sso2" >Login and access to attrs.php page</a></p>';
        }
    }

}