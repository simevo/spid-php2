<?php

    $settingsInfo = array (
        // If 'strict' is True, then the PHP Toolkit will reject unsigned
        // or unencrypted messages if it expects them to be signed or encrypted.
        // Also it will reject the messages if the SAML standard is not strictly
        // followed: Destination, NameId, Conditions ... are validated too.
        'strict' => false,

        // Enable debug mode (to print errors).
        'debug' => true,

        'sp' => array (
            'entityId' => '{{sp_base}}/metadata.php',
            'assertionConsumerService' => array (
                'url' => '{{sp_base}}/index.php?acs',
            ),
            'singleLogoutService' => array (
                'url' => '{{sp_base}}/index.php?sls',
            ),
            'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
            'x509cert' => '{{sp_cert}}',
            'privateKey' => '{{sp_key}}',
        ),
        'idp' => array (
            'entityId' => '{{idp_entityid}}',
            'singleSignOnService' => array (
                'url' => '{{idp_sso}}',
            ),
            'singleLogoutService' => array (
                'url' => '{{idp_slo}}',
            ),
            'x509cert' => '{{idp_cert}}',
        ),
    );
