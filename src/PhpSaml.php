<?php

class PhpSaml implements PhpSamlInterface {

    private $php_saml = null;

    public function __construct($settings, $mode = 'onelogin') {
        switch ($variable) {
            case 'onelogin':
                $this->php_saml = new PhpSamlOneLogin($settings);
                break;
            default:
                $this->php_saml = new PhpSamlOneLogin($settings);
                break;
        }
    }

}