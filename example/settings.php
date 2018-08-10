<?php

$base = "http://sp2.simevo.com:8000";
$home = "/srv/spid-php2";
$settings = [
        'spEntityId' => $base, // preferred: https protocol, no path, no trailing slash
        'spAcsUrl' => $base . "/acs.php", // full url
        'spSloUrl' => $base . "/logout.php", // full url
        'spKeyFile' => $home . "/sp.key", // full path
        'spCrtFile' => $home . "/sp.crt", // full path
        'idpMetadataFolderPath' => $home . "/idp_metadata", // full path
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
