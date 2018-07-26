<?php

namespace SpidPHP\Helpers;

class IdpHelper
{
    public static function getMetadata($idpName)
    {
        if (!file_exists("../config/idp/" . $idpName)) {
            throw new Exception("Invalid IDP Requested", 1);
        }
        $xml = simplexml_load_file("../config/idp/" . $idpName . '.xml');
        $metadata = array();
        $metadata['idp_entityid'] = $xml->xpath('//ns0:EntityDescriptor/@entityID')[0];
        $metadata['idp_sso'] = $xml->xpath('//ns0:SingleSignOnService/@Location')[0];
        $metadata['idp_slo'] = $xml->xpath('//ns0:SingleLogoutService/@Location')[0];
        $metadata['idp_cert'] = $xml->xpath('//ns1:X509Certificate')[0];
        
        return $metadata;
    }
}