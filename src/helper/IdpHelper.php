<?php

class IdpHelper
{
    public static function getMetadata($idpUrl)
    {
        // Check if a file containing this idp metadata already exists
        $idpName = str_replace(".", "_", parse_url($idpUrl, PHP_URL_HOST));
        if (file_exists("../config/idp/" . $idpName)) {
            $metadata = file_get_contents("../config/idp/" . $idpName);
            return $metadata;
        }

        // File doesn't exist yet, get metadata from idp url and save it to file
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $idpUrl);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        $xml = new SimpleXMLElement($data);
        $metadata = array();
        $metadata['idp_entityid'] = $xml->xpath('//ns0:EntityDescriptor/@entityID')[0];
        $metadata['idp_sso'] = $xml->xpath('//ns0:SingleSignOnService/@Location')[0];
        $metadata['idp_slo'] = $xml->xpath('//ns0:SingleLogoutService/@Location')[0];
        $metadata['idp_cert'] = $xml->xpath('//ns1:X509Certificate')[0];

        file_put_contents("../config/idp/" . $idpName, print_r($metadata, true));

        return $metadata;
    }
}