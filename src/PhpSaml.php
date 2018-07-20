<?php

class PhpSaml {

    private $php_saml = null;

    public function __construct($settings = null, $mode = 'onelogin') {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        switch ($mode) {
            case 'onelogin':
                $this->php_saml = new PhpSamlOneLogin($settings);
                break;
            default:
                $this->php_saml = new PhpSamlOneLogin($settings);
                break;
        }
    }

}