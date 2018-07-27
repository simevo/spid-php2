<?php

/**
 *  SAML Handler
 */

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/settings.php");

use SpidPHP\SpidPHP;


echo '<p><a href="login.php" >Login</a></p>';
echo '<p><a href="metadata.php" >Show the SP metadata</a></p>';



/*
if (isset($_GET['sso'])) {
    $result = $onelogin->login("testenv2");
    print_r($result);
} elseif (isset($_GET['slo'])) {
    $onelogin->logout();
} elseif (isset($_GET['acs'])) {
    if (isset($_SESSION) && isset($_SESSION['AuthNRequestID'])) {
        $requestID = $_SESSION['AuthNRequestID'];
    } else {
        $requestID = null;
    }
    $auth->processResponse($requestID);
    $errors = $auth->getErrors();
    if (!empty($errors)) {
        echo '<p>' . implode(', ', $errors) . '</p>';
    }
    if (!$auth->isAuthenticated()) {
        echo '<p>Not authenticated</p>';
        exit();
    }
    $_SESSION['samlUserdata'] = $auth->getAttributes();
    $_SESSION['samlNameId'] = $auth->getNameId();
    $_SESSION['samlNameIdFormat'] = $auth->getNameIdFormat();
    $_SESSION['samlSessionIndex'] = $auth->getSessionIndex();
    unset($_SESSION['AuthNRequestID']);
    if (isset($_POST['RelayState']) && OneLogin_Saml2_Utils::getSelfURL() != $_POST['RelayState']) {
        $auth->redirectTo($_POST['RelayState']);
    }
} elseif (isset($_GET['sls'])) {
    if (isset($_SESSION) && isset($_SESSION['LogoutRequestID'])) {
        $requestID = $_SESSION['LogoutRequestID'];
    } else {
        $requestID = null;
    }
    $auth->processSLO(false, $requestID);
    $errors = $auth->getErrors();
    if (empty($errors)) {
        echo '<p>Sucessfully logged out</p>';
    } else {
        echo '<p>' . implode(', ', $errors) . '</p>';
    }
}
if (isset($_SESSION['samlUserdata'])) {
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
    } else {
        echo "<p>You don't have any attribute</p>";
    }
    echo '<p><a href="?slo" >Logout</a></p>';
} else {
    echo '<p><a href="?sso" >Login</a></p>';
    echo '<p><a href="?sso2" >Login and access to attrs.php page</a></p>';
    echo '<p><a href="metadata.php" >Show the SP metadata</a></p>';
}
*/