<?php

class PhpSaml implements PhpSamlInterdface
{

    private $phpSaml = null;

    public function __construct($idpUrl, $settings = null, $mode = 'onelogin')
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        switch ($mode) {
            case 'onelogin':
                $this->phpSaml = new PhpSamlOneLogin($idpUrl, $settings);
                break;
            default:
                $this->phpSaml = new PhpSamlOneLogin($idpUrl, $settings);
                break;
        }
    }

    public function isAuthenticated()
    {
        $this->phpSaml->isAuthenticated();
    }

    public function login()
    {
        $this->phpSaml->login();
    }
    
    public function logout()
    {
        $this->phpSaml->logout();
    }

}