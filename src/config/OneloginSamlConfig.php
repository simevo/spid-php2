<?php

class OneloginSamlConfig
{
    // Default values
    var $spBaseUrl = '';
    var $idpEntityId = '';
    var $spAcsUrl = null;
    var $spSloUrl = null;
    var $idpSSO = null;
    var $idpSLO = null;
    var $spKeyFile = 'sp.key';
    var $spCrtFile = 'sp.crt';
    var $idpCertFile = '';

    function __construct()
    {
        $this->spAcsUrl = $this->spBaseUrl . '/index.php?acs';
        $this->spSloUrl = $this->spBaseUrl . '/index.php?sls';
        $this->idpSSO = $this->idpEntityId . '/sso';
        $this->idpSLO = $this->idpEntityId . '/slo';
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
        
    }
}