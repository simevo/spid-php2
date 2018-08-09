<?php

$base = "http://sp2.simevo.com:8000";
$settings = [
        'spBaseUrl' => $base,
        'spEntityId' => $base."/metadata.php",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
        'spAcsUrl' => $base."/acs.php",
        'spSloUrl' => $base."/logout.php",
        'idpMetadataFolderPath' => "/srv/spid-php2/idp_metadata",
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
