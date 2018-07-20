<?php

class OneloginSamlConfig
{
    // Default values SP
    private $spBaseUrl = null;
    private $spKeyFile = 'sp.key';
    private $spCrtFile = 'sp.crt';
    private $spAcsUrl = null;
    private $spSloUrl = null;
    // Default values IDP
    private $idpEntityId = null;
    private $idpSSO = null;
    private $idpSLO = null;
    private $idpCertFile = null;

    function __construct()
    {
        // Default values
        $this->spAcsUrl = $this->spBaseUrl . '/index.php?acs';
        $this->spSloUrl = $this->spBaseUrl . '/index.php?sls';
    }

    public function getSettings()
    {
        return $defaultSettings = array(
            // If 'strict' is True, then the PHP Toolkit will reject unsigned
            // or unencrypted messages if it expects them to be signed or encrypted.
            // Also it will reject the messages if the SAML standard is not strictly
            // followed: Destination, NameId, Conditions ... are validated too.
            'strict' => false,
    
            // Enable debug mode (to print errors).
            'debug' => true,

            'sp' => array(
                'entityId' => $spBaseUrl . '/metadata.php',
                'assertionConsumerService' => array(
                    'url' => $spAcsUrl,
                ),
                'singleLogoutService' => array(
                    'url' => $spSloUrl,
                ),
                'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
                'x509cert' => $spCrtFile,
                'privateKey' => $spKeyFile,
            ),
            'idp' => array(
                'entityId' => $idpEntityId,
                'singleSignOnService' => array(
                    'url' => $idpSSO,
                ),
                'singleLogoutService' => array(
                    'url' => $idpSLO,
                ),
                'x509cert' => $idpCertFile,
            ),
            'security' => array(
                'authnRequestsSigned' => true,
                'logoutRequestSigned' => true,
                'logoutResponseSigned' => true,
                'signMetadata' => true,
                'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
                'requestedAuthnContext' => array('https://www.spid.gov.it/SpidL1'),
            ),
        );
    }

    public function updateSettings($settings) {
        foreach ($settings as $key => $value) {
            if (property_exists($key) && strpos("idp", $key) === false) {
                $this->{$key} = $value;
            }
        }
        return $this->getSettings();
    }

    public function updateIdpMetadata($metadata) {
        foreach ($metadata as $key => $value) {
            if (property_exists($key) && strpos("idp", $key) !== false) {
                $this->{$key} = $value;
            }
        }
        return $this->getSettings();
    }
}