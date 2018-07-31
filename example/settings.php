<?php

$base = "http://sp2.simevo.com:8000";
$settings = [
        'spBaseUrl' => $base,
        'spEntityId' => $base."/metadata.php",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
        'spAcsUrl' => $base."/acs.php",
        'spSloUrl' => $base."/logout.php"
    ];
