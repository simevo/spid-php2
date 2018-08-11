<?php

$base = "https://sp.example.com";

$settings = [
        'spEntityId' => $base, // preferred: https protocol, no path, no trailing slash
        'spAcsUrl' => $base . "/acs.php", // full url
        'spSloUrl' => $base . "/logout.php", // full url
        'spKeyFile' => "./sp.key", // full or relative path
        'spCrtFile' => "./sp.crt", // full or relative path
        'idpMetadataFolderPath' => "./idp_metadata", // full or relative path
        // for each item in the idpList array, a file with the same name and xml extension
        // must be present in the idpMetadataFolderPath directory
        'idpList' => array(
            'idp_1',
            'idp_2',
            'idp_3',
            'idp_4',
            'idp_5',
            'idp_6',
            'idp_7',
            'idp_8',
            'testenv2'
        )
    ];
