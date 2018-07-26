<?php

namespace SpidPHP;

use SpidPHP\Strategy\Interfaces\PhpSamlInterface;
use SpidPHP\Strategy\PhpSamlOneLogin;

class PhpSaml implements PhpSamlInterface
{

    private $phpSaml = null;
    private $mode = null;
    private $settings = null;

    public function __construct($settings = null, $mode = 'onelogin')
    {
        /*
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        */

        $this->mode = $mode;
        $this->settings = $settings;
    }

    private function initStrategy()
    {
        switch ($this->mode) {
            case 'onelogin':
                $this->phpSaml = new PhpSamlOneLogin($this->settings);
                break;
            default:
                $this->phpSaml = new PhpSamlOneLogin($this->settings);
                break;
        }
    }

    public function getSupportedIdps()
    {
        return array();
    }

    public function isAuthenticated()
    {
        $this->phpSaml->isAuthenticated();
    }

    public function login( $idpName, $redirectTo = null, $level = 1 )
    {   
        $this->phpSaml->login();
    }
    
    public function logout()
    {
        $this->phpSaml->logout();
    }

}