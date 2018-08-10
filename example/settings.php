<?php

$base = "http://sp2.simevo.com:8000";
$home = "/srv/spid-php2";
$settings = [
        'spBaseUrl' => $base,
        'spEntityId' => $base,
        'spKeyFile' => $home . "/sp.key",
        'spCrtFile' => $home . "/sp.crt",
        'spAcsUrl' => $base . "/acs.php",
        'spSloUrl' => $base . "/logout.php",
        'idpMetadataFolderPath' => $home . "/idp_metadata",
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
