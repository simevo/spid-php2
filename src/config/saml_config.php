<?php
    // Default values
    $spBaseUrl = '';
    $idpEntityId = '';
    $idpSSO= $idpEntityId . '/sso';
    $idpSLO = $idpEntityId . '/slo';

    $settingsInfo = array (
        // If 'strict' is True, then the PHP Toolkit will reject unsigned
        // or unencrypted messages if it expects them to be signed or encrypted.
        // Also it will reject the messages if the SAML standard is not strictly
        // followed: Destination, NameId, Conditions ... are validated too.
        'strict' => false,

        // Enable debug mode (to print errors).
        'debug' => true,

        'sp' => array (
            'entityId' => $spBaseUrl . '/metadata.php',
            'assertionConsumerService' => array (
                'url' => $spBaseUrl . '/index.php?acs',
            ),
            'singleLogoutService' => array (
                'url' => $spBaseUrl . '/index.php?sls',
            ),
            'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
            'x509cert' => '{{sp_cert}}',
            'privateKey' => '{{sp_key}}',
        ),
        'idp' => array (
            'entityId' => $idpEntityId,
            'singleSignOnService' => array (
                'url' => $idpSSO,
            ),
            'singleLogoutService' => array (
                'url' => $idpSLO,
            ),
            'x509cert' => '{{idp_cert}}',
        ),
        'security' => array (
            'authnRequestsSigned' => true,
            'logoutRequestSigned' => true,
            'logoutResponseSigned' => true,
            'signMetadata' => true,
            'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
            'requestedAuthnContext' => array('https://www.spid.gov.it/SpidL1'),
        ),
    );
