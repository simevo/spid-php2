<?php

$base = "http://spid.test.com";
$settings = [
        'spBaseUrl' => $base,
        'spEntityId' => $base."/metadata.php",
        'spKeyFile' => __DIR__ . "/../sp.key",
        'spCrtFile' => __DIR__ . "/../sp.crt",
        'spAcsUrl' => $base."/index.php?acs",
        'spSloUrl' => $base."/index.php?slo"
    ];
