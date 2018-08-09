<?php

namespace SpidPHP\Helpers;

class IdpHelper
{
    public static function getMetadata($idpName, $folder)
    {
        $fileName = $folder . DIRECTORY_SEPARATOR . $idpName . ".xml";
        if (!file_exists($fileName)) {
            throw new \Exception("Metadata file $fileName not found", 1);
        }
        
        $xml = simplexml_load_file($fileName);
        
        $xml->registerXPathNamespace('md', 'urn:oasis:names:tc:SAML:2.0:metadata');
        $xml->registerXPathNamespace('ds', 'http://www.w3.org/2000/09/xmldsig#');

        $metadata = array();
        $metadata['idpEntityId'] = $xml->attributes()->entityID->__toString();
        $metadata['idpSSO'] = $xml->xpath('//md:SingleSignOnService')[0]->attributes()->Location->__toString();
        $metadata['idpSLO'] = $xml->xpath('//md:SingleLogoutService')[0]->attributes()->Location->__toString();
        $metadata['idpCertValue'] = $xml->xpath('//ds:X509Certificate')[0]->__toString();
         
        return $metadata;
    }
}