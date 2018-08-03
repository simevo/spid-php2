<?php
namespace SpidPHP;

use SpidPHP\Strategy\Interfaces\PhpSamlInterface;
use SpidPHP\Strategy\PhpSamlOneLogin;

class SpidPHP implements PhpSamlInterface
{

    private $phpSaml = null;
    private $mode = null;
    private $settings = null;

    public function __construct($settings = null, $mode = 'onelogin')
    {   
        session_start();
        $this->mode = $mode;
        $this->settings = $settings;
    }

    private function initStrategy($idpName = null)
    {
        switch ($this->mode) {
            case 'onelogin':
                $this->phpSaml = new PhpSamlOneLogin($idpName, $this->settings);
                break;
            default:
                $this->phpSaml = new PhpSamlOneLogin($idpName, $this->settings);
                break;
        }
    }

    public function getSPMetadata()
    {
        if (is_null($this->phpSaml)) $this->initStrategy();
        return $this->phpSaml->getSPMetadata();
    }

    public function getSupportedIdps()
    {
        if (is_null($this->phpSaml)) return array();
        return $this->phpSaml->getSupportedIdps();
    }

    public function isAuthenticated()
    {   
        if (isset($_SESSION['idpName']) && is_null($this->phpSaml)) $this->initStrategy($_SESSION['idpName']);
        if (is_null($this->phpSaml)) return false;
        return $this->phpSaml->isAuthenticated();
    }

    public function login( $idpName, $redirectTo = '', $level = 1 )
    {   
        if (is_null($this->phpSaml)) $this->initStrategy($idpName);
        return $this->phpSaml->login($idpName, $redirectTo);
    }
    
    public function logout()
    {
        if (isset($_SESSION['idpName']) && is_null($this->phpSaml)) $this->initStrategy($_SESSION['idpName']);
        if (is_null($this->phpSaml)) return false;
        return $this->phpSaml->logout();
    }

    public function getAttributes()
    {   
        if (is_null($this->phpSaml)) return false;
        return $this->phpSaml->getAttributes();
    }

}