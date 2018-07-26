<?php

class SpHelper
{
    public static function getSpCert($sp_key_file, $sp_cert_file)
    {
        $sp_key_raw = file_get_contents($sp_key_file);
        $sp_cert_raw = file_get_contents($sp_cert_file);

        $sp = array();
        $sp['key'] = self::cleanOpenSsl($sp_key_raw);
        $sp['cert'] = self::cleanOpenSsl($sp_cert_raw);
        return $sp;
    }

    private static function cleanOpenSsl($k)
    {
        $ck = '';
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $k) as $l) {
            if (strpos($l, '-----') === false) {
                $ck .= $l;
            }
        }
        return $ck;
    }
}

