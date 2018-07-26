<?php

namespace SpidPHP\Helpers;

class IdpHelper
{
    public static function getMetadata($idpName)
    {
        if (!file_exists(__DIR__ . "/../config/idp/" . $idpName . ".xml")) {
            throw new \Exception("Invalid IDP Requested", 1);
        }
        $xml = simplexml_load_file(__DIR__ . "/../config/idp/" . $idpName . '.xml');
        
        $metadata = array();
        $metadata['idpEntityId'] = $xml->attributes()->entityID;
        $metadata['idpSSO'] = $xml->xpath('//SingleSignOnService')[0]->attributes()->Location;
        $metadata['idpSLO'] = $xml->xpath('//SingleLogoutService')[0]->attributes()->Location;
        $metadata['idpCertValue'] = $xml->xpath('//X509Certificate')[0];
        
        return $metadata;
    }
}