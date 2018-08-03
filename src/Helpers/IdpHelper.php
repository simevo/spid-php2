<?php

namespace SpidPHP\Helpers;

class IdpHelper
{
    public static function getMetadata($idpName, $folder)
    {
        if (!file_exists(Constants::APP_PATH . $folder . $idpName . ".xml")) {
            throw new \Exception("Invalid IDP Requested", 1);
        }
        
        $xml = simplexml_load_file(Constants::APP_PATH . $idpName . '.xml');
        
        $metadata = array();
        $metadata['idpEntityId'] = $xml->attributes()->entityID->__toString();
        $metadata['idpSSO'] = $xml->xpath('//SingleSignOnService')[0]->attributes()->Location->__toString();
        $metadata['idpSLO'] = $xml->xpath('//SingleLogoutService')[0]->attributes()->Location->__toString();
        $metadata['idpCertValue'] = $xml->xpath('//X509Certificate')[0]->__toString();
         
        return $metadata;
    }
}