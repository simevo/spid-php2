<?php

namespace SpidPHP;

use SpidPHP\Strategy\Interfaces\PhpSamlInterface;
use SpidPHP\Strategy\PhpSamlOneLogin;

class PhpSaml implements PhpSamlInterface
{

    private $phpSaml = null;

    public function __construct($idpName, $settings = null, $mode = 'onelogin')
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        switch ($mode) {
            case 'onelogin':
                $this->phpSaml = new PhpSamlOneLogin($idpName, $settings);
                break;
            default:
                $this->phpSaml = new PhpSamlOneLogin($idpName, $settings);
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